<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: logowanie.php");
    exit();
}

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'wlasciciel') {
    header('Location: panel_wlasciciela.php');
    exit();
}

// Fetch user data from database if not in session
if (!isset($_SESSION['imie']) || !isset($_SESSION['email'])) {
    try {
        $stmt = $pdo->prepare('SELECT imie, email FROM uzytkownicy WHERE uzytkownicy_id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $_SESSION['imie'] = $user['imie'];
            $_SESSION['email'] = $user['email'];
        }
    } catch(PDOException $e) {
        error_log("Błąd podczas pobierania danych użytkownika: " . $e->getMessage());
    }
}

// Debugging
error_log("Panel użytkownika - Session data:");
error_log("User ID: " . $_SESSION['user_id']);
error_log("Email: " . $_SESSION['email']);
error_log("Imię: " . ($_SESSION['imie'] ?? 'brak'));
error_log("Logged in: " . ($_SESSION['logged_in'] ? 'true' : 'false'));

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mój Profil</title>
    <link rel="stylesheet" href="../styleCSS/StyleFestiwal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5em;
            font-weight: 600;
        }

        .dashboard-box {
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .dashboard-box:hover {
            transform: translateY(-5px);
        }

        .dashboard-box h2 {
            color: #333;
            border-bottom: 2px solid #5a60e3;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .user-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #5a60e3;
        }

        .info-item strong {
            color: #5a60e3;
            display: block;
            margin-bottom: 5px;
            font-size: 1.1em;
        }

        .bilety-lista {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .bilet {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .bilet:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .bilet::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #5a60e3;
        }

        .bilet h3 {
            color: #333;
            margin: 0 0 15px 0;
            font-size: 1.4em;
            padding-left: 10px;
        }

        .bilet-info {
            margin: 10px 0;
            color: #666;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bilet-info i {
            color: #5a60e3;
            width: 20px;
        }

        .bilet-numer {
            font-family: monospace;
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 5px;
            color: #5a60e3;
            font-size: 0.9em;
            display: inline-block;
            margin-top: 10px;
        }

        .brak-biletow {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 12px;
            color: #666;
        }

        .brak-biletow p {
            margin: 10px 0;
        }

        .brak-biletow a {
            color: #5a60e3;
            text-decoration: none;
            font-weight: bold;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .action-group {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #5a60e3;
        }

        .action-group h3 {
            color: #333;
            font-size: 1.2em;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-group h3 i {
            color: #5a60e3;
        }

        .action-group .btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #333;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            width: 100%;
        }

        .action-group .btn:hover {
            background: #5a60e3;
            color: white;
            transform: translateY(-2px);
        }

        .action-group .btn i {
            width: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }

        .success-message, .error-message {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1 class="page-title">Panel Użytkownika</h1>

        <?php
        // Wyświetl komunikaty
        if (isset($_SESSION['sukces'])) {
            echo '<div class="success-message">' . htmlspecialchars($_SESSION['sukces']) . '</div>';
            unset($_SESSION['sukces']);
        }
        if (isset($_SESSION['blad'])) {
            echo '<div class="error-message">' . htmlspecialchars($_SESSION['blad']) . '</div>';
            unset($_SESSION['blad']);
        }
        ?>
        
        <div class="dashboard-box">
            <h2><i class="fas fa-user"></i> Twoje dane</h2>
            <div class="user-info">
                <div class="info-item">
                    <strong>Imię</strong>
                    <?= htmlspecialchars($_SESSION['imie'] ?? 'Nie podano') ?>
                </div>
                <div class="info-item">
                    <strong>Email</strong>
                    <?= htmlspecialchars($_SESSION['email'] ?? 'Nie podano') ?>
                </div>
            </div>
        </div>
        
        <div class="dashboard-box">
            <h2><i class="fas fa-ticket-alt"></i> Twoje bilety</h2>
            <?php
            try {
                $stmt = $pdo->prepare('
                    SELECT b.bilet_id, w.tytul, w.rozpoczecie, w.zakonczenie, w.cena, l.nazwa as lokalizacja, k.nazwa as kategoria
                    FROM bilety b 
                    JOIN wydarzenia w ON b.wydarzenia_id = w.wydarzenia_id
                    JOIN lokalizacja l ON w.lokalizacja_id = l.lokalizacja_id
                    JOIN kategoria_wydarzenia k ON w.kategoria_id = k.kategoria_id
                    WHERE b.uzytkownicy_id = ?
                    ORDER BY w.rozpoczecie ASC
                ');
                $stmt->execute([$_SESSION['user_id']]);
                $bilety = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if ($bilety): ?>
                    <div class="bilety-lista">
                        <?php foreach ($bilety as $bilet): 
                            $data_rozpoczecia = new DateTime($bilet['rozpoczecie']);
                            $data_zakonczenia = new DateTime($bilet['zakonczenie']);
                        ?>
                            <div class="bilet">
                                <h3><?= htmlspecialchars($bilet['tytul']) ?></h3>
                                <p class="bilet-info">
                                    <i class="fas fa-theater-masks"></i>
                                    <?= htmlspecialchars($bilet['kategoria']) ?>
                                </p>
                                <p class="bilet-info">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($bilet['lokalizacja']) ?>
                                </p>
                                <p class="bilet-info">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?= $data_rozpoczecia->format('d.m.Y H:i') ?> - <?= $data_zakonczenia->format('H:i') ?>
                                </p>
                                <p class="bilet-info">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <?= number_format($bilet['cena'], 2) ?> zł
                                </p>
                                <p class="bilet-info">
                                    <i class="fas fa-ticket-alt"></i>
                                    <span class="bilet-numer">Bilet #<?= htmlspecialchars($bilet['bilet_id']) ?></span>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="brak-biletow">
                        <i class="fas fa-ticket-alt fa-3x" style="color: #5a60e3; margin-bottom: 20px;"></i>
                        <p>Nie masz jeszcze żadnych biletów.</p>
                        <p>Przejdź do sekcji festiwali, aby kupić swój pierwszy bilet!</p>
                        <a href="festiwale.php" class="btn">
                            <i class="fas fa-calendar-alt"></i>
                            Zobacz dostępne festiwale
                        </a>
                    </div>
                <?php endif;
            } catch (PDOException $e) {
                error_log("Błąd podczas pobierania biletów: " . $e->getMessage());
                echo '<div class="error-message">Wystąpił błąd podczas pobierania biletów. Spróbuj odświeżyć stronę.</div>';
            }
            ?>
        </div>
        
        <div class="dashboard-box">
            <h2><i class="fas fa-bolt"></i> Szybkie akcje</h2>
            <div class="quick-actions">
                <div class="action-group">
                    <h3><i class="fas fa-ticket-alt"></i> Bilety</h3>
                    <a href="festiwale.php" class="btn">
                        <i class="fas fa-calendar-alt"></i>
                        Kup nowy bilet
                    </a>
                    <a href="moje_bilety.php" class="btn">
                        <i class="fas fa-list"></i>
                        Historia biletów
                    </a>
                </div>

                <div class="action-group">
                    <h3><i class="fas fa-user-cog"></i> Konto</h3>
                    <a href="edit_profile.php" class="btn">
                        <i class="fas fa-user-edit"></i>
                        Edytuj profil
                    </a>
                    <a href="kontakt.php" class="btn">
                        <i class="fas fa-envelope"></i>
                        Kontakt
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>