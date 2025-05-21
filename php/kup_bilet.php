<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['error_message'] = "Musisz być zalogowany, aby kupić bilet.";
    header("Location: logowanie.php");
    exit();
}

// Połączenie z bazą danych
$host = 'localhost';
$dbname = 'projekt_godzwon_latawiec';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Błąd połączenia z bazą danych: " . $e->getMessage();
    exit();
}

// Sprawdzenie czy otrzymano ID wydarzenia
if (isset($_POST['wydarzenia_id'])) {
    $wydarzenia_id = $_POST['wydarzenia_id'];
    $uzytkownicy_id = $_SESSION['uzytkownicy_id'];
    
    try {
        // Pobranie informacji o wydarzeniu
        $stmt = $pdo->prepare("SELECT w.tytul, k.nazwa as kategoria 
                              FROM wydarzenia w 
                              JOIN kategoria_wydarzenia k ON w.kategoria_id = k.kategoria_id 
                              WHERE w.wydarzenia_id = ?");
        $stmt->execute([$wydarzenia_id]);
        $wydarzenie = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($wydarzenie) {
            // Przygotowanie opisu biletu
            $opis = "Bilet na " . $wydarzenie['tytul'] . " - " . $wydarzenie['kategoria'];
            
            // Dodanie biletu do bazy danych
            $stmt = $pdo->prepare("INSERT INTO bilety (uzytkownicy_id, wydarzenia_id, data_zakupu, opis) 
                                 VALUES (?, ?, NOW(), ?)");
            $stmt->execute([$uzytkownicy_id, $wydarzenia_id, $opis]);
            
            // Przekierowanie z komunikatem o sukcesie
            $_SESSION['sukces'] = "Bilet został pomyślnie zakupiony!";
            header('Location: festiwale.php');
            exit();
        } else {
            throw new Exception("Nie znaleziono wydarzenia");
        }
    } catch(Exception $e) {
        $_SESSION['blad'] = "Wystąpił błąd podczas zakupu biletu: " . $e->getMessage();
        header('Location: festiwale.php');
        exit();
    }
} else {
    $_SESSION['blad'] = "Nie wybrano wydarzenia";
    header('Location: festiwale.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kup Bilet - System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Strona Główna</a></li>
                    <li><a href="festiwale.php">Festiwale</a></li>
                    <li><a href="o-nas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                        echo '<li class="welcome-message">Witaj, ' . htmlspecialchars($_SESSION['user_name']) . '!</li>';
                        echo '<li><a href="wyloguj.php">Wyloguj</a></li>';
                    } else {
                        echo '<li><a href="logowanie.php">Logowanie</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </header>
    </div>
</body>
</html> 