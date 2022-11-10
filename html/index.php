<?php

try {
    $pdo = new PDO('mysql:dbname=money;host=mysql', 'root', '');

    echo 'Соединение с базой успешно установлено';
} catch (PDOException $exception) {
    echo 'Произошла ошибка';
}
