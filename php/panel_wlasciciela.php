<?php
session_start();
require_once 'config.php';

// Sprawdź czy użytkownik jest adminem
$stmt = $pdo->prepare("SELECT rola FROM uzytkownicy WHERE uzytkownicy_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user['rola'] !== 'wlasciciel') {
    header("Location: panel_uzytkownika.php");
    exit();
}

// Pobierz wszystkich użytkowników
$users = $pdo->query("SELECT * FROM uzytkownicy")->fetchAll();

// Pobierz wszystkie wydarzenia
$events = $pdo->query("SELECT w.*, k.nazwa AS kategoria 
                      FROM wydarzenia w
                      JOIN kategoria_wydarzenia k ON w.kategoria_id = k.kategoria_id")->fetchAll();

// Pobierz wszystkie rezerwacje
$bookings = $pdo->query("SELECT r.*, u.imie, u.nazwisko, n.nazwa AS nocleg
                        FROM rezerwacje_noclegow r
                        JOIN uzytkownicy u ON r.uzytkownicy_id = u.uzytkownicy_id
                        JOIN noclegi n ON r.nocleg_id = n.nocleg_id")->fetchAll();

// --- PODSUMOWANIE FINANSOWE ---
// Dochody (przychody z biletów)
$dochody = $pdo->query("SELECT COALESCE(SUM(w.cena), 0) as suma FROM bilety b JOIN wydarzenia w ON b.wydarzenia_id = w.wydarzenia_id")->fetch(PDO::FETCH_ASSOC)['suma'] ?? 0;
// Wydatki (wypłaty dla pracowników)
$wydatki = $pdo->query("SELECT SUM(kwota) as suma FROM zarobki")->fetch(PDO::FETCH_ASSOC)['suma'] ?? 0;
// Suma zarobków pracowników
$zarobki = $pdo->query("SELECT SUM(zarobki) as suma FROM pracownicy")->fetch(PDO::FETCH_ASSOC)['suma'] ?? 0;
// Bilans
$bilans = $dochody - $wydatki;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administratora</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <style>
        .admin-section {
            margin-bottom: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .action-links a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="dashboard">
        <h1>Panel administratora</h1>

        <section class="admin-section">
            <h2>Zarządzanie użytkownikami</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Imię i nazwisko</th>
                    <th>Email</th>
                    <th>Rola</th>
                    <th>Akcje</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['uzytkownicy_id'] ?></td>
                    <td><?= htmlspecialchars($user['imie'] . ' ' . $user['nazwisko']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['rola'] ?></td>
                    <td class="action-links">
                        <a href="edit_user.php?id=<?= $user['uzytkownicy_id'] ?>">Edytuj</a>
                        <a href="delete_user.php?id=<?= $user['uzytkownicy_id'] ?>" 
                           onclick="return confirm('Na pewno usunąć użytkownika?')">Usuń</a>
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
                        <a href="edit_event.php?id=<?= $event['wydarzenia_id'] ?>">Edytuj</a>
                        <a href="delete_event.php?id=<?= $event['wydarzenia_id'] ?>"
                           onclick="return confirm('Na pewno usunąć wydarzenie?')">Usuń</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <section class="admin-section">
            <h2>Rezerwacje noclegów</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Użytkownik</th>
                    <th>Nocleg</th>
                    <th>Okres</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking['rezerwacja_id'] ?></td>
                    <td><?= htmlspecialchars($booking['imie'] . ' ' . $booking['nazwisko']) ?></td>
                    <td><?= htmlspecialchars($booking['nocleg']) ?></td>
                    <td>
                        <?= date('d.m.Y', strtotime($booking['data_przyjazdu'])) ?> - 
                        <?= date('d.m.Y', strtotime($booking['data_wyjazdu'])) ?>
                    </td>
                    <td><?= ucfirst($booking['status']) ?></td>
                    <td>
                        <a href="edit_booking.php?id=<?= $booking['rezerwacja_id'] ?>">Edytuj</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <div class="dashboard-box" style="max-width:500px;margin:30px auto 30px auto;">
            <h2>Podsumowanie finansowe</h2>
            <table style="width:100%;font-size:1.1em;">
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