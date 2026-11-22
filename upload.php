<?php
require 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $cat = $_POST['category'] ?? '';
    $validCats = get_categories();
    if (!in_array($cat, $validCats)) {
        die('Неверная категория');
    }
    $file = $_FILES['file'];
    $name = basename($file['name']);
    $name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
    $dest = FILES_DIR . $cat . '/' . $name;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        header('Location: admin.php');
    } else {
        echo 'Ошибка загрузки';
    }
}
?>