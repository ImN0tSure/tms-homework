<?php

ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';

echo "<pre>";

//<editor-fold desc="есть отрезок $array = [[1,3], [9,10], [2,7]]. необходимо найти общие пересечения и соединить их">

$array = [[1, 3], [12, 15], [9, 10], [9, 11], [21, 30], [9, 10], [2, 7], [2, 8], [9, 11], [14, 20], [15, 19], [3, 4], [3, 5]];
/*
* Шаг 1. Функция сортирует массив по возрастанию, по первому значению в подмоссиве (начало отрезка).
*/
function sortFromLowToHigh($arr1, $arr2): int
{
    if ($arr1[0] > $arr2[0]) {
        return 1;
    } else {
        return -1;
    }
}

/*
* Шаг 2. Если последующий отрезок входит в текущий, функция убирает из массива последующий отрезок.
*/
function consumeTheSmallest($array): array
{
    for ($i = 0; $i < count($array) - 1; $i++) {
        if ($array[$i][0] <= $array[$i + 1][0] && $array[$i][1] >= $array[$i + 1][1]) {
            array_splice($array, $i + 1, 1);
            $i--;
        }
    }

    return $array;
}

/*
* Шаг 3. Если отрезки пересекаются, функция объединяет их в один с наименьшим началом координат и наибольшим концом координат.
*/
function combineTheRest($array)
{
    for ($i = 0; $i < count($array) - 1; $i++) {

        if ($array[$i][1] >= $array[$i + 1][0]) {
            $array[$i][1] = $array[$i + 1][1];
            array_splice($array, $i + 1, 1);
            $i--;
        }
    }

    return $array;
}

/*
* Шобы не писать 3 функции, объединяем всё в одну.
*/
function uniteSegments($array)
{
    usort($array, 'sortFromLowToHigh');

    $array = consumeTheSmallest($array);
    $array = combineTheRest($array);

    return $array;
}

echo "Исходный массив<br>";
print_r($array);

br();

$array = uniteSegments($array);

echo "Итоговый массив<br>";
print_r($array);

//</editor-fold>