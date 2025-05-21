<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and has appropriate role
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['error_message'] = "Musisz być zalogowany, aby uzyskać dostęp do panelu informatyka.";
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
} catch (Exception $e) {
    die("Błąd systemu: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Informatyka - System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .system-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .system-card h3 {
            margin-top: 0;
            color: #333;
        }
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .status-ok {
            background: #28a745;
        }
        .status-warning {
            background: #ffc107;
        }
        .status-error {
            background: #dc3545;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-warning {
            background: #ffc107;
            color: black;
        }
        .ticket-list {
            margin-top: 20px;
        }
        .ticket-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
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
            <div class="dashboard">
                <!-- Status Systemu -->
                <div class="system-card">
                    <h3>Status Systemu</h3>
                    <div class="status-item">
                        <span class="status-indicator status-ok"></span>
                        Serwer WWW
                    </div>
                    <div class="status-item">
                        <span class="status-indicator status-ok"></span>
                        Baza Danych
                    </div>
                    <div class="status-item">
                        <span class="status-indicator status-warning"></span>
                        System Kopii Zapasowych
                    </div>
                </div>

                <!-- Zgłoszenia -->
                <div class="system-card">
                    <h3>Zgłoszenia Techniczne</h3>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Nowe Zgłoszenie</a>
                        <a href="#" class="btn btn-warning">Lista Zgłoszeń</a>
                    </div>
                    <div class="ticket-list">
                        <div class="ticket-item">
                            <strong>#1234</strong> - Problem z logowaniem
                            <span class="status-badge">W trakcie</span>
                        </div>
                        <div class="ticket-item">
                            <strong>#1233</strong> - Awaria serwera
                            <span class="status-badge">Rozwiązane</span>
                        </div>
                    </div>
                </div>

                <!-- Konserwacja -->
                <div class="system-card">
                    <h3>Konserwacja Systemu</h3>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Planuj Konserwację</a>
                        <a href="#" class="btn btn-warning">Historia Konserwacji</a>
                    </div>
                </div>

                <!-- Bezpieczeństwo -->
                <div class="system-card">
                    <h3>Bezpieczeństwo</h3>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Audyt Bezpieczeństwa</a>
                        <a href="#" class="btn btn-danger">Logi Systemowe</a>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="footer-content">
                <p>&copy; 2025 System Festiwalowy. Wszelkie prawa zastrzeżone.</p>
            </div>
        </footer>
    </div>
</body>
</html> 