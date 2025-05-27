<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa_uzytkownika = $_POST['nazwa_uzytkownika'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $data_urodzenia = $_POST['data_urodzenia'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $haslo = $_POST['haslo'];
    $potwierdz_haslo = $_POST['potwierdz_haslo'];
    $data_dodania = date('Y-m-d H:i:s');
    
    // Sprawdzenie czy hasła są identyczne
    if ($haslo !== $potwierdz_haslo) {
        $blad = "Hasła nie są identyczne";
    } else {
        // Sprawdzenie czy email lub nazwa użytkownika już istnieje
        $sql = "SELECT * FROM uzytkownicy WHERE email = ? OR nazwa = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            $blad = "Błąd przygotowania zapytania: " . $conn->error;
        } else {
            $stmt->bind_param("ss", $email, $nazwa_uzytkownika);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $blad = "Ten email lub nazwa użytkownika jest już zarejestrowany";
            } else {
                // Hashowanie hasła i dodanie nowego użytkownika
                $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
                $sql = "INSERT INTO uzytkownicy (nazwa, imie, nazwisko, data_urodzenia, email, telefon, haslo, data_dodania) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                
                if ($stmt === false) {
                    $blad = "Błąd przygotowania zapytania: " . $conn->error;
                } else {
                    $stmt->bind_param("ssssssss", $nazwa_uzytkownika, $imie, $nazwisko, $data_urodzenia, $email, $telefon, $haslo_hash, $data_dodania);
                    
                    if ($stmt->execute()) {
                        $_SESSION['sukces'] = "Rejestracja zakończona sukcesem! Możesz się teraz zalogować.";
                        header("Location: ../php/logowanie.php");
                        exit();
                    } else {
                        $blad = "Wystąpił błąd podczas rejestracji: " . $stmt->error;
                    }
                }
            }
            $stmt->close();
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
    <style>
        .auth-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-group label {
            font-weight: bold;
            color: #2c3e50;
        }
        
        .form-group input {
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus {
            border-color: #5a60e3;
            outline: none;
        }
        
        .auth-btn {
            background: linear-gradient(90deg, #5a60e3, #7c83ff);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .auth-btn:hover {
            transform: translateY(-2px);
        }
        
        .auth-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .auth-links a {
            color: #5a60e3;
            text-decoration: none;
            font-weight: bold;
        }
        
        .auth-links a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .success-message {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'header.php'; ?>
        
        <main>
            <div class="auth-container">
                <h1>Rejestracja</h1>
                
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
                        <label for="nazwa_uzytkownika">Nazwa użytkownika:</label>
                        <input type="text" id="nazwa_uzytkownika" name="nazwa_uzytkownika" required>
                    </div>

                    <div class="form-group">
                        <label for="imie">Imię:</label>
                        <input type="text" id="imie" name="imie" required>
                    </div>

                    <div class="form-group">
                        <label for="nazwisko">Nazwisko:</label>
                        <input type="text" id="nazwisko" name="nazwisko" required>
                    </div>

                    <div class="form-group">
                        <label for="data_urodzenia">Data urodzenia:</label>
                        <input type="date" id="data_urodzenia" name="data_urodzenia" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefon">Telefon:</label>
                        <input type="tel" id="telefon" name="telefon" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="haslo">Hasło:</label>
                        <input type="password" id="haslo" name="haslo" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="potwierdz_haslo">Potwierdź hasło:</label>
                        <input type="password" id="potwierdz_haslo" name="potwierdz_haslo" required>
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