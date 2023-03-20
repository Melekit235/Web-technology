<?php
//main
$title_page = "Why are you running";
$style_file = "style/style.css";

//header
$logo_img = "images/logo.jpg";
$title = "ТЁМНОЕ ПИВО";
$link_lager = "lager.php";
$link_porter = "porter.php";
$link_stout = "stout.php";
$link_feedback = "feedback.php";

//footer
$link_github = 'https://github.com/Melekit235';
$img_github = "images/github.png";
$mail = 'Электронная почта: verghel.iliya@gmail.com';


$main = file_get_contents('templates/main.html');



$main= str_replace(
    '{title_page}', $title_page, $main);
$main= str_replace(
    '{style_file}', $style_file, $main);


$header = file_get_contents('templates/header.html');
$header = str_replace('{logo_img}',$logo_img,$header);
$header = str_replace('{title}',$title,$header);
$header = str_replace('{link_lager}',$link_lager,$header);
$header = str_replace('{link_porter}',$link_porter,$header);
$header = str_replace('{link_stout}',$link_stout,$header);
$header = str_replace('{link_feedback}',$link_feedback,$header);



$main= str_replace('{header}', $header, $main);



try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'");


    for ($i = 1; $i <= 3; $i++) {

        $main = str_replace('{beer' . (string)$i . '}', file_get_contents('templates/beer.html'), $main);

        $stmt = $pdo->prepare('SELECT * FROM main WHERE id = :id');
        $stmt->bindParam(':id', $i, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $main = str_replace('{link}',$row['link'], $main);
        $main = str_replace('{text}',$row['text'], $main);

        $image = imagecreatefromstring($row['img']);
        imagejpeg($image, 'images/'.$i.'.jpeg', 100); // 100 - качество изображения (от 0 до 100)
        $main = str_replace('{img}','images/'.$i.'.jpeg' , $main);
        $main = str_replace('{imgN}','Изображение'.$i , $main);

    }

} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
} finally {
    $dbh = null;
}


$footer = file_get_contents('templates/footer.html');


$footer = str_replace('{link_github}', $link_github,$footer);
$footer = str_replace('{img_github}', $img_github,$footer);
$footer = str_replace('{mail}', $mail,$footer);

$main = str_replace('{footer}', $footer, $main);

print $main;
