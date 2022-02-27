<?

$sql_photo = $connection->prepare('SELECT * FROM postphoto P ORDER BY P.postphoto_id DESC LIMIT :shagVivod');

$shagVivod = 2;

$sql_photo->bindValue(":shagVivod", $shagVivod, PDO::PARAM_INT);
$sql_photo->execute();
$vivod_post = range(1, $shagVivod);
foreach ($vivod_post as $photo) {
    $result = $sql_photo->fetch();
    if ($result) {
?>
        <div class="body__photo">
            <img src="<? echo $result['postphoto_photo']; ?>" alt="Тут была ваша реклама" class="body__photo__img">
            <div class="body__photo__description">
                <a href="detail_page.php/?post_id=<? echo $result["postphoto_id"] ?>" class="body__photo__name"><? echo $result['postphoto_name']; ?></a>
                <? echo $result['postphoto_date_dobavl']; ?>
            </div>
        </div>
<? }
} ?>