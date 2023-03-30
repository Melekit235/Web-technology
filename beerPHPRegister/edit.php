<?php

$main = file_get_contents('templates/edit.html');

$host = 'localhost';
$dbname = 'site';
$username = 'root';
$password = 'Qwerty';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare('SELECT * FROM site.beer WHERE id = ?');
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        if ($user) {

            $name = $user['name'];
            $link = $user['link'];
            $text = $user['text'];
            $imgL = $user['imgL'];
            $form = file_get_contents('templates/formEdit.html');
            $form = str_replace('{name}',$name,$form);
            $form = str_replace('{link}',$link,$form);
            $form = str_replace('{text}',$text,$form);
            $form = str_replace('{imgL}',$imgL,$form);
            $main = str_replace('<div style="display: none;">{form_Edit}</div>',"   <form method='post' action=''>
                                                                                                  <input type='hidden' name='id' value='" . $user["id"] . "'>
                                                                                                    <input type='text' name='name' value='" . $user["name"] . "'>
                                                                                                    <input type='text' name='link' value='" . $user["link"] . "'>
                                                                                                    <input type='text' name='text' value='" . $user["text"] . "'>
                                                                                                    <input type='text' name='imgL' value='" . $user["imgL"] . "'>
                                                                                                    <input type='submit' name='save' value='Сохранить'>
                                                                                                   </form>",$main);

        }else {
            echo 'Пользователь с указанным ID не найден';
        }
    }

    if (isset($_POST['save'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $link = $_POST['link'];
        $text = $_POST['text'];
        $imgL = $_POST['imgL'];
        $stmt = $pdo->prepare('UPDATE site.beer SET name = ? WHERE id = ?');
        $stmt->execute([$name,$id]);
        if ($stmt->rowCount() > 0) {
            echo 'Изменения успешно сохранены';
        } else {
            echo 'Изменения не были сохранены';
        }
        unset($_POST['id']);
        header("Location: ".$_SERVER['PHP_SELF']);

    }
} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
} finally {
    $dbh = null;
}


print $main;