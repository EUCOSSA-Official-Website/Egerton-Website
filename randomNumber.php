<?php

function randomNumber($array)
{
    if($array == null){
        return 'null array provided';
    }

    return $array[array_rand($array)];
}

$numbers = [1, 2, 3, 4, 5, 6];

$numbers2 = [];

echo randomNumber($numbers);
