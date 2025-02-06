<?php
function hr()
{
    print_r("<br><hr style='margin: 20px 0'>");
}

function br()
{
    print_r("<br><br>");
}


function checkPHPver(): string
{
    $cur_php_ver = phpversion();
    $min_php_ver = '7.1.0';

    if ($cur_php_ver >= $min_php_ver)
    {
        return 'Псевдо псевдослучайное';
    }
    return 'Псевдослучайное';
};