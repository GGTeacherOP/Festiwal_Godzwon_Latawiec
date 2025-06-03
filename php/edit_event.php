<?php
require_once 'config.php';
session_start();

// Sprawdź uprawnienia
if (!isset($_SESSION['user_id'])) {
    header("Location: logowanie.php");
    exit();
}

// Pobierz rolę użytkownika
$stmt = $pdo->prepare("SELECT rola FROM uzytkownicy WHERE uzytkownicy_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user['rola'] !== 'wlasciciel') {
    header("Location: panel_uzytkownika.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Nieprawidłowe ID wydarzenia.";
    header("Location: panel_wlasciciela.php");
    exit();
}

$id = (int)$_GET['id'];

// Obsługa formularza edycji
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = trim($_POST['tytul']);
    $opis = trim($_POST['opis']);
    $kategoria_id = (int)$_POST['kategoria_id'];
    $rozpoczecie = $_POST['rozpoczecie'];
    $zakonczenie = $_POST['zakonczenie'];
    $cena = (float)$_POST['cena'];

    // Walidacja danych
    $errors = [];
    
    if (empty($tytul)) $errors[] = "Tytuł jest wymagany.";
    if (empty($opis)) $errors[] = "Opis jest wymagany.";
    if ($cena < 0) $errors[] = "Cena nie może być ujemna.";
    
    // Walidacja dat
    $start_date = strtotime($rozpoczecie);
    $end_date = strtotime($zakonczenie);
    
    if ($start_date === false) $errors[] = "Nieprawidłowa data rozpoczęcia.";
    if ($end_date === false) $errors[] = "Nieprawidłowa data zakończenia.";
    if ($end_date < $start_date) $errors[] = "Data zakończenia musi być późniejsza niż data rozpoczęcia.";

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE wydarzenia SET 
                                  tytul = ?, opis = ?, kategoria_id = ?, 
                                  rozpoczecie = ?, zakonczenie = ?, cena = ?
                                  WHERE wydarzenia_id = ?");
            $stmt->execute([$tytul, $opis, $kategoria_id, $rozpoczecie, 
                           $zakonczenie, $cena, $id]);

            $_SESSION['success'] = "Wydarzenie zostało zaktualizowane pomyślnie.";
            header("Location: panel_wlasciciela.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Błąd podczas aktualizacji wydarzenia: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}

// Pobierz dane wydarzenia do edycji
try {
    $stmt = $pdo->prepare("SELECT * FROM wydarzenia WHERE wydarzenia_id = ?");
    $stmt->execute([$id]);
    $event = $stmt->fetch();

    if (!$event) {
        $_SESSION['error'] = "Wydarzenie o podanym ID nie istnieje.";
        header("Location: panel_wlasciciela.php");
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Błąd podczas pobierania danych wydarzenia: " . $e->getMessage();
    header("Location: panel_wlasciciela.php");
    exit();
}

// Pobierz kategorie dla selecta
$categories = $pdo->query("SELECT * FROM kategoria_wydarzenia")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj wydarzenie</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], 
        input[type="number"],
        input[type="datetime-local"],
        textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .error-message {
            color: #a94442;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .btn {
            background-color: #5a60e3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #4a50d3;
        }
        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }
        .btn-cancel:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="form-container">
        <h2>Edytuj wydarzenie: <?= htmlspecialchars($event['tytul']) ?></h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="tytul">Tytuł:</label>
                <input type="text" id="tytul" name="tytul" value="<?= htmlspecialchars($event['tytul']) ?>" required>
            </div>

            <div class="form-group">
                <label for="opis">Opis:</label>
                <textarea id="opis" name="opis" required><?= htmlspecialchars($event['opis']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="kategoria_id">Kategoria:</label>
                <select id="kategoria_id" name="kategoria_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['kategoria_id'] ?>" 
                            <?= $category['kategoria_id'] == $event['kategoria_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['nazwa']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="rozpoczecie">Data i godzina rozpoczęcia:</label>
                <input type="datetime-local" id="rozpoczecie" name="rozpoczecie" 
                       value="<?= date('Y-m-d\TH:i', strtotime($event['rozpoczecie'])) ?>" required>
            </div>

            <div class="form-group">
                <label for="zakonczenie">Data i godzina zakończenia:</label>
                <input type="datetime-local" id="zakonczenie" name="zakonczenie" 
                       value="<?= date('Y-m-d\TH:i', strtotime($event['zakonczenie'])) ?>" required>
            </div>

            <div class="form-group">
                <label for="cena">Cena biletu (PLN):</label>
                <input type="number" id="cena" name="cena" step="0.01" min="0" 
                       value="<?= htmlspecialchars($event['cena']) ?>" required>
            </div>

            <button type="submit" class="btn">Zapisz zmiany</button>
            <a href="panel_wlasciciela.php" class="btn-cancel">Anuluj</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>