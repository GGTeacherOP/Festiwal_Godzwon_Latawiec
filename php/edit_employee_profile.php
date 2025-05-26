<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: logowanie.php");
    exit();
}

// Pobierz dane użytkownika
$stmt = $pdo->prepare("SELECT imie, nazwisko, email, telefon FROM uzytkownicy WHERE uzytkownicy_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie'] ?? '');
    $nazwisko = trim($_POST['nazwisko'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');

    // Walidacja
    if ($imie === '' || $nazwisko === '' || $email === '') {
        $_SESSION['error'] = 'Imię, nazwisko i email są wymagane.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE uzytkownicy SET imie = ?, nazwisko = ?, email = ?, telefon = ? WHERE uzytkownicy_id = ?");
            $stmt->execute([$imie, $nazwisko, $email, $telefon, $_SESSION['user_id']]);
            $_SESSION['success'] = 'Dane zostały zaktualizowane.';
            header('Location: panel_pracownika.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Błąd podczas aktualizacji danych: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj dane pracownika</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .edit-form-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .edit-form-container h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            padding: 10px 20px;
            background: #5a60e3;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover {
            background: #4a4fd3;
        }
        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 18px;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="edit-form-container">
        <h2>Edytuj dane osobowe</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="imie">Imię:</label>
                <input type="text" id="imie" name="imie" value="<?= htmlspecialchars($user['imie'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="nazwisko">Nazwisko:</label>
                <input type="text" id="nazwisko" name="nazwisko" value="<?= htmlspecialchars($user['nazwisko'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="telefon">Telefon:</label>
                <input type="text" id="telefon" name="telefon" value="<?= htmlspecialchars($user['telefon'] ?? '') ?>">
            </div>
            <button type="submit" class="btn">Zapisz zmiany</button>
        </form>
        <div style="text-align:center;margin-top:15px;">
            <a href="panel_pracownika.php">Powrót do panelu</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 