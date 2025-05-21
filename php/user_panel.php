<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['error_message'] = "Musisz być zalogowany, aby uzyskać dostęp do panelu użytkownika.";
    header("Location: logowanie.php");
    exit();
}

// Database connection
$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "projekt_godzwon_latawiec";

try {
    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
    $conn->set_charset("utf8mb4");
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get user role from database
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT p.stanowisko FROM pracownicy p WHERE p.uzytkownicy_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $user_role = 'klient'; // Default role
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_role = strtolower($row['stanowisko']);
    }
    
    $stmt->close();
} catch (Exception $e) {
    die("Błąd systemu: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Użytkownika - <?php echo ucfirst($user_role); ?></title>
    <link rel="stylesheet" href="../styleCSS/StylLogRej.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .panel-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .panel-header {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .panel-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .panel-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .panel-card h3 {
            margin-top: 0;
            color: #333;
        }
        .panel-card ul {
            list-style: none;
            padding: 0;
        }
        .panel-card li {
            margin: 10px 0;
        }
        .panel-card a {
            color: #007bff;
            text-decoration: none;
        }
        .panel-card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Strona Główna</a></li>
                    <li><a href="festiwale.php">Festiwale</a></li>
                    <li><a href="o-nas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                        echo '<li class="welcome-message">Witaj, ' . htmlspecialchars($_SESSION['user_name']) . '!</li>';
                        echo '<li><a href="wyloguj.php">Wyloguj</a></li>';
                    } else {
                        echo '<li><a href="logowanie.php">Logowanie</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </header>
        
        <main>
            <div class="panel-container">
                <div class="panel-header">
                    <h1>Panel <?php echo ucfirst($user_role); ?>a</h1>
                    <p>Witaj, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
                </div>

                <div class="panel-content">
                    <?php if ($user_role === 'wlasciciel'): ?>
                        <!-- Panel właściciela -->
                        <div class="panel-card">
                            <h3>Zarządzanie Festiwalem</h3>
                            <ul>
                                <li><a href="#"><i class="fas fa-calendar-alt"></i> Harmonogram wydarzeń</a></li>
                                <li><a href="#"><i class="fas fa-users"></i> Zarządzanie pracownikami</a></li>
                                <li><a href="#"><i class="fas fa-chart-line"></i> Statystyki i raporty</a></li>
                                <li><a href="#"><i class="fas fa-money-bill-wave"></i> Finanse</a></li>
                            </ul>
                        </div>
                        <div class="panel-card">
                            <h3>Administracja</h3>
                            <ul>
                                <li><a href="#"><i class="fas fa-cog"></i> Ustawienia systemu</a></li>
                                <li><a href="#"><i class="fas fa-user-shield"></i> Zarządzanie uprawnieniami</a></li>
                                <li><a href="#"><i class="fas fa-file-alt"></i> Dokumentacja</a></li>
                            </ul>
                        </div>

                    <?php elseif ($user_role === 'informatyk'): ?>
                        <!-- Panel informatyka -->
                        <div class="panel-card">
                            <h3>Zarządzanie Systemem</h3>
                            <ul>
                                <li><a href="#"><i class="fas fa-server"></i> Status serwerów</a></li>
                                <li><a href="#"><i class="fas fa-database"></i> Baza danych</a></li>
                                <li><a href="#"><i class="fas fa-shield-alt"></i> Bezpieczeństwo</a></li>
                            </ul>
                        </div>
                        <div class="panel-card">
                            <h3>Wsparcie Techniczne</h3>
                            <ul>
                                <li><a href="#"><i class="fas fa-ticket-alt"></i> Zgłoszenia</a></li>
                                <li><a href="#"><i class="fas fa-tools"></i> Konserwacja</a></li>
                                <li><a href="#"><i class="fas fa-book"></i> Dokumentacja techniczna</a></li>
                            </ul>
                        </div>

                    <?php elseif ($user_role === 'sprzataczka'): ?>
                        <!-- Panel sprzątaczki -->
                        <div class="panel-card">
                            <h3>Harmonogram Pracy</h3>
                            <ul>
                                <li><a href="#"><i class="fas fa-calendar-check"></i> Grafik sprzątania</a></li>
                                <li><a href="#"><i class="fas fa-clipboard-list"></i> Lista zadań</a></li>
                                <li><a href="#"><i class="fas fa-check-circle"></i> Raport wykonanych prac</a></li>
                            </ul>
                        </div>
                        <div class="panel-card">
                            <h3>Zarządzanie Zasobami</h3>
                            <ul>
                                <li><a href="#"><i class="fas fa-broom"></i> Stan zapasów</a></li>
                                <li><a href="#"><i class="fas fa-exclamation-triangle"></i> Zgłoszenia problemów</a></li>
                            </ul>
                        </div>

                    <?php else: ?>
                        <!-- Panel klienta -->
                        <div class="panel-card">
                            <h3>Moje Konto</h3>
                            <ul>
                                <li><a href="#"><i class="fas fa-user-edit"></i> Edycja profilu</a></li>
                                <li><a href="#"><i class="fas fa-ticket-alt"></i> Moje bilety</a></li>
                                <li><a href="#"><i class="fas fa-bed"></i> Moje rezerwacje</a></li>
                            </ul>
                        </div>
                        <div class="panel-card">
                            <h3>Zakupy i Rezerwacje</h3>
                            <ul>
                                <li><a href="#"><i class="fas fa-shopping-cart"></i> Koszyk</a></li>
                                <li><a href="#"><i class="fas fa-history"></i> Historia zakupów</a></li>
                                <li><a href="#"><i class="fas fa-star"></i> Ulubione wydarzenia</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <footer>
            <div class="footer-content">
                <div class="footer-links">
                    <a href="#">Regulamin</a> |
                    <a href="#">Polityka Prywatności</a>
                </div>
                <div class="social-links">
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://instagram.com" target="_blank" class="instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com" target="_blank" class="twitter" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://youtube.com" target="_blank" class="youtube" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
                <p>&copy; 2025 System Festiwalowy. Wszelkie prawa zastrzeżone.</p>
            </div>
        </footer>
    </div>
</body>
</html> 