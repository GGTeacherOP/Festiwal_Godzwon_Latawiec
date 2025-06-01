<?php
session_start();
require_once 'config.php';

// Sprawdź czy użytkownik jest zalogowany i właścicielem
if (!isset($_SESSION['user_id'])) {
    header("Location: logowanie.php");
    exit();
}

$stmt = $pdo->prepare("SELECT rola FROM uzytkownicy WHERE uzytkownicy_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user['rola'] !== 'wlasciciel') {
    header("Location: panel_uzytkownika.php");
    exit();
}

// Obsługa usuwania użytkownika
if (isset($_GET['delete_user'])) {
    $id = (int)$_GET['delete_user'];
    $stmt = $pdo->prepare("DELETE FROM uzytkownicy WHERE uzytkownicy_id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'Użytkownik został usunięty';
    header("Location: panel_wlasciciela.php");
    exit();
}

// Obsługa usuwania wydarzenia
if (isset($_GET['delete_event'])) {
    $id = (int)$_GET['delete_event'];
    $stmt = $pdo->prepare("DELETE FROM wydarzenia WHERE wydarzenia_id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'Wydarzenie zostało usunięte';
    header("Location: panel_wlasciciela.php");
    exit();
}

// Pobierz wszystkich aktywnych użytkowników
$users = $pdo->query("SELECT * FROM uzytkownicy")->fetchAll();
// Jeśli kolumna aktywny istnieje, użyj: 
// $users = $pdo->query("SELECT * FROM uzytkownicy WHERE aktywny = 1")->fetchAll();

// Pobierz wszystkie wydarzenia
$events = $pdo->query("SELECT w.*, k.nazwa AS kategoria 
                      FROM wydarzenia w
                      JOIN kategoria_wydarzenia k ON w.kategoria_id = k.kategoria_id")->fetchAll();

// Pobierz wszystkie rezerwacje
$bookings = $pdo->query("SELECT r.*, u.imie, u.nazwisko, n.nazwa AS nocleg
                        FROM rezerwacje_noclegow r
                        JOIN uzytkownicy u ON r.uzytkownicy_id = u.uzytkownicy_id
                        JOIN noclegi n ON r.nocleg_id = n.nocleg_id")->fetchAll();

// Podsumowanie finansowe
$dochody = $pdo->query("SELECT COALESCE(SUM(w.cena), 0) as suma FROM bilety b JOIN wydarzenia w ON b.wydarzenia_id = w.wydarzenia_id")->fetch(PDO::FETCH_ASSOC)['suma'] ?? 0;
$wydatki = $pdo->query("SELECT SUM(kwota) as suma FROM zarobki")->fetch(PDO::FETCH_ASSOC)['suma'] ?? 0;
$zarobki = $pdo->query("SELECT SUM(zarobki) as suma FROM pracownicy")->fetch(PDO::FETCH_ASSOC)['suma'] ?? 0;
$bilans = $dochody - $wydatki;

// Obsługa usuwania użytkownika
if (isset($_GET['delete_user'])) {
    $id = (int)$_GET['delete_user'];
    
    try {
        $pdo->beginTransaction();
        
        // 1. Usuń powiązane rekordy w tabeli uczestnicy
        $stmt = $pdo->prepare("DELETE FROM uczestnicy WHERE uzytkownicy_id = ?");
        $stmt->execute([$id]);
        
        // 2. Usuń powiązane rezerwacje noclegów
        $stmt = $pdo->prepare("DELETE FROM rezerwacje_noclegow WHERE uzytkownicy_id = ?");
        $stmt->execute([$id]);
        
        // 3. Usuń powiązane bilety (jeśli istnieje taka tabela)
        // $stmt = $pdo->prepare("DELETE FROM bilety WHERE uzytkownicy_id = ?");
        // $stmt->execute([$id]);
        
        // 4. Na końcu usuń użytkownika
        $stmt = $pdo->prepare("DELETE FROM uzytkownicy WHERE uzytkownicy_id = ?");
        $stmt->execute([$id]);
        
        $pdo->commit();
        
        $_SESSION['success'] = 'Użytkownik został usunięty wraz z wszystkimi powiązanymi danymi';
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = 'Nie można usunąć użytkownika: ' . $e->getMessage();
        error_log("Błąd usuwania użytkownika ID $id: " . $e->getMessage());
    }
    
    header("Location: panel_wlasciciela.php");
    exit();
}
// Pobierz użytkowników (tylko aktywnych jeśli kolumna istnieje)
try {
    $check_active = $pdo->query("SHOW COLUMNS FROM uzytkownicy LIKE 'aktywny'")->fetch();
    if ($check_active) {
        $users = $pdo->query("SELECT * FROM uzytkownicy WHERE aktywny = 1")->fetchAll();
    } else {
        $users = $pdo->query("SELECT * FROM uzytkownicy")->fetchAll();
    }
} catch (PDOException $e) {
    $users = [];
    error_log("Błąd pobierania użytkowników: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel właściciela</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <style>
        .admin-section {
            margin-bottom: 40px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #5a60e3;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .action-links a {
            margin-right: 10px;
            color: #5a60e3;
            text-decoration: none;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        .success-message {
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        tr.inactive-user {
    background-color: #ffecec;
    color: #999;
}

    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="dashboard" style="max-width:1200px; margin:0 auto; padding:20px;">
        <h1>Panel właściciela</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <section class="admin-section">
            <h2>Zarządzanie użytkownikami</h2>
            <table>
                <tr class="<?= (isset($user['aktywny']) && $user['aktywny'] == 0) ? 'inactive-user' : '' ?>">
                    <th>ID</th>
                    <th>Imię i nazwisko</th>
                    <th>Email</th>
                    <th>Rola</th>
                    <th>Akcje</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['uzytkownicy_id'] ?></td>
                    <td>
    <?= htmlspecialchars($user['imie'] . ' ' . $user['nazwisko']) ?>
    <?= (isset($user['aktywny']) && $user['aktywny'] == 0) ? ' (nieaktywny)' : '' ?>
</td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['rola'] ?></td>
                    <td class="action-links">
                        <a href="edit_user.php?id=<?= $user['uzytkownicy_id'] ?>">Edytuj</a>
                        <a href="panel_wlasciciela.php?delete_user=<?= $user['uzytkownicy_id'] ?>" 
                           onclick="return confirm('Na pewno usunąć tego użytkownika?')">Usuń</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <section class="admin-section">
            <h2>Zarządzanie wydarzeniami</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tytuł</th>
                    <th>Kategoria</th>
                    <th>Data</th>
                    <th>Akcje</th>
                </tr>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= $event['wydarzenia_id'] ?></td>
                    <td><?= htmlspecialchars($event['tytul']) ?></td>
                    <td><?= htmlspecialchars($event['kategoria']) ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($event['rozpoczecie'])) ?></td>
                    <td class="action-links">
                        <a href="edit_event.php?id=<?= $event['wydarzenia_id'] ?>" class="btn-edit">Edytuj</a>
                        <a href="panel_wlasciciela.php?delete_event=<?= $event['wydarzenia_id'] ?>"
                           onclick="return confirm('Na pewno usunąć to wydarzenie?')">Usuń</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>


        <div class="admin-section">
            <h2>Podsumowanie finansowe</h2>
            <table style="width:100%; font-size:1.1em;">
                <tr><th style="text-align:left;">Dochody (bilety):</th><td style="text-align:right;"><b><?= number_format($dochody,2,',',' ') ?> zł</b></td></tr>
                <tr><th style="text-align:left;">Wydatki (wypłaty):</th><td style="text-align:right;"><b><?= number_format($wydatki,2,',',' ') ?> zł</b></td></tr>
                <tr><th style="text-align:left;">Suma zarobków pracowników:</th><td style="text-align:right;"><b><?= number_format($zarobki,2,',',' ') ?> zł</b></td></tr>
                <tr><th style="text-align:left;">Bilans:</th><td style="text-align:right;"><b><?= number_format($bilans,2,',',' ') ?> zł</b></td></tr>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>