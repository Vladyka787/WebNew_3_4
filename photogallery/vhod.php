<?php
session_start();

header('Content-Type: application/json');

$vhod_email = htmlspecialchars($_POST["vhod_email"], ENT_QUOTES);
$vhod_pass = htmlspecialchars($_POST["vhod_pass"], ENT_QUOTES);

$errors = [];

// $vhod_email="las,dlad";
// $vhod_pass="1234";

$sootv = preg_match("/[a-zA-Z]\S{2,30}@\w{1,10}\.(com|ru)/", $vhod_email, $matches);
if ($sootv) {
    if ($matches[0] === $vhod_email) {
        //echo "тут1 1";
        //$errors[] = ["reg_email" => "соответсвие шаблону 'Имейл'"];
    } else {
        $errors["vhod_email"] = ["Несоответсвие шаблону 'Имейл'"];
        //echo "тут2 0";
    }
} else {
    $errors["vhod_email"] = ["Несоответсвие шаблону 'Имейл'"];
    //echo "тут3 0";
}

$sootv = preg_match("/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,30}/", $vhod_pass, $matches);
if ($sootv) {
    if ($matches[0] === $vhod_pass) {
        //echo "тут1 1";
        //$errors[] = ["reg_pass_1" => "Соответсвтвие шаблону 'Пароль'"];
    } else {
        $errors["vhod_pass"] = ["Несоответсвие шаблону 'Пароль'"];
        //echo "тут2 0";
    }
} else {
    $errors["vhod_pass"] = ["Несоответсвие шаблону 'Пароль'"];
    //echo "тут3 0";
}

$connection = new PDO('pgsql:host=localhost;dbname=photogallery', 'postgres', 'postgres');

$sql = "SELECT U.user_password
FROM userp U
WHERE U.user_mail=:vhod_mail";

$sql_get_pass = $connection->prepare($sql);
$sql_get_pass->bindValue(":vhod_mail", $vhod_email, PDO::PARAM_STR);
$sql_get_pass->execute();

$vrem[] = $sql_get_pass->fetch(PDO::FETCH_BOTH);

//var_dump($vrem);

if ($vrem[0] == 0) {
    $errors["vhod_aut"] = ["Неправильный логин или пароль"];
    //echo "тут 1";
} else {
    if (password_verify($vhod_pass, $vrem[0]["user_password"])) {
        //echo "Вход успешен";
    } else {
        $errors["vhod_aut"] = ["Неправильный логин или пароль"];
        //echo "тут 2";
    }
}


if (!empty($errors)) {
    echo json_encode(['errors' => $errors]);
    //$vr=json_encode(['errors' => $errors]);
    //print_r($vr);
    // print_r(json_decode($vr,true));
    die();
}

$sql = 'SELECT U.user_id
    FROM userp U
    WHERE U.user_mail=:vhod_mail';
$sql_find_id = $connection->prepare($sql);
$sql_find_id->bindValue(":vhod_mail", $vhod_email, PDO::PARAM_STR);
$sql_find_id->execute();

$get_id[] = $sql_find_id->fetch(PDO::FETCH_BOTH);

//var_dump($get_id);

$_SESSION["user_id"] = $get_id[0]["user_id"];

echo json_encode(['success' => true]);