<?php

$con = new mysqli("localhost", "root", "", "projekt_godzwon_latawiec");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa = htmlspecialchars(trim($_POST['nazwa']));
    $imie = htmlspecialchars(trim($_POST['imie']));
    $nazwisko = htmlspecialchars(trim($_POST['nazwisko']));
    $data_urodzenia = $_POST['data_urodzenia'];
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefon = htmlspecialchars(trim($_POST['telefon']));
    $haslo = password_hash($_POST['haslo'], PASSWORD_DEFAULT);
    
    $check_query = "SELECT * FROM uzytkownicy WHERE nazwa = ? OR email = ?";
    $stmt = $con->prepare($check_query);
    $stmt->bind_param("ss", $nazwa, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Nazwa użytkownika lub email jest już zajęty!'); window.location.href='rejestracja.html';</script>";
        exit();
    }
    
    $insert_query = "INSERT INTO uzytkownicy (nazwa, imie, nazwisko, data_urodzenia, email, telefon, haslo) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($insert_query);
    $stmt->bind_param("sssssss", $nazwa, $imie, $nazwisko, $data_urodzenia, $email, $telefon, $haslo);
    
    if ($stmt->execute()) {
        echo "<script>alert('Rejestracja zakończona sukcesem! Możesz się teraz zalogować.'); window.location.href='logowanie.html';</script>";
    } else {
        echo "<script>alert('Wystąpił błąd podczas rejestracji: " . $con->error . "'); window.location.href='rejestracja.html';</script>";
    }
    
    $stmt->close();
}

$con->close();
?>