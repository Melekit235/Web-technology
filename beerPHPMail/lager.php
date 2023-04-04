<?php
//main
$title_page = "Why are you running";
$style_file = "style/beerStyle.css";

//header
$logo_img = "images/logo.jpg";
$title = "ТЁМНОЕ ПИВО";
$link_lager = "lager.php";
$link_porter = "porter.php";
$link_stout = "stout.php";
$link_feedback = "feedback.php";
$link_Out = "logOut.php";
$link_In = "logReg.php";
$Text_In = "Вход/Регистрация";
$Text_Out = "Выход";

//footer
$link_github = 'https://github.com/Melekit235';
$img_github = 'images/github.png';
$mail = 'Электронная почта: verghel.iliya@gmail.com';



$main = file_get_contents('templates/about.html');

$main= str_replace('{title_page}', $title_page, $main);
$main= str_replace('{style_file}', $style_file, $main);




$header = file_get_contents('templates/header.html');

$header = str_replace('{logo_img}',$logo_img,$header);
$header = str_replace('{title}',$title,$header);
$header = str_replace('{link_lager}',$link_lager,$header);
$header = str_replace('{link_porter}',$link_porter,$header);
$header = str_replace('{link_stout}',$link_stout,$header);
$header = str_replace('{title_stout}',$link_stout,$header);
$header = str_replace('{link_feedback}',$link_feedback,$header);


session_start();

if(!isset($_SESSION['user_id'])){

    $header = str_replace('{link_InOut}',$link_In,$header);
    $header = str_replace('{Text_InOut}',$Text_In,$header);
}
else{
    $header = str_replace('{link_InOut}',$link_Out,$header);
    $header = str_replace('{Text_InOut}',$Text_Out,$header);
}



$main= str_replace('{header}', $header, $main);




$host = 'localhost';
$dbname = 'site';
$username = 'root';
$password = 'Qwerty';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM site.beer WHERE id = 1');
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $main= str_replace('{img_beer}', $row['imgL'], $main);
    $main= str_replace('{name}', $row['name'], $main);
    $main = str_replace("{text}",$row['text'], $main);
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
