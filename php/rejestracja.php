<?php
// Połączenie z bazą danych
$host = "localhost";
$db_user = "root"; // zastąp odpowiednią nazwą użytkownika
$db_password = ""; // zastąp odpowiednim hasłem
$db_name = "projekt_godzwon_latawiec";

$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Przetwarzanie danych formularza
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Walidacja i zabezpieczenie danych wejściowych
    $nazwa = $_POST['nazwa'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $data_urodzenia = $_POST['data_urodzenia'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $haslo = password_hash($_POST['haslo'], PASSWORD_DEFAULT); // Hashowanie hasła
    
    // Sprawdzenie unikalności nazwy użytkownika i emaila
    $check_query = "SELECT * FROM uzytkownicy WHERE nazwa = ? OR email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $nazwa, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Użytkownik już istnieje
        echo "<script>alert('Nazwa użytkownika lub email jest już zajęty!'); window.location.href='../php/rejestracje.php';</script>";
        exit();
    }
    
    // Wstawienie nowego użytkownika do bazy danych
    $insert_query = "INSERT INTO uzytkownicy (nazwa, imie, nazwisko, data_urodzenia, email, telefon, haslo) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sssssss", $nazwa, $imie, $nazwisko, $data_urodzenia, $email, $telefon, $haslo);
    
    if ($stmt->execute()) {
        // Rejestracja udana
        echo "<script>alert('Rejestracja zakończona sukcesem! Możesz się teraz zalogować.'); window.location.href='../php/logowanie.php';</script>";
    } else {
        // Błąd podczas rejestracji
        echo "<script>alert('Wystąpił błąd podczas rejestracji: " . $conn->error . "'); window.location.href='../php/rejestracje.php';</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>