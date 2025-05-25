<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: logowanie.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $wydarzenia_id = isset($_POST['wydarzenia_id']) ? intval($_POST['wydarzenia_id']) : 0;
    $cena = isset($_POST['cena']) ? floatval($_POST['cena']) : 0;

    if ($wydarzenia_id > 0) {
        // Dodaj bilet do bazy
        $stmt = $pdo->prepare('INSERT INTO bilety (uzytkownicy_id, wydarzenia_id, data_zakupu) VALUES (?, ?, NOW())');
        $stmt->execute([$user_id, $wydarzenia_id]);

        $_SESSION['sukces'] = 'Zakup biletu zakończony sukcesem!';
        header('Location: mojprofil.php');
        exit();
    } else {
        $_SESSION['sukces'] = 'Nieprawidłowe dane biletu.';
        header('Location: festiwale.php');
        exit();
    }
} else {
    header('Location: festiwale.php');
    exit();
} 