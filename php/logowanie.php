<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    
    $sql = "SELECT * FROM uzytkownicy WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $uzytkownik = $result->fetch_assoc();
        if (password_verify($haslo, $uzytkownik['haslo'])) {
            $_SESSION['id_uzytkownika'] = $uzytkownik['id'];
            $_SESSION['email'] = $uzytkownik['email'];
            $_SESSION['nazwa'] = $uzytkownik['nazwa_uzytkownika'];
            $_SESSION['sukces'] = "Zalogowano pomyślnie! Witaj " . $uzytkownik['nazwa_uzytkownika'] . "!";
            header("Location: index.php");
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