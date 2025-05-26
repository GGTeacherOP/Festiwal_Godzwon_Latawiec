<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Połączenie z bazą danych
require_once 'config.php';

// Pobranie listy wydarzeń
$stmt = $pdo->query("SELECT w.*, k.nazwa as kategoria, l.nazwa as lokalizacja 
                     FROM wydarzenia w 
                     JOIN kategoria_wydarzenia k ON w.kategoria_id = k.kategoria_id 
                     JOIN lokalizacja l ON w.lokalizacja_id = l.lokalizacja_id 
                     ORDER BY w.rozpoczecie");
$wydarzenia = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Wyświetl komunikaty o błędach lub sukcesie
if (isset($_SESSION['blad'])) {
    echo '<div class="error-message">' . htmlspecialchars($_SESSION['blad']) . '</div>';
    unset($_SESSION['blad']);
}
if (isset($_SESSION['sukces'])) {
    echo '<div class="success-message">' . htmlspecialchars($_SESSION['sukces']) . '</div>';
    unset($_SESSION['sukces']);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Festiwale - System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/StyleFestiwal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="wrapper">
        <main>
            <section class="festiwal-list">
                <div class="festiwale-grid">
                    <?php foreach ($wydarzenia as $wydarzenie): ?>
                        <div class="festival-card">
                            <div class="festival-image">
                                <img src="<?php echo htmlspecialchars($wydarzenie['zdjecie'] ?? '../zdjecia/festiwale/default.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($wydarzenie['tytul']); ?>"
                                     onerror="this.src='../zdjecia/festiwale/default.jpg'">
                            </div>
                            <div class="festival-content">
                                <h2><?php echo htmlspecialchars($wydarzenie['tytul']); ?></h2>
                                <span class="kategoria"><?php echo htmlspecialchars($wydarzenie['kategoria']); ?></span>
                                <p class="opis"><?php echo htmlspecialchars($wydarzenie['opis']); ?></p>
                                <div class="festival-details">
                                    <div class="lokalizacja">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($wydarzenie['lokalizacja']); ?>
                                    </div>
                                    <div class="data">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?php 
                                        $data_rozpoczecia = new DateTime($wydarzenie['rozpoczecie']);
                                        $data_zakonczenia = new DateTime($wydarzenie['zakonczenie']);
                                        echo $data_rozpoczecia->format('d.m.Y H:i') . ' - ' . $data_zakonczenia->format('H:i');
                                        ?>
                                    </div>
                                </div>
                                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                                    <form action="kup_bilet.php" method="POST">
                                        <input type="hidden" name="wydarzenia_id" value="<?php echo $wydarzenie['wydarzenia_id']; ?>">
                                        <input type="hidden" name="cena" value="<?php echo isset($wydarzenie['cena']) ? $wydarzenie['cena'] : 0; ?>">
                                        <button type="submit" class="kup-bilet">
                                            Kup bilet (<?php echo number_format($wydarzenie['cena'], 2); ?> zł)
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <p class="login-required">Aby kupić bilet, <a href="logowanie.php">zaloguj się</a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
        <?php include 'footer.php'; ?>
    </div>
    <script src="../JavaScript/festiwaleScript.js"></script>
</body>
</html>