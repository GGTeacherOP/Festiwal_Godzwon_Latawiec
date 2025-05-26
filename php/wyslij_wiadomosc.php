<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare('INSERT INTO wiadomosci_kontaktowe (nazwisko_imie, email, wiadomosc) VALUES (?, ?, ?)');
    $stmt->execute([$name, $email, $message]);

    header('Location: kontakt.php');
    exit;
}
?> 