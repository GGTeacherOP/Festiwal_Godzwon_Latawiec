<?php
session_start();
require_once 'config.php';

// Sprawdź czy użytkownik jest zalogowany
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: logowanie.php");
    exit();
}

// Sprawdź czy otrzymano ID zadania i akcję
if (!isset($_POST['zadanie_id']) || !isset($_POST['action'])) {
    $_SESSION['error'] = "Brak wymaganych danych.";
    header("Location: panel_pracownika.php");
    exit();
}

$zadanie_id = $_POST['zadanie_id'];
$action = $_POST['action'];

try {
    // Sprawdź czy zadanie należy do zalogowanego użytkownika
    $stmt = $pdo->prepare("SELECT uzytkownicy_id FROM zadania_pracownika WHERE zadanie_id = ?");
    $stmt->execute([$zadanie_id]);
    $zadanie = $stmt->fetch();

    if (!$zadanie || $zadanie['uzytkownicy_id'] != $_SESSION['user_id']) {
        $_SESSION['error'] = "Nie masz uprawnień do modyfikacji tego zadania.";
        header("Location: panel_pracownika.php");
        exit();
    }

    // Aktualizuj status zadania
    if ($action === 'complete') {
        $stmt = $pdo->prepare("UPDATE zadania_pracownika SET status = 'zakończone' WHERE zadanie_id = ?");
        $stmt->execute([$zadanie_id]);
        $_SESSION['success'] = "Zadanie zostało oznaczone jako wykonane.";
    } else {
        $_SESSION['error'] = "Nieprawidłowa akcja.";
    }

} catch (PDOException $e) {
    $_SESSION['error'] = "Wystąpił błąd podczas aktualizacji zadania: " . $e->getMessage();
}

header("Location: panel_pracownika.php");
exit(); 