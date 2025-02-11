<?php
ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';
echo "<pre style='font-size: 15px; font-family: Times New Roman, Times, serif;'>";

//<editor-fold desc="Задание 1. Используйте array_map() для применения функции к каждому элементу массива (например, увеличить каждое число на 10).">
print_r("Задание 1.");
br();

function multiTen($num): int
{
    return $num * 10;
}

$array = [1, 2, 3, 4];
echo 'Было: ';
print_r($array);

br();

$new_array = array_map('multiTen', $array);
echo 'Стало: ';
print_r($new_array);

hr();
//</editor-fold>

//<editor-fold desc="Задание 2. Используйте функцию array_filter() для фильтрации массива чисел (например, оставить только четные числа).">
print_r("Задание 2.");
br();

function filterOdds($number)
{
    if ($number % 2 != 0) {
        return true;
    } else {
        return false;
    }
}

$array = [1, 2, 3, 4, 5, 6, 7, 8, 9];

echo "Было: ";
print_r($array);
br();
echo "Стало: ";
print_r(array_filter($array, 'filterOdds'));

hr();
//</editor-fold>

//<editor-fold desc="Задание 3. Используйте array_chunk() для разбиения массива на части.">
print_r("Задание 3.");
br();

$array = [
    1,
    2,
    'dva' => 'tri',
    'tri' => ['nol' => 'odin'],
];
echo "Было: ";
print_r($array);
br();
echo "Стало: ";
print_r(array_chunk($array, 2, true));

hr();
//</editor-fold>

//<editor-fold desc="Задание 4. Используйте функцию in_array() для проверки наличия элемента в массиве.">
print_r("Задание 4.");
br();

$array = ['hay', 'hay', 'hay', 'niddle', 'hay', 'hay'];

echo "Массив: ";
print_r($array);
br();
echo "Результат in_array('niddle'): ";
var_dump(in_array('niddle', $array));

hr();
//</editor-fold>

//<editor-fold desc="Задание 5. Используйте цикл foreach для вывода всех данных о студентах.($student - только имя и фамилию).">
print_r("Задание 5.");
br();

$students = [
    [
        'name' => 'Yasha 1',
        'email' => 'yasha@yasha.ru',
        'phone' => '+7(999)999-99-99',
        'age' => 23,
    ],
    [
        'name' => 'Yasha 2',
        'surname' => 'Ivanov',
        'email' => 'yasha@yasha.ru',
        'age' => 21,
    ],
    [
        'name' => 'Yasha 3',
        'email' => 'yasha@yasha.ru',
        'age' => 26,
    ],
];

echo "Список студентов:<br>";
foreach ($students as $student) {
    if (isset($student['name'])) {
        echo $student['name'] . " ";
    }

    if (isset($student['surname'])) {
        echo $student['surname'];
    }

    echo "<br>";

}

hr();
//</editor-fold>

//<editor-fold desc="Задание 6. Отфильтруйте $student по возрасту.">
print_r("Задание 6.");
br();

$students = [
    [
        'name' => 'Yasha 1',
        'email' => 'yasha@yasha.ru',
        'phone' => '+7(999)999-99-99',
        'age' => 23,
    ],
    [
        'name' => 'Yasha 2',
        'surname' => 'Ivanov',
        'email' => 'yasha@yasha.ru',
        'age' => 21,
    ],
    [
        'name' => 'Yasha 3',
        'email' => 'yasha@yasha.ru',
        'age' => 26,
    ],
    [
        'name' => 'Yasha 3',
        'email' => 'yasha@yasha.ru',
        'age' => 36,
    ],
];

function sortByAge($array, $order = true) //$order может принимать значения "true" (отсортирует от меньшего к большему) и "false" (отсортирует от большего к меньшему)
{
    $buffer_array = [];

    foreach ($array as $key => $value) {
        if (!key_exists('age', $value)) {
            return "WARNING! ARRAY can't be sorted by age.";
        }
        $buffer_array[$value['age']] = [$key => $value];
    }

    if ($order) {
        ksort($buffer_array);
    } else {
        krsort($buffer_array);
    }

    $result_array = [];

    foreach ($buffer_array as $data_array) {
        $data_array_key = array_key_first($data_array);
        $result_array [$data_array_key] = $data_array[$data_array_key];
    }

    return ($result_array);

}

print_r(sortByAge($students, false));

hr();
//</editor-fold>

//<editor-fold desc="Задание 7. Используйте implode и explode.">
print_r("Задание 7.");
br();

$string = 'W H O L E';

echo "Результат explode(): ";
$pieces = explode(" ", $string);
print_r($pieces);
br();
echo "Результат implode(): ";
$string = implode("-", $pieces);
print_r($string);

hr();
//</editor-fold>

//<editor-fold desc="Задание 8. Используйте json_encode и json_decode">
print_r("Задание 8.");
br();

echo "Делаем из массива json строку: ";
$json_string = json_encode($students);
print_r($json_string);
br();
echo "Возвращаем массив взад: ";
$php_array = json_decode($json_string, true);
print_r($php_array);

hr();
//</editor-fold>

//<editor-fold desc="Задание 9. реализовать 'Сортировка пузырьком'">
print_r("Задание 9.");
br();

$array = [1, 2, 3, 4, 2, 5, 6, 7, 2];
$array1 = [10, 6, 3, 2, 5, 7, 4];
$array2 = [
    'one' => 1,
    'three' => 3,
    'six' => 6,
    'four' => 4,
    'seven' => 7,
    'two' => 2,
    'five' => 5,
];

//<editor-fold desc="Вспомогательная функция для bubbleSortArray()">
/*
 * Функция проверяет, отсортирован ли массив по возрастанию значений.
 * Если массив отсортирован, возвращает true.
 * Если массив не отсортирован, возвращает false.
 */

function isArraySorted($array): bool
{

    foreach ($array as $value) {

        $next_value = next($array);

        if ($next_value !== false) {
            if ($next_value < $value) {
                return false;
            }
        }
    }

    return true;
}

//</editor-fold>

//<editor-fold desc="Функция сортирует массив по возрастанию/убыванию значений методом 'Сортировка пузырьком'">
/*
 * Переменная $order принимает значения true либо false.
 * Если значение переменной $order равняется true, массив будет отсортирован по возрастанию значений.
 * Если значение переменной $order равняется false, массив будет отсортирован по убыванию значений.
 */

function bubbleSortArr(array $array, bool $order = true): array
{
    $counter = 0;
    while (isArraySorted($array) !== true) {
        for ($i = 0; $i < count($array) - 1 - $counter; $i++)
        {
            $buffer_array = array_splice($array, $i); // Вырезает ещё не пройдённую часть массива в буферный массив.
            $elems_to_switch = array_splice($buffer_array, 0, 2); // Из буферного массива вырезаются 2 первых элемента.
            if (!isArraySorted($elems_to_switch)) // Проверяется, отсортированны ли 2 первых элемента по возрастанию.
            {
                $elems_to_switch = array_reverse($elems_to_switch); // Если нет, меняет элементы местами.
            }
            $buffer_array = array_merge($elems_to_switch, $buffer_array); // Вставляет ранее вырезанные элементы в начало буферного массива.
            $array = array_merge($array, $buffer_array); // Вставляет буферный массив в конец уже пройденной части.
        }

        $counter++;
    }

    if ($order)
    {
        return $array;
    }
    else
    {
        return array_reverse($array);
    }
}

//</editor-fold>

echo "Исходный массив<br>";
print_r($array2);
echo "Итоговый массив<br>";
print_r(bubbleSortArr($array2));

hr();
//</editor-fold>

?>