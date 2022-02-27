<?php
$page = (int)$_GET['page'];
if ($page <= 0) {
    die();
}
$pageSize = 2;

//тут должен быть запрос к базе данных

$connection = new PDO('pgsql:host=localhost;dbname=photogallery', 'postgres', 'postgres');

$sql_photo = $connection->prepare('SELECT * FROM postphoto P ORDER BY P.postphoto_id DESC LIMIT :pageSize');

$sql_photo->bindValue(":pageSize", $pageSize * $page, PDO::PARAM_INT);
$sql_photo->execute();

$kolv_elem = ($page - 1) * $pageSize;
for ($i = 0; $i < $kolv_elem; $i++) {
    $result = $sql_photo->fetch();
}

$items = range($pageSize * ($page - 1) + 1, $pageSize * $page);

foreach ($items as $photo) {
    $result = $sql_photo->fetch();
    if ($result) {
?>
        <div class="body__photo">
            <img src="<? echo $result['postphoto_photo']; ?>" alt="Тут была ваша реклама" class="body__photo__img">
            <div class="body__photo__description">
                <a href="detail_page.php/?post_id=<?echo $result["postphoto_id"]?>" class="body__photo__name" id="<?echo $result['postphoto_id']?>"><? echo $result['postphoto_name']; ?></a>
                <? echo $result['postphoto_date_dobavl']; ?>
            </div>
        </div>
<? }
} ?>