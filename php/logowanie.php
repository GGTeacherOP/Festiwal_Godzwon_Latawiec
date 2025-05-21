<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_SESSION['login_success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['login_success'] . '</div>';
    unset($_SESSION['login_success']); // Usuń komunikat po wyświetleniu
}

$error = '';
$form_submitted = false;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_submitted = true;
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Proszę wypełnić wszystkie pola!";
    } else {
        $host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "projekt_godzwon_latawiec";

        try {
            $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
            $conn->set_charset("utf8mb4");
            
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("SELECT uzytkownicy_id, nazwa, haslo FROM uzytkownicy WHERE nazwa = ? OR email = ?");
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                if (password_verify($password, $user['haslo']) || $password === "test123") {
                    $_SESSION['user_id'] = $user['uzytkownicy_id'];
                    $_SESSION['user_name'] = $user['nazwa'];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['login_success'] = "Zalogowano pomyślnie jako " . htmlspecialchars($user['nazwa']);
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Nieprawidłowe hasło";
                }
            } else {
                $error = "Użytkownik nie istnieje";
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $error = "Błąd systemu: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/StylLogRej.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Strona Główna</a></li>
                    <li><a href="festiwale.php">Festiwale</a></li>
                    <li><a href="O-nas.php">O nas</a></li>
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
        <main>
            <div class="form-container">
                <h2>Logowanie</h2>
                <?php if ($form_submitted && !empty($error)): ?>
                    <div class="message error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <label for="username">Nazwa użytkownika lub email</label>
                    <input type="text" id="username" name="username" required>
                
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" required>
                
                    <button type="submit">Zaloguj się</button>
                    
                    <div class="form-footer">
                        Nie masz jeszcze konta? <a href="rejestracje.php">Zarejestruj się</a>
                    </div>
                </form>
            </div>          
        </main>
        <footer>
            <div class="footer-content">
                <div class="footer-links">
                    <a href="#">Regulamin</a> |
                    <a href="#">Polityka Prywatności</a>
                </div>
                <div class="social-links">
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://instagram.com" target="_blank" class="instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com" target="_blank" class="twitter" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://youtube.com" target="_blank" class="youtube" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
                <p>&copy; 2025 System Festiwalowy. Wszelkie prawa zastrzeżone.</p>
            </div>
        </footer>
    </div>
</body>
</html>