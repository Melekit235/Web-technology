<?php

$title_page = "Why are you running";
$style_file = "style/feedbackStyle.css";
$style_file2 = "style/style.css";

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

$main = file_get_contents('templates/feedback.html');

$main= str_replace(
    '{title_page}', $title_page, $main);
$main= str_replace(
    '{style_file}', $style_file, $main);
$main= str_replace(
    '{style_file2}', $style_file2, $main);


$header = file_get_contents('templates/header.html');
$header = str_replace('{logo_img}',$logo_img,$header);
$header = str_replace('{title}',$title,$header);
$header = str_replace('{link_lager}',$link_lager,$header);
$header = str_replace('{link_porter}',$link_porter,$header);
$header = str_replace('{link_stout}',$link_stout,$header);
$header = str_replace('{title_stout}',$link_stout,$header);
$header = str_replace('{link_feedback}',$link_feedback,$header);



$main= str_replace(
    '{header}', $header, $main);


$footer = file_get_contents('templates/footer.html');


$footer = str_replace('{link_github}', $link_github,$footer);
$footer = str_replace('{img_github}', $img_github,$footer);
$footer = str_replace('{mail}', $mail,$footer);

$main = str_replace(
    '{footer}', $footer, $main);


$file_path = 'feedback/feedback.txt';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $message = $_POST['message'];

    $review = "$name: $message\n";
    $file = fopen($file_path, "w");
    fwrite($file, $review);
    fclose($file);
}

$reviews = file_get_contents($file_path);

$regex = "/(https?:\/\/(?!www\.bsuir\.by)(?!bsuir\.by)[\w\/:%#\$&\?\(\)~\.=\+\-]+)/i";

$message = "http://mysite.by https://www.mysite.by/price http://bsuir.by https://www.bsuir.by/ru/kafedry-bguir http://example.com";
$message = preg_replace($regex, "#Внешние ссылки запрещены#", $message);


$main = str_replace('{text}',$message,$main);


print $main;



