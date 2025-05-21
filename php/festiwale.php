<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Połączenie z bazą danych
$host = 'localhost';
$dbname = 'projekt_godzwon_latawiec';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Błąd połączenia z bazą danych: " . $e->getMessage();
    exit();
}

// Pobranie listy wydarzeń
$stmt = $pdo->query("SELECT w.*, k.nazwa as kategoria, l.nazwa as lokalizacja 
                     FROM wydarzenia w 
                     JOIN kategoria_wydarzenia k ON w.kategoria_id = k.kategoria_id 
                     JOIN lokalizacja l ON w.lokalizacja_id = l.lokalizacja_id 
                     ORDER BY w.rozpoczecie");
$wydarzenia = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Festiwale - System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .artysci {
            padding: 40px 20px;
            background: #f8f9fa;
        }

        .artysci h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .artysta-carousel-wrapper {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .artysta-carousel {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 20px;
            padding: 20px 0;
            scrollbar-width: none;
        }

        .artysta-carousel::-webkit-scrollbar {
            display: none;
        }

        .artysta-card {
            flex: 0 0 300px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .artysta-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
        }

        .artysta-card h3 {
            margin: 10px 0;
            color: #333;
        }

        .artysta-card p {
            color: #666;
            margin-bottom: 15px;
        }

        .artysta-card ul {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .artysta-card li {
            padding: 5px 0;
            color: #555;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 2;
        }

        .prev-btn {
            left: 0;
        }

        .next-btn {
            right: 0;
        }

        .festiwal-list {
            padding: 40px 20px;
        }

        .festiwale-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .festival-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .festival-card:hover {
            transform: translateY(-5px);
        }

        .festival-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .festival-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .festival-content {
            padding: 20px;
        }

        .festival-content h2 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 1.5em;
        }

        .kategoria {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .opis {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .festival-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #555;
        }

        .lokalizacja, .data {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-kup {
            display: block;
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn-kup:hover {
            background: #218838;
        }

        .login-required {
            text-align: center;
            color: #666;
        }

        .login-required a {
            color: #007bff;
            text-decoration: none;
        }

        .login-required a:hover {
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
  <section class="artysci">
    <h2>Występujący Artyści</h2>
    <div class="artysta-carousel-wrapper">
        <button class="carousel-btn prev-btn">&#10094;</button>
        <div class="artysta-carousel" id="carousel">
            <div class="artysta-card">
                <img src="../zdjecia/artysta1.png" alt="Artysta 1">
                <h3>Jan Kowalski</h3>
                <p>Festiwal Muzyki Rockowej</p>
                <ul>
                    <li>"Niepokonani"</li>
                    <li>"W rytmie serca"</li>
                    <li>"Ostatni akord"</li>
                </ul>
            </div>
            <div class="artysta-card">
                <img src="../zdjecia/artysta2.png" alt="Artystka 2">
                <h3>Anna Nowak</h3>
                <p>Festiwal Kultury i Sztuki</p>
                <ul>
                    <li>"Kolory miasta"</li>
                    <li>"Taniec duszy"</li>
                    <li>"Między światłami"</li>
                </ul>
            </div>
            <div class="artysta-card">
                <img src="../zdjecia/artysta3.png" alt="Artysta 3">
                <h3>Michał Zieliński</h3>
                <p>Festiwal Komedii</p>
                <ul>
                    <li>"Stand-up: Życie po 30."</li>
                    <li>"Rodzina vs. Rzeczywistość"</li>
                </ul>
            </div>
            <div class="artysta-card">
                <img src="../zdjecia/artysta5.png" alt="Artysta 4">
                <h3>Katarzyna Wiśniewska</h3>
                <p>Festiwal Jazzowy</p>
                <ul>
                    <li>"Nocne dźwięki"</li>
                    <li>"Improwizacje"</li>
                    <li>"Soulowe brzmienia"</li>
                </ul>
            </div>
            <div class="artysta-card">
                <img src="../zdjecia/artysta4.png" alt="Artysta 5">
                <h3>Piotr Nowakowski</h3>
                <p>Festiwal Teatralny</p>
                <ul>
                    <li>"Hamlet"</li>
                    <li>"Wesele"</li>
                    <li>"Dziady"</li>
                </ul>
            </div>
        </div>
        <button class="carousel-btn next-btn">&#10095;</button>
        <div class="carousel-dots" id="carouselDots"></div>
    </div>
</section>


    <!-- Sekcja festiwali -->
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
                        <?php if (isset($_SESSION['uzytkownicy_id'])): ?>
                            <form action="kup_bilet.php" method="POST">
                                <input type="hidden" name="wydarzenia_id" value="<?php echo $wydarzenie['wydarzenia_id']; ?>">
                                <button type="submit" class="btn-kup">Kup bilet</button>
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
    <script src="../JavaScript/festiwaleScript.js"></script>
</body>
</html>