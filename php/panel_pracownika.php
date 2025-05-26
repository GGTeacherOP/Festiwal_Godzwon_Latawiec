<?php
session_start();
require_once 'config.php';

// Sprawdź czy użytkownik jest zalogowany
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: logowanie.php");
    exit();
}

// Sprawdź czy użytkownik jest pracownikiem
$stmt = $pdo->prepare("SELECT u.*, p.stanowisko, p.zarobki, p.data_zatrudnienia 
                      FROM uzytkownicy u 
                      LEFT JOIN pracownicy p ON u.uzytkownicy_id = p.uzytkownicy_id 
                      WHERE u.uzytkownicy_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$employee_roles = ['sprzataczka', 'informatyk', 'organizator', 'technik sceniczny', 'specjalista ds. promocji', 'koordynator wolontariuszy'];

if (!in_array($user['rola'], $employee_roles)) {
    header("Location: panel_uzytkownika.php");
    exit();
}

// Pobierz historię wypłat
$wplaty = $pdo->prepare("SELECT * FROM zarobki WHERE uzytkownicy_id = ? ORDER BY data_wyplaty DESC LIMIT 5");
$wplaty->execute([$_SESSION['user_id']]);
$historia_wyplat = $wplaty->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel pracownika</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .dashboard-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #5a60e3;
        }
        .info-card h3 {
            color: #5a60e3;
            margin-top: 0;
        }
        .salary-history {
            margin-top: 20px;
        }
        .salary-history table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .salary-history th, .salary-history td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .salary-history th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="dashboard">
        <h1>Panel pracownika - <?= htmlspecialchars($user['rola']) ?></h1>

        <div class="info-grid">
            <div class="info-card">
                <h3><i class="fas fa-user"></i> Dane osobowe</h3>
                <p><strong>Imię i nazwisko:</strong> <?= htmlspecialchars(($user['imie'] ?? '') . ' ' . ($user['nazwisko'] ?? '')) ?: 'Nie podano' ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'Nie podano') ?></p>
                <p><strong>Telefon:</strong> <?= htmlspecialchars($user['telefon'] ?? 'Nie podano') ?></p>
                <a href="edit_employee_profile.php" class="btn" style="margin-top:10px;display:inline-block;">Edytuj dane</a>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-briefcase"></i> Informacje o zatrudnieniu</h3>
                <p><strong>Stanowisko:</strong> <?= htmlspecialchars($user['stanowisko'] ?? $user['rola']) ?></p>
                <p><strong>Data zatrudnienia:</strong> <?= htmlspecialchars($user['data_zatrudnienia'] ?? 'Nie podano') ?></p>
                <p><strong>Zarobki:</strong> <?= htmlspecialchars($user['zarobki'] ?? 'Nie podano') ?> zł</p>
            </div>
        </div>

        <div class="dashboard-section">
            <h2><i class="fas fa-history"></i> Historia wypłat</h2>
            <?php if (empty($historia_wyplat)): ?>
                <p>Brak historii wypłat.</p>
            <?php else: ?>
                <div class="salary-history">
                    <table>
                        <thead>
                            <tr>
                                <th>Data wypłaty</th>
                                <th>Kwota</th>
                                <th>Opis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historia_wyplat as $wyplata): ?>
                            <tr>
                                <td><?= htmlspecialchars($wyplata['data_wyplaty']) ?></td>
                                <td><?= htmlspecialchars($wyplata['kwota']) ?> zł</td>
                                <td><?= htmlspecialchars($wyplata['opis']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>