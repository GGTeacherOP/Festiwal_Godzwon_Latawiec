<?php
session_start();

// Dane do połączenia z bazą danych (z pliku projekt_godzwon_latawiec.sql)
$host = 'localhost'; // Zazwyczaj 'localhost'
$db_name = 'projekt_godzwon_latawiec'; // Zmień na nazwę Twojej bazy danych
$db_user = 'root'; // Zmień na nazwę użytkownika Twojej bazy danych
$db_password = ''; // Zmień na hasło do Twojej bazy danych

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Zapytanie do bazy danych o użytkownika o podanej nazwie
    $stmt = $pdo->prepare("SELECT uzytkownicy_id, nazwa, haslo FROM uzytkownicy WHERE nazwa = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        // Weryfikacja hasła (należy używać password_verify!)
        // Zakładam, że hasło w bazie jest zahaszowane, np. przy użyciu password_hash()
        if (password_verify($password, $user['haslo'])) {
            // Logowanie udane, ustaw sesję
            $_SESSION['user_id'] = $user['uzytkownicy_id'];
            $_SESSION['username'] = $user['nazwa'];
            echo '<script>alert("Zalogowano!");</script>'; // Dodany alert
            header("Location: ../php/index.php"); // Przekieruj do panelu użytkownika
            exit();
        } else {
            $error = "Nieprawidłowa nazwa użytkownika lub hasło.";
        }
    } else {
        $error = "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
}
?>