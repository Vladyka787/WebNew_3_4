<?
session_start();
// echo $_GET["post_id"];
$connection = new PDO('pgsql:host=localhost;dbname=photogallery', 'postgres', 'postgres');

$id = $_GET["post_id"];

$sql = "SELECT *
FROM postphoto P
WHERE P.postphoto_id=:id";

$sql_get_param_photo = $connection->prepare($sql);
unset($sql);
$sql_get_param_photo->bindValue(":id", $id, PDO::PARAM_INT);
$sql_get_param_photo->execute();

$param_photo = $sql_get_param_photo->fetch(PDO::FETCH_ASSOC);
//var_dump($param_photo);


if (array_key_exists("user_id", $_SESSION)) {

    $sql = "SELECT R.rating_user_rating
    FROM rating R
    WHERE R.user_id= :user_id AND R.postphoto_id= :post_id ";

    $sql_get_user_rate = $connection->prepare($sql);
    unset($sql);
    $sql_get_user_rate->bindValue(":user_id", $_SESSION["user_id"]);
    $sql_get_user_rate->bindValue(":post_id", $id);
    $sql_get_user_rate->execute();

    $user_rate = $sql_get_user_rate->fetch();

    //var_dump($user_rate);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>PhotoGallery</title>
    <link href="/css/styles.css" rel="stylesheet" type="text/css">
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
    <script src="/rating.js"></script>
    <script src="/register.js"></script>
    <script src="/out.js"></script>
    <script src="/vhod.js"></script>
</head>

<body class="body">

    <div class="wrapper">

        <header class="header">
            <? if (!array_key_exists("user_id", $_SESSION)) { ?>
                <div class="header__container">
                    PhotoGallery
                    <div class="header__buttons">
                        <a href="../index.php" class="header__glavnai otstup">Главная</a>
                        <a href="#vhod_popup" class="header__vhod otstup">Войти</a>
                        <a href="#registration_popup" class="header__registration otstup">Зарегистрироваться</a>
                    </div>
                </div>
            <? } else { ?>
                <div class="header__container">
                    PhotoGallery
                    <div class="header__buttons">
                        <a href="../index.php" class="header__glavnai otstup">Главная</a>

                        <? $sql = 'SELECT U.user_name
                        FROM userp U
                        WHERE U.user_id=:user_id';

                        $sql_get_name = $connection->prepare($sql);
                        $sql_get_name->bindValue(":user_id", $_SESSION["user_id"], PDO::PARAM_INT);
                        $sql_get_name->execute();

                        $vrem[] = $sql_get_name->fetch(PDO::FETCH_BOTH);
                        $name = $vrem[0]["user_name"];
                        unset($vrem);
                        ?>

                        <a class="otstup">Привет, <? echo $name ?></a>
                        <a href="#" id="logOut" class="otstup">Выйти</a>
                    </div>
                </div>
            <? }; ?>
        </header>

        <div class="body__container detail_page">

            <div class="body__container__left">

                <div class="body__container__left__text">
                    <? //var_dump($param_photo);
                    ?>
                    <p>
                        Название: <? echo $param_photo["postphoto_name"]; ?>
                    </p>
                    <p>
                        Дата добавления: <? echo $param_photo["postphoto_date_dobavl"]; ?>
                    </p>
                </div>

                <div class="body__container__left__img">
                    <img src="/<? echo $param_photo['postphoto_photo']; ?>" alt="Тут была ваша реклама" class="detail_page_img">
                </div>

            </div>

            <div class="body__container__right">

                <p>Описание:</p>
                <?
                if ($param_photo["postphoto_description"] == NULL) {
                ?>
                    <p>У данного фото нет описания.</p>
                <?
                } else {
                ?><p><? echo $param_photo["postphoto_description"]; ?></p><? } ?>

                <p>Всего пользователей оценило:</p>
                <?
                if ($param_photo["postphoto_kolvo_rating"] == NULL) {
                ?>
                    <p>У данного фото еще нет оценок.</p>
                <?
                } else { ?><p><? echo $param_photo["postphoto_kolvo_rating"]; ?></p><? } ?>

                <p>Рейтинг:</p>
                <?
                if ($param_photo["postphoto_rating"] == NULL) {
                ?>
                    <p>У данного фото еще не сформирован рейтинг.</p>
                <?
                } else { ?><p><? echo $param_photo["postphoto_rating"]; ?></p><? } ?>

                <? if (!array_key_exists("user_id", $_SESSION)) { ?>
                    <p>Зарегистируйтесь или войдите в свой аккаунт, чтобы оценить фото.</p>
                    <? } else {
                    if ($_SESSION["user_id"] == $param_photo["user_id"]) { ?>
                        <p>Вы не можете оценивать свои фото.</p>
                        <? } else {
                        if ($user_rate == false) { ?>
                            <p>Вам нравится фотография? Оцените его.
                            </p>
                            <p>
                                <select class="body__container__right__select" id="body__container__right__select">
                                    <option value="<? echo $id; ?>">5</option>
                                    <option value="<? echo $id; ?>">4</option>
                                    <option value="<? echo $id; ?>">3</option>
                                    <option value="<? echo $id; ?>">2</option>
                                    <option value="<? echo $id; ?>">1</option>
                                </select>
                                <button class="body__container__right__button" id="body__container__right__button">Оценить</button>
                            </p>
                        <? } else {
                        ?>
                            <p>Ваша оценка: </p>
                            <p><? echo $user_rate[0]; ?></p>
                <?
                        }
                    }
                }; ?>

            </div>
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

    <? require_once("vhod_popup.php"); ?>

    <? require_once("reg_popup.php"); ?>

</body>

</html>