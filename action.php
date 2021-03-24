<?php

$X = $_POST["coordinata_X"];
$Y = $_POST["coordinata_Y"];
$R = $_POST["coordinata_R"];
$time = $_POST["time"];

function validate_for_X($X){
    if(!is_numeric($X)) {
        return "bad";
    }else
    if ($X == -3) {
        return "good";
    }else if ($X == -2) {
        return "good";
    }else if ($X == -1) {
        return "good";
    }else if ($X == 0) {
        return "good";
    }else if ($X == 1) {
        return "good";
    }else if ($X == 2) {
        return "good";
    }else if ($X == 3) {
        return "good";
    }else if ($X == 4) {
        return "good";
    }else if ($X == 5) {
        return "good";
    }
    return "bad";
}

function validate_for_Y($Y){
    if ($Y == 0){
        return "good";
    }
    if ($Y <= -3 || $Y >= 5 || !is_numeric($Y) || $Y == ""){
        return "bad";
    }else{
        return "good";
    }
}

function validate_for_R($R){
    if  (!in_array($R, array(1, 1.5, 2, 2.5, 3)) || !is_numeric($R) ) {
        return "bad";
    }else{
        return "good";
    }
}

$validate_value_for_X = 0;
$validate_value_for_Y = 0;
$validate_value_for_R = 0;

function main_validate(){
    if (validate_for_X($GLOBALS["X"]) == "bad"){
        return "Вы ввели неккоректное значение X";
    }
    if (validate_for_Y($GLOBALS["Y"]) == "bad"){
        return "Вы ввели неккоректное значение Y";
    }
    if (validate_for_R($GLOBALS["R"]) == "bad"){
        return "Вы ввели неккоректное значение R";
    }
    return "ok";
}

$Y = round(str_replace(",", ".", $Y), 2);

$ansver = 0;
$ansver = main_validate();

$number_of_oblast = 0;

function oblast($X,$Y){
    if ($X < 0  && $Y > 0){
        return 2;
    }elseif ($X > 0 && $Y > 0){
        return 1;
    }elseif ($X < 0 && $Y < 0 ){
        return 3;
    }elseif ($X > 0 && $Y < 0){
        return  4;
    }elseif ($X == 0 || $Y == 0){
        return  5;
    }
}

$number_of_oblast = oblast($X,$Y);

function popadations($number_of_oblast,$X,$Y,$R){

    if ($number_of_oblast == 2){
        return 0;
    }elseif ($number_of_oblast == 1){
        if (sqrt($X*$X + $Y*$Y) <= $R){
            return 1;
        }else{
            return 0;
        }
    }elseif ($number_of_oblast == 3){
        if (abs($Y) <= abs($R) - abs($X)){
            return 1;
        }else{
            return 0;
        }
    }elseif ($number_of_oblast == 4){
        if ($X > $R || $Y < -$R/2){
            return 0;
        }else{
            return 1;
        }
    }elseif ($number_of_oblast == 5){
        if ($X > $R || $X < -$R/2 || $Y > $R/2 || $Y < -$R/2){
            return 0;
        }else{
            return 1;
        }

    }
}

$result = popadations($number_of_oblast,$X,$Y,$R);

function resulting($result){
    if ($result == 1){
        return "ок";
    }else{
        return "Мимо";
    }
}

$currentTime = date('H:i:s', time()-$time*60);
$executionTime = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 7);
$testString = resulting($result);

if ($ansver != "ok"){
    $jsonData = '{' .
        "\"coordinata_X\":\"-\"," .
        "\"coordinata_Y\":\"-\"," .
        "\"coordinata_R\":\"-\"," .
        "\"timeLol\":\"$currentTime\"," .
        "\"timeLong\":\"$executionTime\"," .
        "\"itog\":\"$ansver\"" .
        "}";
    echo $jsonData;
}else{
    $jsonData = '{' .
        "\"coordinata_X\":\"$X\"," .
        "\"coordinata_Y\":\"$Y\"," .
        "\"coordinata_R\":\"$R\"," .
        "\"timeLol\":\"$currentTime\"," .
        "\"timeLong\":\"$executionTime\"," .
        "\"itog\":\"$testString\"" .
        "}";
    echo $jsonData;
}

