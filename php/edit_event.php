<?php
require_once 'config.php';
session_start();

// Sprawdź uprawnienia
if (!isset($_SESSION['user_id']) || $user['rola'] !== 'wlasciciel') {
    header("Location: logowanie.php");
    exit();
}

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Brak ID wydarzenia.";
    header("Location: panel_wlasciciela.php");
    exit();
}

$id = (int)$_GET['id'];

// Obsługa formularza edycji
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = $_POST['tytul'];
    $opis = $_POST['opis'];
    $kategoria_id = (int)$_POST['kategoria_id'];
    $rozpoczecie = $_POST['rozpoczecie'];
    $zakonczenie = $_POST['zakonczenie'];
    $cena = (float)$_POST['cena'];
    $miejsce = $_POST['miejsce'];
    $limit_uczestnikow = (int)$_POST['limit_uczestnikow'];

    try {
        $stmt = $pdo->prepare("UPDATE wydarzenia SET 
                              tytul = ?, opis = ?, kategoria_id = ?, 
                              rozpoczecie = ?, zakonczenie = ?, cena = ?,
                              miejsce = ?, limit_uczestnikow = ?
                              WHERE wydarzenia_id = ?");
        $stmt->execute([$tytul, $opis, $kategoria_id, $rozpoczecie, 
                       $zakonczenie, $cena, $miejsce, $limit_uczestnikow, $id]);

        $_SESSION['success'] = "Wydarzenie zostało zaktualizowane.";
        header("Location: panel_wlasciciela.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Błąd podczas aktualizacji wydarzenia: " . $e->getMessage();
    }
}

// Pobierz dane wydarzenia do edycji
$stmt = $pdo->prepare("SELECT * FROM wydarzenia WHERE wydarzenia_id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    $_SESSION['error'] = "Wydarzenie nie istnieje.";
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
        }
        textarea {
            height: 100px;
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
                <label>Tytuł:</label>
                <input type="text" name="tytul" value="<?= htmlspecialchars($event['tytul']) ?>" required>
            </div>

            <div class="form-group">
                <label>Opis:</label>
                <textarea name="opis" required><?= htmlspecialchars($event['opis']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Kategoria:</label>
                <select name="kategoria_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['kategoria_id'] ?>" 
                            <?= $category['kategoria_id'] == $event['kategoria_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['nazwa']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Data i godzina rozpoczęcia:</label>
                <input type="datetime-local" name="rozpoczecie" 
                       value="<?= date('Y-m-d\TH:i', strtotime($event['rozpoczecie'])) ?>" required>
            </div>

            <div class="form-group">
                <label>Data i godzina zakończenia:</label>
                <input type="datetime-local" name="zakonczenie" 
                       value="<?= date('Y-m-d\TH:i', strtotime($event['zakonczenie'])) ?>" required>
            </div>

            <div class="form-group">
                <label>Cena biletu (PLN):</label>
                <input type="number" name="cena" step="0.01" min="0" 
                       value="<?= htmlspecialchars($event['cena']) ?>" required>
            </div>

            <div class="form-group">
                <label>Miejsce:</label>
                <input type="text" name="miejsce" value="<?= htmlspecialchars($event['miejsce']) ?>" required>
            </div>

            <div class="form-group">
                <label>Limit uczestników:</label>
                <input type="number" name="limit_uczestnikow" min="1" 
                       value="<?= htmlspecialchars($event['limit_uczestnikow']) ?>">
            </div>

            <button type="submit" class="btn">Zapisz zmiany</button>
            <a href="panel_wlasciciela.php" class="btn-cancel">Anuluj</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>