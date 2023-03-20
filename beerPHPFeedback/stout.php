<?php
//main
$title_page = "Why are you running";
$style_file = "style/beerStyle.css";
$img_beer = "images/3.png";
$name = "STOUT";

//header
$logo_img = "images/logo.jpg";
$title = "ТЁМНОЕ ПИВО";
$link_lager = "lager.php";
$link_porter = "porter.php";
$link_stout = "stout.php";
$link_feedback = "feedback.php";

//footer
$link_github = 'https://github.com/Melekit235';
$img_github = 'images/github.png';
$mail = 'Электронная почта: verghel.iliya@gmail.com';



$main = file_get_contents('templates/about.html');

$main= str_replace('{title_page}', $title_page, $main);
$main= str_replace('{style_file}', $style_file, $main);
$main= str_replace('{img_beer}', $img_beer, $main);
$main= str_replace('{name}', $name, $main);



$header = file_get_contents('templates/header.html');

$header = str_replace('{logo_img}',$logo_img,$header);
$header = str_replace('{title}',$title,$header);
$header = str_replace('{link_lager}',$link_lager,$header);
$header = str_replace('{link_porter}',$link_porter,$header);
$header = str_replace('{link_stout}',$link_stout,$header);
$header = str_replace('{title_stout}',$link_stout,$header);
$header = str_replace('{link_feedback}',$link_feedback,$header);

$main= str_replace('{header}', $header, $main);

$text = file_get_contents("text/stout.txt");
$main = str_replace("{text}",$text, $main);

$footer = file_get_contents('templates/footer.html');

$footer = str_replace('{link_github}', $link_github,$footer);
$footer = str_replace('{img_github}', $img_github,$footer);
$footer = str_replace('{mail}', $mail,$footer);

$main = str_replace('{footer}', $footer, $main);



print $main;
