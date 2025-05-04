<?php

namespace ORM;

use PDO;

abstract class ORM
{
    protected static ?PDO $db = null;

    public function __construct()
    {
        if (self::$db === null) {
            self::$db = require_once 'config.php';
        }
    }

    public function setTable($table): void
    {
        static::$table = $table;
    }

    public static function all()
    {
        $stmt = static::$db->prepare('SELECT * FROM ' . static::$table);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function selectById(int $id)
    {
        $stmt = static::$db->prepare('SELECT * FROM ' . static::$table . ' WHERE id = :id');
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
        $condition = static::prepareWhereCondition($where);

        $stmt = static::$db->prepare('SELECT * FROM ' . static::$table . ' WHERE ' . $condition);
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

        $stmt = static::$db
            ->prepare('INSERT INTO ' . static::$table . ' (' . $columns . ') VALUES (' . $values . ')');
        $stmt->execute($data);

        return static::$db->lastInsertId();
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

        $condition = is_array($where) ? static::prepareWhereCondition($where) : $where;

        $stmt = static::$db->prepare('UPDATE ' . static::$table . ' SET ' . $set . ' WHERE ' . $condition);
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
        return static::$table;
    }

}
