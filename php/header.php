<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'config.php';
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Festiwalowy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styleCSS/Style.css"> <!-- Główny CSS -->
    <style>
    .profile-link {
        font-weight: bold;
        font-size: 1.1em;
        color: white !important;
        background-color: rgba(255,255,255,0.12);
        border-radius: 8px;
        padding: 10px 16px;
        margin-left: 10px;
        transition: background 0.2s;
    }
    .profile-link:hover {
        background-color: rgba(255,255,255,0.22);
        color: #d2e3ff !important;
    }
    </style>
</head>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="festiwale.php">Festiwale</a></li>
            <li><a href="o-nas.php">O nas</a></li>
            <li><a href="kontakt.php">Kontakt</a></li>
            <?php
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                $stmt = $pdo->prepare('SELECT imie, rola FROM uzytkownicy WHERE uzytkownicy_id = ?');
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $imie = $user ? $user['imie'] : 'Użytkowniku';
                echo '<li class="welcome-message">Witaj, ' . htmlspecialchars($imie) . '!</li>';

                if ($user['rola'] === 'wlasciciel') {
                    echo '<li><a href="panel_wlasciciela.php" class="profile-link">Panel admina</a></li>';
                } elseif (in_array($user['rola'], [
                    'sprzataczka', 'informatyk', 'organizator', 'technik sceniczny',
                    'specjalista ds. promocji', 'koordynator wolontariuszy'
                ])) {
                    echo '<li><a href="panel_pracownika.php" class="profile-link">Panel pracownika</a></li>';
                } else {
                    echo '<li><a href="panel_uzytkownika.php" class="profile-link">Mój profil</a></li>';
                }
                echo '<li><a href="wyloguj.php">Wyloguj</a></li>';
            } else {
                echo '<li><a href="logowanie.php">Logowanie</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>