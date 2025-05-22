<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <nav>
        <ul>
            <li><a href="../php/index.php">Strona Główna</a></li>
            <li><a href="../php/festiwale.php">Festiwale</a></li>
            <li><a href="../php/o-nas.php">O nas</a></li>
            <li><a href="../php/kontakt.php">Kontakt</a></li>
            <?php if (isset($_SESSION['id_uzytkownika'])): ?>
                <li class="welcome-message">Witaj, <?php echo htmlspecialchars($_SESSION['nazwa']); ?>!</li>
                <li><a href="../php/wyloguj.php">Wyloguj</a></li>
            <?php else: ?>
                <li><a href="../php/logowanie.php">Logowanie</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header> 