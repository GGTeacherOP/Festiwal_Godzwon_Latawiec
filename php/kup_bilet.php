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

    // Debugging
    error_log("Próba zakupu biletu:");
    error_log("User ID: " . $user_id);
    error_log("Wydarzenia ID: " . $wydarzenia_id);
    error_log("Cena: " . $cena);

    if ($wydarzenia_id > 0) {
        try {
            // Sprawdź czy użytkownik istnieje
            $check_user = $pdo->prepare('SELECT uzytkownicy_id FROM uzytkownicy WHERE uzytkownicy_id = ?');
            $check_user->execute([$user_id]);
            if (!$check_user->fetch()) {
                throw new Exception('Nie znaleziono użytkownika o ID: ' . $user_id);
            }

            // Sprawdź czy wydarzenie istnieje
            $check_event = $pdo->prepare('SELECT wydarzenia_id FROM wydarzenia WHERE wydarzenia_id = ?');
            $check_event->execute([$wydarzenia_id]);
            if (!$check_event->fetch()) {
                throw new Exception('Nie znaleziono wydarzenia o ID: ' . $wydarzenia_id);
            }

            // Dodaj bilet do bazy
            $stmt = $pdo->prepare('INSERT INTO bilety (uzytkownicy_id, wydarzenia_id, data_zakupu, cena) VALUES (?, ?, NOW(), ?)');
            $result = $stmt->execute([$user_id, $wydarzenia_id, $cena]);
            
            if ($result) {
                error_log("Bilet został pomyślnie dodany do bazy");
                $_SESSION['sukces'] = 'Zakup biletu zakończony sukcesem!';
                header('Location: panel_uzytkownika.php');
                exit();
            } else {
                throw new Exception('Nie udało się zapisać biletu w bazie danych');
            }
        } catch(Exception $e) {
            error_log("Błąd podczas zakupu biletu: " . $e->getMessage());
            $_SESSION['blad'] = 'Wystąpił błąd podczas zakupu biletu: ' . $e->getMessage();
            header('Location: festiwale.php');
            exit();
        }
    } else {
        error_log("Nieprawidłowe ID wydarzenia: " . $wydarzenia_id);
        $_SESSION['blad'] = 'Nieprawidłowe dane biletu.';
        header('Location: festiwale.php');
        exit();
    }
} else {
    header('Location: festiwale.php');
    exit();
} 