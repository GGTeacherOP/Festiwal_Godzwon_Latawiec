<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and has appropriate role
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['error_message'] = "Musisz być zalogowany, aby uzyskać dostęp do panelu sprzątaczki.";
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
    <title>Panel Sprzątaczki - System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .task-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .task-card h3 {
            margin-top: 0;
            color: #333;
        }
        .task-list {
            margin-top: 15px;
        }
        .task-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .task-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .status-pending {
            background: #ffc107;
            color: black;
        }
        .status-completed {
            background: #28a745;
            color: white;
        }
        .status-in-progress {
            background: #007bff;
            color: white;
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
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 15px;
        }
        .schedule-day {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
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
                <!-- Harmonogram Pracy -->
                <div class="task-card">
                    <h3>Harmonogram Pracy</h3>
                    <div class="schedule-grid">
                        <?php
                        $days = ['Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob', 'Nd'];
                        foreach ($days as $day) {
                            echo "<div class='schedule-day'>$day</div>";
                        }
                        ?>
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Zobacz Pełny Grafik</a>
                    </div>
                </div>

                <!-- Lista Zadań -->
                <div class="task-card">
                    <h3>Dzisiejsze Zadania</h3>
                    <div class="task-list">
                        <div class="task-item">
                            <span>Sprzątanie sali koncertowej</span>
                            <span class="task-status status-pending">Oczekujące</span>
                        </div>
                        <div class="task-item">
                            <span>Mycie toalet</span>
                            <span class="task-status status-in-progress">W trakcie</span>
                        </div>
                        <div class="task-item">
                            <span>Opróżnienie koszy</span>
                            <span class="task-status status-completed">Zakończone</span>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-success">Oznacz jako Zakończone</a>
                    </div>
                </div>

                <!-- Stan Zapasów -->
                <div class="task-card">
                    <h3>Stan Zapasów</h3>
                    <div class="task-list">
                        <div class="task-item">
                            <span>Środki czystości</span>
                            <span>Dostateczny</span>
                        </div>
                        <div class="task-item">
                            <span>Worki na śmieci</span>
                            <span>Niski</span>
                        </div>
                        <div class="task-item">
                            <span>Ręczniki papierowe</span>
                            <span>Wystarczający</span>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-warning">Złóż Zamówienie</a>
                    </div>
                </div>

                <!-- Zgłoszenia -->
                <div class="task-card">
                    <h3>Zgłoszenia Problemów</h3>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Nowe Zgłoszenie</a>
                        <a href="#" class="btn btn-warning">Historia Zgłoszeń</a>
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