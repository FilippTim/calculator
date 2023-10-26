<?php
function find_e($str, $e) {
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] == $e) {
           return $i;
        }
    }
    return (-1);
 }
function solveEquation($equation) {
    // Очистить уравнение от пробелов
    $equation = str_replace(" ", "", $equation);

    // Разделить уравнение на левую и правую части
    $parts = explode("=", $equation);
    $leftPart = $parts[0];
    $rightPart = $parts[1];

    // Определить переменную
    $variable = "";
    $operator = "";

    // Найти переменную и оператор
    for ($i = 0; $i < strlen($leftPart); $i++) {
        $char = $leftPart[$i];
        if (ctype_alpha($char)) {
            $variable = $char;
        } elseif (in_array($char, ['+', '-', '*', '/'])) {
            $operator = $char;
        }
    }
    

    //Получить численное значение переменной и правой части уравнения
    $position_x=find_e($leftPart, $variable);
    $position_oper=(integer)find_e($leftPart, $operator);
    if($position_x == 0){$variableValue = (float)substr($leftPart, $position_oper+1);}
    else{$variableValue = (float)substr($leftPart, 0, $position_oper);}
    $rightValue = (float) $rightPart;
    

    // Решить уравнение и получить значение переменной
    if ($operator == '+') {
        $result = $rightValue - $variableValue;
    } 
    elseif ($operator == '-') {
        if ($position_x == 0){$result = $rightValue + $variableValue;}
        else{$result = $variableValue - $rightValue;}
    } 
    elseif ($operator == '*') {
        if ($rightPart == 0) {$result = "Переменная не найдена";}
        else{ $result = $rightPart / $variableValue; }
    }
    elseif ($operator == "/") {
        if(find_e($leftPart, $variable)==0){
            $result = $rightPart*$variableValue;
        }else{$result=$variableValue/$rightValue;}
    }
    else{
        return "Недопустимый опреатор ".$operator;
    }

    // // Вывести результат
    return ["x = ".$result, $variableValue];
}

// Пример использования
include"form.php";
$equation = $_POST["equation"];
echo $equation."<br>";
echo solveEquation($equation)[0];
?>