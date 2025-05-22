<?php
session_start();
require_once 'config.php';

// Sprawdzenie czy użytkownik jest zalogowany i jest właścicielem
if (!isset($_SESSION['id_uzytkownika']) || $_SESSION['stanowisko'] !== 'właściciel') {
    header("Location: logowanie.php");
    exit();
}

// Pobieranie danych pracowników
$sql = "SELECT u.imie, u.nazwisko, p.stanowisko, p.data_zatrudnienia, p.zarobki 
        FROM uzytkownicy u 
        JOIN pracownicy p ON u.uzytkownicy_id = p.uzytkownicy_id 
        ORDER BY p.zarobki DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Właściciela - Festiwal Godz W Latawiec</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .stat-card p {
            font-size: 24px;
            margin: 0;
            color: #5a60e3;
        }
        
        .employees-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .employees-table th,
        .employees-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .employees-table th {
            background-color: #5a60e3;
            color: white;
        }
        
        .employees-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .salary {
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'header.php'; ?>
        
        <main class="dashboard">
            <h1>Panel Właściciela</h1>
            
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Łączna liczba pracowników</h3>
                    <p><?php echo $result->num_rows; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Łączne miesięczne zarobki</h3>
                    <p><?php 
                        $total_salary = 0;
                        while($row = $result->fetch_assoc()) {
                            $total_salary += $row['zarobki'];
                        }
                        echo number_format($total_salary, 2) . ' zł';
                    ?></p>
                </div>
            </div>
            
            <h2>Lista pracowników</h2>
            <table class="employees-table">
                <thead>
                    <tr>
                        <th>Imię i Nazwisko</th>
                        <th>Stanowisko</th>
                        <th>Data zatrudnienia</th>
                        <th>Zarobki miesięczne</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result->data_seek(0); // Reset pointer to beginning
                    while($row = $result->fetch_assoc()): 
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['imie'] . ' ' . $row['nazwisko']); ?></td>
                        <td><?php echo htmlspecialchars($row['stanowisko']); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($row['data_zatrudnienia'])); ?></td>
                        <td class="salary"><?php echo number_format($row['zarobki'], 2) . ' zł'; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
        
        <?php include 'footer.php'; ?>
    </div>
</body>
</html> 