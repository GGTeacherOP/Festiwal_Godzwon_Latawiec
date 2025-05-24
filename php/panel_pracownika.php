<?php
session_start();
require_once 'config.php';

// Sprawdź czy użytkownik jest pracownikiem
$stmt = $pdo->prepare("SELECT rola FROM uzytkownicy WHERE uzytkownicy_id = ?");
$stmt->execute([$_SESSION['id_uzytkownika']]);
$user = $stmt->fetch();

if ($user['rola'] !== 'pracownik') {
    header("Location: user_dashboard.php");
    exit();
}

// Pobierz oczekujące rezerwacje
$bookings = $pdo->query("SELECT r.*, u.imie, u.nazwisko, n.nazwa AS nocleg
                        FROM rezerwacje_noclegow r
                        JOIN uzytkownicy u ON r.uzytkownicy_id = u.uzytkownicy_id
                        JOIN noclegi n ON r.nocleg_id = n.nocleg_id
                        WHERE r.status = 'oczekująca'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel pracownika</title>
    <style>
        .pending-booking {
            background-color: #fff3cd;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="dashboard">
        <h1>Panel pracownika</h1>

        <section>
            <h2>Oczekujące rezerwacje</h2>
            <?php foreach ($bookings as $booking): ?>
            <div class="pending-booking">
                <p><strong>Użytkownik:</strong> <?= htmlspecialchars($booking['imie'] . ' ' . $booking['nazwisko']) ?></p>
                <p><strong>Nocleg:</strong> <?= htmlspecialchars($booking['nocleg']) ?></p>
                <p><strong>Okres:</strong> <?= date('d.m.Y', strtotime($booking['data_przyjazdu'])) ?> - <?= date('d.m.Y', strtotime($booking['data_wyjazdu'])) ?></p>
                <form method="POST" action="process_booking.php">
                    <input type="hidden" name="rezerwacja_id" value="<?= $booking['rezerwacja_id'] ?>">
                    <button type="submit" name="action" value="approve" class="btn">Potwierdź</button>
                    <button type="submit" name="action" value="reject" class="btn">Odrzuć</button>
                </form>
            </div>
            <?php endforeach; ?>
        </section>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>