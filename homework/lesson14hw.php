<?php
ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';

//<editor-fold desc="Задание 1. Напишите функцию, которая выводит 'Привет!'.">
print_r("Задание 1.");
br();

function sayHello()
{
    print_r("Привет!");
}
sayHello();

hr();
//</editor-fold>

//<editor-fold desc="Задание 2. Напишите функцию, которая возвращает сумму двух чисел.">
print_r('Задание 2.');
br();

function sumOfTwoNums(int $num1, int $num2)
{
    return $num1 + $num2;
}
print_r(sumOfTwoNums(1, 2));

hr();
//</editor-fold>

//<editor-fold desc="Задание 3. Создайте функцию, которая выводит приветствие с именем пользователя.">
print_r("Задание 3.");
br();

function hiUser(string $user_name = "your name here")
{
    echo "HI $user_name!\n";
}
hiUser("JACK");

hr();
//</editor-fold>

//<editor-fold desc="Задание 4. Создайте анонимную функцию, которая умножает число на 2.">
print_r("Задание 4.");
br();

$anon_multiplier_by_two = function ($num) : int
{
    return $num * 2;
};

print_r($anon_multiplier_by_two(3));

hr();
//</editor-fold>

//<editor-fold desc="Задание 5. Перепишите предыдущую задачу с использованием стрелочной функции.">
print_r("Задание 5.");
br();

$arrow_multiplier_by_two = fn($num) : int => $num * 2;

echo $arrow_multiplier_by_two(6);

hr();
//</editor-fold>

//<editor-fold desc="Задание 6.  Создайте многомерный массив и напишите рекурсивную функцию для его обхода.">
print_r("Задание 6.");
br();

$array = [
    'layer1' => [0,1,2],
    'layer2' => ['layer2.2' => [3,4,5],6,7],
    'layer3' => 8,
    9
];

function returnArrayValues ($array)
{
    if (is_array($array))
    {
        foreach ($array as $value)
        {
            returnArrayValues($value);
        }
    }
    else
    {
        echo $array . ' ';
    }
}

returnArrayValues($array);

hr();
//</editor-fold>

//<editor-fold desc="Задание 7.  Используйте функцию array_map() для применения callback-функции к массиву чисел.(+1)">
print_r("Задание 7.");
br();

function numPlusOne ($num) : int
{
    return $num += 1;
}

$array = [1, 2, 3, 4];
echo 'Было: ';
print_r($array);

br();

$new_array = array_map('numPlusOne', $array);
echo 'Стало: ';
print_r($new_array);

hr();
//</editor-fold>

//<editor-fold desc="Задание 8. Используйте функции strlen(), strtoupper(), strtolower() для работы со строкой">
print_r("Задание 8.");
br();

$string = "НиТь";
echo "Строка: $string";
br();
$string_length = mb_strlen($string);
echo "Длина строки: $string_length";
br();
$uppercase = mb_strtoupper($string);
echo "strtoupper(): $uppercase";
br();
$lowercase = mb_strtolower($string);
echo "strtolower(): $lowercase";

hr();
//</editor-fold>

//<editor-fold desc="Задание 9. Создайте массив и используйте функции array_push(), array_pop(), array_merge()">
print_r("Задание 9.");
br();

$array = ['З', 'А', 'Я', 'Ц'];
echo 'ARRAY_PUSH, ARRAY_POP:<br><br>Было: ';
print_r($array);
br();

array_push($array,'Утка');
echo 'array_push() Утка: ';
print_r($array);
br();

$surge = array_pop($array);
echo "Извлечено array_pop(): $surge";
br();
echo "Осталось: ";
print_r($array);
br();

echo 'ARRAY_MERGE:';
br();
$array1 = ['P', 'E', 'A', 'C', 'E'];
$array2= ['D', 'E', 'A', 'T', 'H'];

echo "Массив 1: ";
print_r($array1);
br();

echo "Массив 2: ";
print_r($array2);
br();

$merged_array = array_merge($array1, $array2);
echo "array_merged: ";
print_r($merged_array);
hr();
//</editor-fold>

//<editor-fold desc="Задание 10. Используйте функции is_string(), is_numeric(), is_array() для проверки типов данных.">
print_r("Задание 10.");
br();


$string = "Пять";
$num = 5;
$array = [$string, $num];
$boooolean = TRUE;

$mix = [$string, $num, $array, $boooolean];

foreach ($mix as $var)
{
    if (is_string($var))
    {
        echo "$var – строка";
        br();
    }
    elseif (is_numeric($var))
    {
        echo "$var – числовое значение";
        br();
    }
    elseif (is_array($var))
    {
        print_r($var);
        echo " – массив";
        br();
    }
    else
    {
        var_dump($var);
        echo " – не строка, не числовое значение, не массив";
        br();
    }
}
hr();
//</editor-fold>

//<editor-fold desc="Задание 11.  Используйте функции abs(), sqrt(), round(), ceil(), floor() для работы с числами.(+ rand() и mt_rand()).">
print_r("Задание 11.");
br();

$num = -2.6;
echo "Исходное число $num";
br();

echo "модуль abs(): ";
print_r(abs($num));
br();

echo "квадратный корень sqrt(): ";
print_r(sqrt($num));
br();

echo "округление с поправкой round(): ";
print_r(round($num));
br();

echo "округление по недостатку ceil(): ";
print_r(ceil($num));
br();

echo "округление по избытку floor(): ";
print_r(floor($num));
br();

$is_it = checkPHPver();
echo "$is_it число rand(): ";
print_r(rand(-5, 22));
br();

echo "Случайное число mt_rand(): ";
print_r(mt_rand(4, 10));
hr();
//</editor-fold>

//<editor-fold desc="Задание 12. Используйте функцию date() для вывода текущей даты и времени в разных форматах.">
print_r("Задание 12.");
br();
echo "день(01)-месяц(01)-год(01) : ";
print_r(date('d-m-y'));
br();
echo "день(01)-месяц(Jan)-год(2001) : ";
print_r(date('d-M-Y'));
br();
echo "часы:минуты:секунды : ";
print_r(date('H:i:s'));
br();
echo "день месяц год, день недели, часы:минуты: ";
print_r(date('d M Y, D, H:i'));
hr();
//</editor-fold>