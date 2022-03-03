<? 
session_start();

header('Content-Type: application/json');

$connection = new PDO('pgsql:host=localhost;dbname=photogallery', 'postgres', 'postgres');

//var_dump($_POST);
//var_dump($_FILES);

$file=$_FILES["add"];

//var_dump($file);

$name = htmlspecialchars($_POST['name'], ENT_QUOTES);
$description = htmlspecialchars($_POST['description'], ENT_QUOTES);

// $name="asdjnk";
// $description="kndmslkmndlkmkslm";

//echo $name;
//echo $description;

$errors=[];

$sootv = preg_match("/[а-яА-Я\d ]{1,30}/u", $name, $matches);
//echo $sootv;
if ($sootv) {
    //print_r($matches);
    if ($matches[0] === $name) {
        //echo "тут1 1";
    } else {
        $errors["name"] = ["Несоответсвие шаблону 'Название'"];
        //echo "тут2 0";
    }
} else {
    $errors["name"] = ["Несоответсвие шаблону 'Название'"];
    //echo "тут3 0";
}

$sootv = preg_match("/[.,!?а-яА-Я\d\s]{0,300}/u", $description, $matches);
//echo $sootv;
if ($sootv) {
    //print_r($matches);
    if ($matches[0] === $description) {
        //echo "тут1 1";
    } else {
        $errors["description"] = ["Несоответсвие шаблону 'Описание'"];
        //echo "тут2 0";
    }
} else {
    $errors["description"] = ["Несоответсвие шаблону 'Описание'"];
    //echo "тут3 0";
}

$path_parts=pathinfo($file["name"]);

//var_dump($path_parts);

if($path_parts["extension"]!="jpg"){
    $errors["extension"] = ["Не соответсвие формату jpg"];
}

$sootv = preg_match("/[0-9a-zA-Z]{1,100}/", $path_parts["filename"], $matches);
//echo $sootv;
if ($sootv) {
    //print_r($matches);
    if ($matches[0] === $path_parts["filename"]) {
        //echo "тут1 1";
    } else {
        $errors["filename"] = ["В имени файла только латиница и цифры"];
        //echo "тут2 0";
    }
} else {
    $errors["filename"] = ["В имени файла только латиница и цифры"];
    //echo "тут3 0";
}

if($file["type"] != "image/jpeg")
{
    if (!array_key_exists("extension", $errors)) {
        $errors["extension"] = ["Не соответсвие формату jpg"];
    }
}

if($file["size"]>3145728){
    $errors["size"] = ["Размер файла не больше 3 мб"];
}

if (!empty($errors)) {
    echo json_encode(['errors' => $errors]);
    //$vr=json_encode(['errors' => $errors]);
    //print_r($vr);
    // print_r(json_decode($vr,true));
    die();
}

$way = "img/" . uniqid() . "." . $path_parts["extension"];

//echo $way;

move_uploaded_file($file["tmp_name"],$way);

$sql = "INSERT INTO postphoto (user_id,postphoto_name,postphoto_date_dobavl,postphoto_photo,postphoto_description)
VALUES (:user_id,:name_photo,:date_dobavl,:photo,:description_photo)";

$sql_add_post = $connection->prepare($sql);
$sql_add_post->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
$sql_add_post->bindValue(':name_photo', $name, PDO::PARAM_STR);
$sql_add_post->bindValue(':date_dobavl', date("Y-m-d"), PDO::PARAM_STR);
$sql_add_post->bindValue(':photo', $way, PDO::PARAM_STR);
$sql_add_post->bindValue(':description_photo', $description, PDO::PARAM_STR);
$sql_add_post->execute();

//echo date("Y-m-d");

$sql ="SELECT P.postphoto_id
FROM postphoto P
WHERE P.user_id=:user_id AND P.postphoto_photo=:photo";

$sql_get_post_id= $connection->prepare($sql);
$sql_get_post_id->bindValue(":user_id",$_SESSION["user_id"], PDO::PARAM_INT);
$sql_get_post_id->bindValue(':photo', $way, PDO::PARAM_STR);
$sql_get_post_id->execute();

$post_id=$sql_get_post_id->fetch();

//var_dump($post_id);

$url = "http://photogallery/detail_page.php/?post_id=". $post_id["postphoto_id"];
echo json_encode(['url' => $url]);
die();
echo json_encode(['success' => true]);