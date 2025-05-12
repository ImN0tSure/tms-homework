<?php

namespace ORM;

use PDO;

abstract class ORM
{
    protected static ?PDO $db = null;

    protected static string $table;

    private static ?ORM $instance = null;

    protected function __construct()
    {
        if (self::$db === null) {
            self::$db = require_once 'config.php';
        }
    }

    abstract static protected function setTable();

    public static function all(): array
    {
        $stmt = self::$db->prepare('SELECT * FROM ' . static::$table);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function selectById(int $id)
    {
        $stmt = self::$db->prepare('SELECT * FROM ' . static::$table . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
     * Example of $where array:
     * [
     *  'id' => 1,
     *  'product_name' => 'apple',
     *  'e-mail' => 'test@test.tst'
     * ]
     */
    public static function selectWhere(array $where): array
    {
        $condition = self::prepareWhereCondition($where);

        $stmt = self::$db->prepare('SELECT * FROM ' . static::$table . ' WHERE ' . $condition);
        $stmt->execute($where);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
     * Example of $data array:
     * [
     *  'id' => 1,
     *  'product_name' => 'apple',
     *  'e-mail' => 'test@test.tst'
     * ]
     */
    public static function insert(array $data): string
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $stmt = self::$db
            ->prepare('INSERT INTO ' . static::$table . ' (' . $columns . ') VALUES (' . $values . ')');
        $stmt->execute($data);

        return self::$db->lastInsertId();
    }

    /*
     * Example of $data array:
     * [
     *  'id' => 1,
     *  'product_name' => 'apple',
     *  'e-mail' => 'test@test.tst'
     * ]
     *
     * !!!WARNING!!! This 'update' function is unsuitable for finding and substituting of the same value.
     */
    public static function update(array $data, array|int $where = 1): array|bool
    {
        if (array_intersect_key($data, $where)) {
            return [
                'error' => [
                    'code' => 1,
                    'message' => 'This "update" function is unsuitable for finding and substituting of the same value.
                    Please, use custom update request.'
                ],
            ];
        }

        $prepared_data = [];

        foreach ($data as $table => $value) {
            $prepared_data[] = '`' . $table . '` = :' . $table;
        }

        $set = implode(',', $prepared_data);

        $condition = is_array($where) ? self::prepareWhereCondition($where) : $where;

        $stmt = self::$db->prepare('UPDATE ' . self::$table . ' SET ' . $set . ' WHERE ' . $condition);
        return $stmt->execute(array_merge($data, $where));
    }

    private static function prepareWhereCondition(array $where): string
    {
        $prepared_where = [];
        foreach ($where as $subj => $value) {
            $prepared_where[] = $subj . ' = :' . $subj;
        }

        return implode(' AND ', $prepared_where);
    }

    public function getTable(): string
    {
        return self::$table;
    }

    public static function getInstance(): ORM
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        static::setTable();
        return self::$instance;
    }

}
