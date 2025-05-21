<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and has appropriate role
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['error_message'] = "Musisz być zalogowany, aby uzyskać dostęp do panelu właściciela.";
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
    <title>Panel Właściciela - System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin-top: 0;
            color: #333;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
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
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-warning {
            background: #ffc107;
            color: black;
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
                <!-- Statystyki -->
                <div class="stat-card">
                    <h3>Statystyki Festiwalu</h3>
                    <?php
                    // Pobierz statystyki z bazy danych
                    $stats = [
                        'sprzedane_bilety' => 0,
                        'przychod' => 0,
                        'liczba_uczestnikow' => 0
                    ];
                    
                    // Przykładowe zapytania do bazy danych
                    $result = $conn->query("SELECT COUNT(*) as count FROM bilety");
                    if ($row = $result->fetch_assoc()) {
                        $stats['sprzedane_bilety'] = $row['count'];
                    }
                    ?>
                    <div class="stat-value"><?php echo $stats['sprzedane_bilety']; ?></div>
                    <p>Sprzedane bilety</p>
                </div>

                <!-- Zarządzanie Pracownikami -->
                <div class="stat-card">
                    <h3>Zarządzanie Pracownikami</h3>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Dodaj Pracownika</a>
                        <a href="#" class="btn btn-warning">Lista Pracowników</a>
                    </div>
                </div>

                <!-- Finanse -->
                <div class="stat-card">
                    <h3>Finanse</h3>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Raport Finansowy</a>
                        <a href="#" class="btn btn-success">Dodaj Przychód</a>
                    </div>
                </div>

                <!-- Harmonogram -->
                <div class="stat-card">
                    <h3>Harmonogram Wydarzeń</h3>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Dodaj Wydarzenie</a>
                        <a href="#" class="btn btn-warning">Edytuj Harmonogram</a>
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