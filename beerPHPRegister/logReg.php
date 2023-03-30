<?php
session_start();

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

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        //$main = str_replace('<div style="display: none;">{message}</div>',"Такой пользователь уже зарегистрирован",$main);
        $content = "Такой пользователь уже зарегистрирован";
    }
    else{
        $password = $_POST['passwordR'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $usernameR);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        echo "Регистрация прошла успешно";
    }


}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = :username');
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

