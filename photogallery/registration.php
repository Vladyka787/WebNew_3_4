<?php
session_start();

header('Content-Type: application/json');
//print_r($_POST);

$reg_name = htmlspecialchars($_POST['reg_name'], ENT_QUOTES);
$reg_email = htmlspecialchars($_POST['reg_email'], ENT_QUOTES);
$reg_telefon = htmlspecialchars($_POST['reg_telefon'], ENT_QUOTES);
$reg_pass_1 = htmlspecialchars($_POST['reg_pass_1'], ENT_QUOTES);
$reg_pass_2 = htmlspecialchars($_POST['reg_pass_2'], ENT_QUOTES);
$reg_usl = htmlspecialchars($_POST['reg_usl'], ENT_QUOTES);

// $reg_name="Vlad";
// $reg_email="ggmaik.oo";
// $reg_telefon="89531888562123";
// $reg_pass_1="Хаха";
// $reg_pass_2="Хехе";
// $reg_usl="Нет";

$errors = [];
//var_dump($_POST['reg_name']);
//var_dump($reg_name);

$sootv = preg_match("/^[А-Я|а-я]{1}[А-Я|а-я\- ]{0,23}[А-Я|а-я]{1}$/u", $reg_name, $matches);
//echo $sootv;
if ($sootv) {
    //print_r($matches);
    if ($matches[0] === $reg_name) {
        //echo "тут1 1";
        //$errors[] = ["reg_name" => "соответсвует шаблону 'Имя'"];
    } else {
        $errors["reg_name"] = ["Несоответсвие шаблону 'Имя'"];
        //echo "тут2 0";
    }
} else {
    $errors["reg_name"] = ["Несоответсвие шаблону 'Имя'"];
    //echo "тут3 0";
}

$sootv = preg_match("/[a-zA-Z]\S{2,30}@\w{1,10}\.(com|ru)/", $reg_email, $matches);
if ($sootv) {
    if ($matches[0] === $reg_email) {
        //echo "тут1 1";
        //$errors[] = ["reg_email" => "соответсвие шаблону 'Имейл'"];
    } else {
        $errors["reg_email"] = ["Несоответсвие шаблону 'Имейл'"];
        //echo "тут2 0";
    }
} else {
    $errors["reg_email"] = ["Несоответсвие шаблону 'Имейл'"];
    //echo "тут3 0";
}

$sootv = preg_match("/^8\d{10}|^\+7\d{10}/", $reg_telefon, $matches);
if ($sootv) {
    if ($matches[0] === $reg_telefon) {
        //echo "тут1 1";
        // $errors[] = ["reg_telefon" => "соответсвие шаблону 'Телефон'"];
    } else {
        $errors["reg_telefon"] = ["Несоответсвие шаблону 'Телефон'"];
        //echo "тут2 0";
    }
} else {
    $errors["reg_telefon"] = ["Несоответсвие шаблону 'Телефон'"];
    //echo "тут3 0";
}

$sootv = preg_match("/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,30}/", $reg_pass_1, $matches);
if ($sootv) {
    if ($matches[0] === $reg_pass_1) {
        //echo "тут1 1";
        //$errors[] = ["reg_pass_1" => "Соответсвтвие шаблону 'Пароль'"];
    } else {
        $errors["reg_pass_1"] = ["Несоответсвие шаблону 'Пароль'"];
        //echo "тут2 0";
    }
} else {
    $errors["reg_pass_1"] = ["Несоответсвие шаблону 'Пароль'"];
    //echo "тут3 0";
}

$hash = password_hash($reg_pass_1, PASSWORD_DEFAULT);

if (password_verify($reg_pass_2, $hash)) {
    // echo 'Пароль совпадают!';
    //$errors[] = ["reg_pass_verify" => "Пароли совпадают"];
} else {
    $errors["reg_pass_verify"] = ["Пароли не совпадают"];
    //echo 'Пароль несовпадают.';
}

//print_r($errors);

//print_r($reg_usl);
if ($reg_usl === "Принял") {
    // $errors[] = ["reg_usl" => "Условия приняты"];
    // echo "Условия приняты";
} else {
    $errors["reg_usl"] = ["Примите условия пользовательского соглашения"];
}

$povtor_telefon = false;
$povtor_email = false;

$connection = new PDO('pgsql:host=localhost;dbname=photogallery', 'postgres', 'postgres');

$reg_email = mb_strtolower($reg_email);

if ($povtor_email) {
} else {
    $sql = 'SELECT U.user_mail
    FROM userp U
    WHERE U.user_mail=:reg_mail';
    $sql_sravn_email = $connection->prepare($sql);
    //$reg_email="Vytia@gmail.ru";
    $sql_sravn_email->bindValue(":reg_mail", $reg_email, PDO::PARAM_STR);
    //echo $reg_email;
    $sql_sravn_email->execute();
    //print_r($sql_sravn_email->execute());
    //print_r($sql_sravn_email->fetch(PDO::FETCH_BOTH));
    $res1[] = $sql_sravn_email->fetch(PDO::FETCH_BOTH);
    //print_r($res1);
    if (isset($res1[0][0])) {
        $errors["povtor_email"] = ["Данный имейл уже зарегистрирован"];
    } else {
    }
    unset($res1);
}

if ($povtor_telefon) {
} else {

    $sql = 'SELECT U.user_phone
    FROM userp U
    WHERE U.user_phone=:reg_phone';
    $sql_sravn_phone = $connection->prepare($sql);

    //$reg_telefon="88888888888";
    $mas = str_split($reg_telefon, 1);
    //print_r($mas);
    if ($mas[0] == 8) {
        $alter_tel = $mas;
        $alter_tel[0] = "+7";
        $alter_telefon = implode($alter_tel);
        //print_r($alter_telefon);
    } else {
        $alter_tel = $mas;
        $alter_tel[0] = " ";
        $alter_tel[1] = "8";
        $alter_telefon = ltrim(implode($alter_tel));
        //print_r($alter_telefon);
    }
    $sql_sravn_phone->bindValue(":reg_phone", $reg_telefon, PDO::PARAM_STR);
    //echo $reg_telefon;
    $sql_sravn_phone->execute();
    //print_r($sql_sravn_phone->execute());
    //print_r($sql_sravn_phone->fetch(PDO::FETCH_BOTH));
    $res1[] = $sql_sravn_phone->fetch(PDO::FETCH_BOTH);
    //print_r($res1);
    if (isset($res1[0][0])) {
        $errors["povtor_telefon"] = ["Данный телефон уже зарегистрирован"];
    } else {
    }
    unset($res1);

    $sql_sravn_phone->bindValue(":reg_phone", $alter_telefon, PDO::PARAM_STR);
    //echo $reg_telefon;
    $sql_sravn_phone->execute();
    //print_r($sql_sravn_phone->execute());
    //print_r($sql_sravn_phone->fetch(PDO::FETCH_BOTH));
    $res1[] = $sql_sravn_phone->fetch(PDO::FETCH_BOTH);
    //print_r($res1);
    if (isset($res1[0][0])) {
        $errors["povtor_telefon"] = ["Данный телефон уже зарегистрирован"];
    } else {
    }
    unset($res1);
}

//print_r($errors);

if (!empty($errors)) {
    echo json_encode(['errors' => $errors]);
    //$vr=json_encode(['errors' => $errors]);
    //print_r($vr);
    // print_r(json_decode($vr,true));
    die();
}

$sql = "INSERT INTO userp (user_name,user_mail,user_phone,user_password)
VALUES (:reg_name,:reg_email,:reg_telefon,:reg_hash)";

$sql_reg = $connection->prepare($sql);
$sql_reg->bindValue(':reg_name', $reg_name, PDO::PARAM_STR);
$sql_reg->bindValue(':reg_email', $reg_email, PDO::PARAM_STR);
$sql_reg->bindValue(':reg_telefon', $reg_telefon, PDO::PARAM_STR);
$sql_reg->bindValue(':reg_hash', $hash, PDO::PARAM_STR);
$sql_reg->execute();

//echo $hash;

$sql = 'SELECT U.user_id
    FROM userp U
    WHERE U.user_mail=:reg_mail AND U.user_phone=:reg_phone';
$sql_find_id = $connection->prepare($sql);
$sql_find_id->bindValue(":reg_mail", $reg_email, PDO::PARAM_STR);
$sql_find_id->bindValue(":reg_phone", $reg_telefon, PDO::PARAM_STR);
$sql_find_id->execute();

$get_id[] = $sql_find_id->fetch(PDO::FETCH_BOTH);

//var_dump($get_id);

$_SESSION["user_id"] = $get_id[0]["user_id"];

// $lol=$_SESSION;

//echo json_encode(["user" => $lol]);

echo json_encode(['success' => true]);

//header('Location: index.php');