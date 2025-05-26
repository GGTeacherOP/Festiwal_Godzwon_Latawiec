<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: logowanie.php");
    exit();
}

// Pobierz aktualne dane użytkownika
try {
    $stmt = $pdo->prepare('SELECT * FROM uzytkownicy WHERE uzytkownicy_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['blad'] = 'Nie znaleziono danych użytkownika.';
        header('Location: panel_uzytkownika.php');
        exit();
    }
} catch(PDOException $e) {
    error_log("Błąd podczas pobierania danych użytkownika: " . $e->getMessage());
    $_SESSION['blad'] = 'Wystąpił błąd podczas pobierania danych.';
    header('Location: panel_uzytkownika.php');
    exit();
}

// Obsługa formularza edycji
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);
    $email = trim($_POST['email']);
    $telefon = trim($_POST['telefon']);
    $stare_haslo = $_POST['stare_haslo'];
    $nowe_haslo = $_POST['nowe_haslo'];
    $potwierdz_haslo = $_POST['potwierdz_haslo'];

    $errors = [];

    // Walidacja podstawowych danych
    if (empty($imie)) $errors[] = "Imię jest wymagane";
    if (empty($nazwisko)) $errors[] = "Nazwisko jest wymagane";
    if (empty($email)) $errors[] = "Email jest wymagany";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Nieprawidłowy format email";

    // Sprawdź czy email nie jest już zajęty przez innego użytkownika
    if ($email !== $user['email']) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM uzytkownicy WHERE email = ? AND uzytkownicy_id != ?');
        $stmt->execute([$email, $_SESSION['user_id']]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Ten adres email jest już zajęty";
        }
    }

    // Walidacja hasła (tylko jeśli użytkownik chce je zmienić)
    if (!empty($stare_haslo) || !empty($nowe_haslo) || !empty($potwierdz_haslo)) {
        if (empty($stare_haslo)) $errors[] = "Musisz podać stare hasło";
        if (empty($nowe_haslo)) $errors[] = "Musisz podać nowe hasło";
        if (empty($potwierdz_haslo)) $errors[] = "Musisz potwierdzić nowe hasło";
        if ($nowe_haslo !== $potwierdz_haslo) $errors[] = "Nowe hasła nie są identyczne";
        if (!empty($stare_haslo) && !password_verify($stare_haslo, $user['haslo'])) {
            $errors[] = "Nieprawidłowe stare hasło";
        }
    }

    // Jeśli nie ma błędów, zaktualizuj dane
    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            // Aktualizacja podstawowych danych
            $stmt = $pdo->prepare('UPDATE uzytkownicy SET imie = ?, nazwisko = ?, email = ?, telefon = ? WHERE uzytkownicy_id = ?');
            $stmt->execute([$imie, $nazwisko, $email, $telefon, $_SESSION['user_id']]);

            // Aktualizacja hasła (jeśli podano nowe)
            if (!empty($nowe_haslo)) {
                $hashed_password = password_hash($nowe_haslo, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('UPDATE uzytkownicy SET haslo = ? WHERE uzytkownicy_id = ?');
                $stmt->execute([$hashed_password, $_SESSION['user_id']]);
            }

            $pdo->commit();

            // Aktualizacja danych sesji
            $_SESSION['imie'] = $imie;
            $_SESSION['email'] = $email;

            $_SESSION['sukces'] = 'Dane zostały zaktualizowane pomyślnie!';
            header('Location: panel_uzytkownika.php');
            exit();
        } catch(PDOException $e) {
            $pdo->rollBack();
            error_log("Błąd podczas aktualizacji danych: " . $e->getMessage());
            $errors[] = "Wystąpił błąd podczas aktualizacji danych.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edycja profilu</title>
    <link rel="stylesheet" href="../styleCSS/StyleFestiwal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5em;
            font-weight: 600;
        }

        .edit-form {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .form-section h2 {
            color: #333;
            font-size: 1.5em;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section h2 i {
            color: #5a60e3;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #5a60e3;
            outline: none;
            box-shadow: 0 0 0 2px rgba(90, 96, 227, 0.1);
        }

        .error-list {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .error-list ul {
            margin: 0;
            padding-left: 20px;
        }

        .error-list li {
            margin: 5px 0;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: #5a60e3;
            color: white;
        }

        .btn-primary:hover {
            background: #4347c0;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .password-info {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .edit-form {
                padding: 20px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1 class="page-title">Edycja profilu</h1>
        
        <form class="edit-form" method="POST" action="">
            <?php if (!empty($errors)): ?>
                <div class="error-list">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-section">
                <h2><i class="fas fa-user"></i> Dane osobowe</h2>
                <div class="form-group">
                    <label for="imie">Imię</label>
                    <input type="text" id="imie" name="imie" value="<?= htmlspecialchars($user['imie']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="nazwisko">Nazwisko</label>
                    <input type="text" id="nazwisko" name="nazwisko" value="<?= htmlspecialchars($user['nazwisko']) ?>" required>
                </div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-envelope"></i> Dane kontaktowe</h2>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="tel" id="telefon" name="telefon" value="<?= htmlspecialchars($user['telefon']) ?>">
                </div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-lock"></i> Zmiana hasła</h2>
                <p class="password-info">Wypełnij poniższe pola tylko jeśli chcesz zmienić hasło.</p>
                
                <div class="form-group">
                    <label for="stare_haslo">Stare hasło</label>
                    <input type="password" id="stare_haslo" name="stare_haslo">
                </div>

                <div class="form-group">
                    <label for="nowe_haslo">Nowe hasło</label>
                    <input type="password" id="nowe_haslo" name="nowe_haslo">
                </div>

                <div class="form-group">
                    <label for="potwierdz_haslo">Potwierdź nowe hasło</label>
                    <input type="password" id="potwierdz_haslo" name="potwierdz_haslo">
                </div>
            </div>

            <div class="buttons">
                <a href="panel_uzytkownika.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Anuluj
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Zapisz zmiany
                </button>
            </div>
        </form>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html> 