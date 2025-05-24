<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/StyleDoOnas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Strona Główna</a></li>
                    <li><a href="festiwale.php">Festiwale</a></li>
                    <li><a href="O-nas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                       echo '<li class="welcome-message">Witaj, ' . 
     htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['user_firstname'] ?? 'Użytkowniku') . 
     '!</li>';
                        echo '<li><a href="wyloguj.php">Wyloguj</a></li>';
                    } else {
                        echo '<li><a href="logowanie.php">Logowanie</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <div class="hero">
            <h1>O nas</h1>
            <p>Jesteśmy zespołem, który kocha festiwale – od dźwięku po emocje. Naszą misją jest łączenie ludzi przez kulturę.</p>
        </div>

        <div class="section">
            <h2>Nasza misja</h2>
            <p>Tworzymy platformę, która ułatwia uczestnictwo w wydarzeniach kulturalnych, wspiera organizatorów i buduje społeczność pasjonatów muzyki, filmu i sztuki. Wierzymy, że festiwale to coś więcej niż wydarzenia – to doświadczenia, które zostają z nami na zawsze.</p>
        </div>

        <div class="section">
            <h2>Poznaj nasz zespół</h2>
            <div class="team">
                <div class="member">
                    <img src="https://i.pravatar.cc/100?img=1" alt="Anna">
                    <h4>Anna</h4>
                    <span>Koordynatorka wydarzeń</span>
                </div>
                <div class="member">
                    <img src="https://i.pravatar.cc/100?img=3" alt="Michał">
                    <h4>Michał</h4>
                    <span>Programista</span>
                </div>
                <div class="member">
                    <img src="https://i.pravatar.cc/100?img=5" alt="Julia">
                    <h4>Julia</h4>
                    <span>PR & Social Media</span>
                </div>
                <div class="member">
                    <img src="https://i.pravatar.cc/100?img=7" alt="Tomek">
                    <h4>Tomek</h4>
                    <span>Projektant UX/UI</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Osiągnięcia</h2>
            <div class="achievements">
                <div class="achievement">
                    <h3>50+</h3>
                    <p>zorganizowanych festiwali</p>
                </div>
                <div class="achievement">
                    <h3>10k+</h3>
                    <p>aktywnych uczestników</p>
                </div>
                <div class="achievement">
                    <h3>4.9/5</h3>
                    <p>średnia ocena użytkowników</p>
                </div>
            </div>

            <div class="cta">
                <a href="rejestracje.php">Dołącz do nas</a>
            </div>
        </div>

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
