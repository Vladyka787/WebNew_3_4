<?php session_start();

$connection = new PDO('pgsql:host=localhost;dbname=photogallery', 'postgres', 'postgres');

if (array_key_exists("user_id", $_SESSION)) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>PhotoGallery</title>
        <link href="/css/styles.css" rel="stylesheet" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@1,200&family=Montserrat:ital,wght@1,200&display=swap" rel="stylesheet">
        <script src="add_post.js"></script>
    </head>

    <body class="body">

        <div class="wrapper">

            <header class="header">
                <?
                if (!array_key_exists("user_id", $_SESSION)) {
                    //echo "Как вы сюда попали?";
                } else { ?>
                    <div class="header__container">
                        PhotoGallery
                        <div class="header__buttons">
                            <a href="./index.php" class="header__glavnai otstup">Главная</a>

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
                        </div>
                    </div>
                <? }; ?>
            </header>

            <div class="body__container add_post__container">

                <form action="handler.php" method="POST" class="add_post" id="add_post_form" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Новый пост</legend>
                        <p class="add_post_pole" id="name_photo"><label for="name">Название фото:</label><input name="name" type="text" id="name_photo" title="Русскими буквами" required pattern="[а-яА-Я\d ]{1,30}"></p>
                        <p class="add_post_pole" id="add_photo"><label for="add">Загрузите фото:</label><input type="hidden" name="MAX_FILE_SIZE" value="3145728" /><input name="add" type="file" id="add_photo" required></p>
                        <p class="add_post_pole" id="description_photo"><label for="description">Описание фото:</label><textarea name="description" id="description_photo" title="Русскими буквами (300 символов)" maxlength="300" pattern="[а-яА-Я\d\s]{1,300}"></textarea></p>
                        <input type="submit" class="add_post_button" value="Сохранить">
                    </fieldset>
                </form>

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

    </body>

    </html><?
        } else {
            header("Location: /index.php#registration_popup");
        }
