<?php
session_start();
require_once 'config.php';

// Połączenie z bazą przez PDO (jeśli nie istnieje)
if (!isset($pdo)) {
    $host = 'localhost';
    $dbname = 'projekt_godzwon_latawiec';
    $username = 'root';
    $password = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Błąd połączenia z bazą danych: " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    
    $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE email = ?");
    $stmt->execute([$email]);
    $uzytkownik = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($uzytkownik) {
        if (password_verify($haslo, $uzytkownik['haslo'])) {
            // Ustaw wszystkie potrzebne dane sesji
            $_SESSION['user_id'] = $uzytkownik['uzytkownicy_id'];
            $_SESSION['email'] = $uzytkownik['email'];
            $_SESSION['imie'] = $uzytkownik['imie'];
            $_SESSION['user_role'] = $uzytkownik['rola'] ?? 'user';
            $_SESSION['logged_in'] = true;
            
            // Redirect based on user role
            if ($uzytkownik['rola'] === 'wlasciciel') {
                header("Location: panel_wlasciciela.php");
            } elseif (in_array($uzytkownik['rola'], ['sprzataczka', 'informatyk', 'organizator', 'technik sceniczny', 'specjalista ds. promocji', 'koordynator wolontariuszy'])) {
                header("Location: panel_pracownika.php");
            } else {
                header("Location: panel_uzytkownika.php");
            }
            exit();
        } else {
            $blad = "Nieprawidłowe hasło";
        }
    } else {
        $blad = "Użytkownik nie istnieje";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - Festiwal Godz W Latawiec</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <?php include 'header.php'; ?>
        
        <main>
            <div class="auth-container">
                <h1>Logowanie</h1>
                
                <?php if (isset($blad)): ?>
                    <div class="error-message">
                        <?php echo $blad; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['sukces'])): ?>
                    <div class="success-message">
                        <?php 
                        echo $_SESSION['sukces'];
                        unset($_SESSION['sukces']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <form class="auth-form" method="POST" action="">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="haslo">Hasło:</label>
                        <input type="password" id="haslo" name="haslo" required>
                    </div>
                    
                    <button type="submit" class="auth-btn">Zaloguj się</button>
                </form>
                
                <div class="auth-links">
                    <p>Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a></p>
                </div>
            </div>
        </main>
        
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>