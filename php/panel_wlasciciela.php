<?php
session_start();
require_once 'config.php';

// Sprawdź czy użytkownik jest adminem
$stmt = $pdo->prepare("SELECT rola FROM uzytkownicy WHERE uzytkownicy_id = ?");
$stmt->execute([$_SESSION['id_uzytkownika']]);
$user = $stmt->fetch();

if ($user['rola'] !== 'admin') {
    header("Location: user_dashboard.php");
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
            <a href="add_user.php" class="btn">Dodaj użytkownika</a>
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
            <a href="add_event.php" class="btn">Dodaj wydarzenie</a>
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
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>