<?php session_start();

$connection = new PDO('pgsql:host=localhost;dbname=photogallery', 'postgres', 'postgres');
?>
<!DOCTYPE html>
<html>

<head>
    <title>PhotoGallery</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@1,200&family=Montserrat:ital,wght@1,200&display=swap" rel="stylesheet">
    <script>
        function sravnPass() {
            if ((document.getElementById("pass").value === document.getElementById("povtPass").value) && (document.getElementById("pass").value != "")) {
                document.getElementById("popup__otpravkaReg").disabled = 0;
            } else {
                document.getElementById("popup__otpravkaReg").disabled = 1;
            }
        }
    </script>
    <script src="add.js"></script>
    <script src="register.js"></script>
    <script src="out.js"></script>
    <script src="vhod.js"></script>
</head>

<body class="body">

    <div class="wrapper">
        
        <header class="header">
            <? if (!array_key_exists("user_id", $_SESSION)) { ?>
                <div class="header__container">
                    PhotoGallery
                    <div class="header__buttons">
                        <a href="#" class="header__glavnai otstup">Главная</a>
                        <a href="#vhod_popup" class="header__vhod otstup">Войти</a>
                        <a href="#registration_popup" class="header__registration otstup">Зарегистрироваться</a>
                    </div>
                </div>
            <? } else { ?>
                <div class="header__container">
                    PhotoGallery
                    <div class="header__buttons">
                        <a href="#" class="header__glavnai otstup">Главная</a>

                        <? $sql = 'SELECT U.user_name
                        FROM userp U
                        WHERE U.user_id=:user_id';

                        $sql_get_name = $connection->prepare($sql);
                        $sql_get_name->bindValue(":user_id", $_SESSION["user_id"], PDO::PARAM_INT);
                        $sql_get_name->execute();

                        $vrem[] = $sql_get_name->fetch(PDO::FETCH_BOTH);
                        $name = $vrem[0]["user_name"];
                        unset($vram);
                        ?>

                        <a class="otstup">Привет, <? echo $name ?></a>
                        <a href="#" id="logOut" class="otstup">Выйти</a>
                    </div>
                </div>
            <? }; ?>
        </header>

        <div class="body__container" id="vstavka_post">
                <?require_once("main.php");?>
        </div>

        <div class="container_add">
            <a href="more_post.php" data-next-page="2" class="container_add__button" id="container_add__button">Показать еще</a>
        </div>

        <footer class="footer">
            <div class="footer_container">
                <div>Admin@mail.com</div>
                <div>
                    <div>Design by Vlad in Russia</div>
                    <div>Made in Russia</div>
                </div>
            </div>
        </footer>
    </div>

    <?require_once("vhod_popup.php");?>

    <?require_once("reg_popup.php");?>

</body>

</html>