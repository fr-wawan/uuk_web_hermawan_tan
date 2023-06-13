<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=uuk_web', 'root', '');
} catch (PDOException $e) {
    echo $e->getMessage();
}
