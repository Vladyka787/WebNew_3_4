<?
session_start();

$connection = new PDO('pgsql:host=localhost;dbname=photogallery', 'postgres', 'postgres');

$rate = $_GET['rate'];
$id_post = $_GET['id'];

$sql = "INSERT INTO rating
VALUES (:id_user,:id_post,:rate)";

$sql_add_rating = $connection->prepare($sql);
unset($sql);
$sql_add_rating->bindValue(":id_user", $_SESSION["user_id"]);
$sql_add_rating->bindValue(":id_post", $id_post);
$sql_add_rating->bindValue(":rate", $rate);
$sql_add_rating->execute();

$sql = "SELECT COUNT(R.postphoto_id), AVG(R.rating_user_rating)
FROM rating R
WHERE R.postphoto_id=:id_post";

$sql_get_new_data_post = $connection->prepare($sql);
unset($sql);
$sql_get_new_data_post->bindValue(":id_post", $id_post);
$sql_get_new_data_post->execute();

$new_data_post = $sql_get_new_data_post->fetch();

$sql = "UPDATE postphoto
SET 
postphoto_rating = :avg_rate ,
postphoto_kolvo_rating = :count_rate
WHERE postphoto_id = :id_post ";



$sql_update_postphoto=$connection->prepare($sql);
unset($sql);
$sql_update_postphoto->bindValue(":avg_rate",$new_data_post["avg"]);
$sql_update_postphoto->bindValue(":count_rate",$new_data_post["count"]);
$sql_update_postphoto->bindValue(":id_post",$id_post);
$sql_update_postphoto->execute();

//var_dump($new_data_post);

echo "success";
