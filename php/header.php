<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Festiwalowy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styleCSS/Style.css"> <!-- Główny CSS -->
</head>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="festiwale.php">Festiwale</a></li>
            <li><a href="o-nas.php">O nas</a></li>
            <li><a href="kontakt.php">Kontakt</a></li>
            
           <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <li class="welcome-message">
        Witaj, <?= htmlspecialchars($_SESSION['imie'] ?? 'Użytkowniku') ?>
    </li>
    
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'wlasciciel'): ?>
        <li><a href="admin_dashboard.php">Panel Admina</a></li>
    <?php else: ?>
        <li><a href="panel_uzytkownika.php">Mój profil</a></li>
    <?php endif; ?>
    
    <li><a href="wyloguj.php">Wyloguj</a></li>
<?php else: ?>
    <li><a href="logowanie.php">Logowanie</a></li>
<?php endif; ?>
        </ul>
    </nav>
</header>