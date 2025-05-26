<?php
session_start();
require_once 'config.php';

// Sprawdź czy użytkownik jest zalogowany
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: logowanie.php");
    exit();
}

// Sprawdź czy formularz został wysłany metodą POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Nieprawidłowa metoda żądania.";
    header("Location: panel_pracownika.php");
    exit();
}

// Pobierz dane z formularza
$tytul = trim($_POST['tytul'] ?? '');
$opis = trim($_POST['opis'] ?? '');
$priorytet = trim($_POST['priorytet'] ?? '');

// Walidacja danych
if (empty($tytul) || empty($opis) || empty($priorytet)) {
    $_SESSION['error'] = "Wszystkie pola są wymagane.";
    header("Location: panel_pracownika.php");
    exit();
}

// Sprawdź czy priorytet jest prawidłowy
$dozwolone_priorytety = ['niski', 'średni', 'wysoki'];
if (!in_array($priorytet, $dozwolone_priorytety)) {
    $_SESSION['error'] = "Nieprawidłowy priorytet.";
    header("Location: panel_pracownika.php");
    exit();
}

try {
    // Dodaj zgłoszenie do bazy danych
    $stmt = $pdo->prepare("INSERT INTO zgłoszenia_problemów (uzytkownicy_id, tytul, opis, priorytet, status) 
                          VALUES (?, ?, ?, ?, 'otwarty')");
    $stmt->execute([$_SESSION['user_id'], $tytul, $opis, $priorytet]);
    
    $_SESSION['success'] = "Problem został zgłoszony pomyślnie.";
} catch (PDOException $e) {
    $_SESSION['error'] = "Wystąpił błąd podczas zgłaszania problemu: " . $e->getMessage();
}

header("Location: panel_pracownika.php");
exit(); 