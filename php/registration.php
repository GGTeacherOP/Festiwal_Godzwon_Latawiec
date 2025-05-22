<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Sprawdzenie czy hasła są takie same
    if ($password !== $confirm_password) {
        $error = "Hasła nie są identyczne";
    } else {
        // Sprawdzenie czy email już istnieje
        $check_sql = "SELECT * FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Ten email jest już zarejestrowany";
        } else {
            // Hashowanie hasła
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Dodanie użytkownika do bazy danych
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Rejestracja zakończona sukcesem! Możesz się teraz zalogować.";
                header("Location: logowanie.php");
                exit();
            } else {
                $error = "Wystąpił błąd podczas rejestracji";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - Festiwal Godz W Latawiec</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <?php include 'header.php'; ?>
        
        <main>
            <div class="auth-container">
                <h1>Rejestracja</h1>
                
                <?php if (isset($error)): ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form class="auth-form" method="POST" action="">
                    <div class="form-group">
                        <label for="username">Nazwa użytkownika:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Hasło:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Potwierdź hasło:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="auth-btn">Zarejestruj się</button>
                </form>
                
                <div class="auth-links">
                    <p>Masz już konto? <a href="logowanie.php">Zaloguj się</a></p>
                </div>
            </div>
        </main>
        
        <?php include 'footer.php'; ?>
    </div>
</body>
</html> 