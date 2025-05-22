<?php
session_start();
require_once 'config.php';

// Sprawdzenie czy użytkownik jest zalogowany i jest pracownikiem
if (!isset($_SESSION['id_uzytkownika'])) {
    header("Location: logowanie.php");
    exit();
}

// Pobieranie danych pracownika
$sql = "SELECT u.imie, u.nazwisko, p.stanowisko, p.data_zatrudnienia, p.zarobki 
        FROM uzytkownicy u 
        JOIN pracownicy p ON u.uzytkownicy_id = p.uzytkownicy_id 
        WHERE u.uzytkownicy_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_uzytkownika']);
$stmt->execute();
$result = $stmt->get_result();
$pracownik = $result->fetch_assoc();

// Definiowanie obowiązków dla różnych stanowisk
$obowiazki = [
    'kierownik' => [
        'Zarządzanie zespołem pracowników',
        'Planowanie harmonogramu pracy',
        'Kontrola jakości usług',
        'Rozwiązywanie problemów i konfliktów',
        'Raportowanie do właściciela'
    ],
    'pracownik obsługi' => [
        'Obsługa klientów',
        'Sprzątanie terenu festiwalu',
        'Pomoc w organizacji wydarzeń',
        'Kontrola biletów',
        'Utrzymanie porządku'
    ],
    'technik' => [
        'Montaż i demontaż sceny',
        'Obsługa sprzętu nagłośnieniowego',
        'Konserwacja urządzeń',
        'Rozwiązywanie problemów technicznych',
        'Współpraca z artystami'
    ],
    'kasjer' => [
        'Obsługa kasy biletowej',
        'Wydawanie biletów',
        'Rozliczanie gotówki',
        'Obsługa terminala płatniczego',
        'Raportowanie sprzedaży'
    ]
];

// Domyślne obowiązki jeśli stanowisko nie jest zdefiniowane
$obowiazki_pracownika = $obowiazki[$pracownik['stanowisko']] ?? [
    'Wykonywanie zadań przydzielonych przez przełożonego',
    'Przestrzeganie regulaminu pracy',
    'Dbanie o bezpieczeństwo własne i innych',
    'Współpraca z zespołem'
];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Pracownika - Festiwal Godz W Latawiec</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard {
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            background: #5a60e3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
        }
        
        .profile-info h2 {
            margin: 0 0 5px 0;
            color: #333;
        }
        
        .profile-info p {
            margin: 0;
            color: #666;
        }
        
        .salary-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
        
        .salary-info p {
            margin: 0;
            font-size: 18px;
            color: #28a745;
        }
        
        .duties-section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .duties-section h3 {
            margin: 0 0 20px 0;
            color: #333;
        }
        
        .duties-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .duties-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .duties-list li:last-child {
            border-bottom: none;
        }
        
        .duties-list li i {
            color: #5a60e3;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'header.php'; ?>
        
        <main class="dashboard">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-info">
                        <h2><?php echo htmlspecialchars($pracownik['imie'] . ' ' . $pracownik['nazwisko']); ?></h2>
                        <p>Stanowisko: <?php echo htmlspecialchars($pracownik['stanowisko']); ?></p>
                        <p>Data zatrudnienia: <?php echo date('d.m.Y', strtotime($pracownik['data_zatrudnienia'])); ?></p>
                    </div>
                </div>
                <div class="salary-info">
                    <p>Zarobki miesięczne: <?php echo number_format($pracownik['zarobki'], 2) . ' zł'; ?></p>
                </div>
            </div>
            
            <div class="duties-section">
                <h3>Twoje obowiązki</h3>
                <ul class="duties-list">
                    <?php foreach($obowiazki_pracownika as $obowiazek): ?>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($obowiazek); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </main>
        
        <?php include 'footer.php'; ?>
    </div>
</body>
</html> 