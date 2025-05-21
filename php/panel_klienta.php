<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: logowanie.php');
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

// Get user's tickets
$user_id = $_SESSION['user_id'];
$tickets_query = "SELECT b.*, w.tytul, w.rozpoczecie 
                 FROM bilety b 
                 JOIN wydarzenia w ON b.wydarzenia_id = w.wydarzenia_id 
                 WHERE b.uzytkownicy_id = ?";
$stmt = $conn->prepare($tickets_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tickets_result = $stmt->get_result();

// Get user's reservations
$reservations_query = "SELECT r.*, n.nazwa as nocleg_nazwa 
                      FROM rezerwacje_noclegow r 
                      JOIN noclegi n ON r.nocleg_id = n.nocleg_id 
                      WHERE r.uzytkownicy_id = ?";
$stmt = $conn->prepare($reservations_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$reservations_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Klienta - Moje Konto</title>
    <link rel="stylesheet" href="../styleCSS/StylLogRej.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .account-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .account-card h3 {
            margin-top: 0;
            color: #333;
        }
        .ticket-list, .reservation-list {
            margin-top: 15px;
        }
        .ticket-item, .reservation-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ticket-info, .reservation-info {
            flex-grow: 1;
        }
        .ticket-title, .reservation-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .ticket-date, .reservation-date {
            color: #666;
            font-size: 0.9em;
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
        .profile-info {
            margin-top: 15px;
        }
        .profile-item {
            margin: 10px 0;
        }
        .profile-label {
            font-weight: bold;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Strona Główna</a></li>
                    <li><a href="user_panel.php">Panel Główny</a></li>
                    <li><a href="wyloguj.php">Wyloguj</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="dashboard">
                <!-- Profil Użytkownika -->
                <div class="account-card">
                    <h3>Mój Profil</h3>
                    <div class="profile-info">
                        <?php
                        $user_query = "SELECT * FROM uzytkownicy WHERE uzytkownicy_id = ?";
                        $stmt = $conn->prepare($user_query);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $user_result = $stmt->get_result();
                        if ($user = $user_result->fetch_assoc()) {
                            echo "<div class='profile-item'>";
                            echo "<span class='profile-label'>Imię i Nazwisko:</span> ";
                            echo htmlspecialchars($user['imie'] . ' ' . $user['nazwisko']);
                            echo "</div>";
                            echo "<div class='profile-item'>";
                            echo "<span class='profile-label'>Email:</span> ";
                            echo htmlspecialchars($user['email']);
                            echo "</div>";
                            echo "<div class='profile-item'>";
                            echo "<span class='profile-label'>Telefon:</span> ";
                            echo htmlspecialchars($user['telefon']);
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Edytuj Profil</a>
                    </div>
                </div>

                <!-- Moje Bilety -->
                <div class="account-card">
                    <h3>Moje Bilety</h3>
                    <div class="ticket-list">
                        <?php
                        if ($tickets_result->num_rows > 0) {
                            while ($ticket = $tickets_result->fetch_assoc()) {
                                echo "<div class='ticket-item'>";
                                echo "<div class='ticket-info'>";
                                echo "<div class='ticket-title'>" . htmlspecialchars($ticket['tytul']) . "</div>";
                                echo "<div class='ticket-date'>" . date('d.m.Y H:i', strtotime($ticket['rozpoczecie'])) . "</div>";
                                echo "</div>";
                                echo "<a href='#' class='btn btn-warning'>Szczegóły</a>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Nie masz jeszcze żadnych biletów.</p>";
                        }
                        ?>
                    </div>
                    <div class="action-buttons">
                        <a href="festiwale.php" class="btn btn-primary">Kup Bilet</a>
                    </div>
                </div>

                <!-- Moje Rezerwacje -->
                <div class="account-card">
                    <h3>Moje Rezerwacje</h3>
                    <div class="reservation-list">
                        <?php
                        if ($reservations_result->num_rows > 0) {
                            while ($reservation = $reservations_result->fetch_assoc()) {
                                echo "<div class='reservation-item'>";
                                echo "<div class='reservation-info'>";
                                echo "<div class='reservation-title'>" . htmlspecialchars($reservation['nocleg_nazwa']) . "</div>";
                                echo "<div class='reservation-date'>";
                                echo date('d.m.Y', strtotime($reservation['data_przyjazdu'])) . " - ";
                                echo date('d.m.Y', strtotime($reservation['data_wyjazdu']));
                                echo "</div>";
                                echo "</div>";
                                echo "<span class='status-badge'>" . htmlspecialchars($reservation['status']) . "</span>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Nie masz jeszcze żadnych rezerwacji.</p>";
                        }
                        ?>
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn btn-primary">Nowa Rezerwacja</a>
                    </div>
                </div>

                <!-- Ulubione -->
                <div class="account-card">
                    <h3>Ulubione Wydarzenia</h3>
                    <div class="action-buttons">
                        <a href="festiwale.php" class="btn btn-primary">Przeglądaj Wydarzenia</a>
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