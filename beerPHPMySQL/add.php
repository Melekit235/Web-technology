<?php
$imagePath = "images/1.jpg";

// Читаем содержимое файла в бинарном режиме
$imageData = file_get_contents($imagePath);


// Устанавливаем параметры для подключения к базе данных
$host = 'localhost';
$dbname = 'site';
$username = 'root';
$password = 'Qwerty';


echo "sdvj";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // установить режим обработки ошибок для PDO

    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'");


    for ($i = 1; $i <= 3; $i++) {


        $stmt = $pdo->prepare('SELECT * FROM link WHERE id = :id');
        $stmt->bindParam(':id', $i, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row['link'];

        //$main = str_replace('{beer' . (string)$i . '}', file_get_contents('templates/beer.html'), $main);


    }

} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}





// Закрываем соединение с базой данных
$dbh = null;

