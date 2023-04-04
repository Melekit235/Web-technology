<?php

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//use PHPMailer\PHPMailer\SMTP;


$host = 'localhost';
$dbname = 'site';
$username = 'root';
$password = 'Qwerty';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}

$main = file_get_contents("templates/logReg.html");
$link_style = "style/logReg.css";
$main = str_replace("{link_style}",$link_style,$main);

if(isset($_POST['register'])){
    $count = -1;
    $username = $_POST['usernameR'];

    $stmt = $pdo->prepare("SELECT * FROM site.users WHERE username = ?");
    $stmt->execute([$username]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $content = "Такой пользователь уже зарегистрирован";
    }
    else{
        $password = $_POST['passwordR'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO site.users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();


        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';
        require_once 'PHPMailer/src/Exception.php';

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.yandex.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'sendbeer@yandex.ru';
        $mail->Password = 'spinyjvyzrzvkolj';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('sendbeer@yandex.ru', 'Сообщение с сайта');

        $mail->addAddress($username, 'User');

        $mail->Subject = 'Test email';
        $mail->Body = 'This is a test email';

        if(!$mail->send()){
            header('location: stout.php');
        }

    }
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT id, password FROM site.users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $username = $stmt->fetch();

    if ($username && password_verify($password, $username['password'])) {
        session_start();
        $_SESSION['user_id'] = $username['id'];
        header('location: index.php');
    } else {
        echo "Неверный логин или пароль";
    }
}





print $main;

//c8095de65bef47f6d3a0328a1ecc5728-us17