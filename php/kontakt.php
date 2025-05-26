<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
    <link rel="stylesheet" href="../styleCSS/StyleDoKontakt.css">
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
                        require_once 'config.php';
                        $stmt = $pdo->prepare('SELECT imie, rola FROM uzytkownicy WHERE uzytkownicy_id = ?');
                        $stmt->execute([$_SESSION['user_id']]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        $imie = $user ? $user['imie'] : 'Użytkowniku';
                        echo '<li class="welcome-message">Witaj, ' . htmlspecialchars($imie) . '!</li>';
                        
                        if ($user['rola'] === 'wlasciciel') {
                            echo '<li><a href="panel_wlasciciela.php">Panel admina</a></li>';
                        } elseif (in_array($user['rola'], ['sprzataczka', 'informatyk', 'organizator', 'technik sceniczny', 'specjalista ds. promocji', 'koordynator wolontariuszy'])) {
                            echo '<li><a href="panel_pracownika.php">Panel pracownika</a></li>';
                        } else {
                            echo '<li><a href="panel_uzytkownika.php">Mój profil</a></li>';
                        }
                        echo '<li><a href="wyloguj.php">Wyloguj</a></li>';
                    } else {
                        echo '<li><a href="logowanie.php">Logowanie</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <main>
            <div class="hero">
                <h1>Kontakt</h1>
                <p>Masz pytania lub propozycje współpracy? Skontaktuj się z nami - chętnie odpowiemy!</p>
            </div>
            
            <div class="section">
                <h2>Dane kontaktowe</h2>
                <div class="contact-details">
                    <p><strong>Adres:</strong> ul. Festiwalowa 10, 00-001 Warszawa</p>
                    <p><strong>Email:</strong> kontakt@festiwalowy.pl</p>
                    <p><strong>Telefon:</strong> +48 123 456 789</p>
                </div>
            </div>
            
            <div class="section">
                <h2>Formularz kontaktowy</h2>
                <form action="wyslij_wiadomosc.php" method="post">
                    <div class="form-group">
                        <label for="name">Imię i Nazwisko:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Wiadomość:</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit">Wyślij</button>
                </form>
            </div>
            
            <div class="section">
                <h2>FAQ - Najczęściej zadawane pytania</h2>
                <div class="faq">
                    <details>
                        <summary>
                            <span>Jak kupić bilet na festiwal?</span>
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </summary>
                        <p>Wystarczy przejść do zakładki "Festiwale" i kliknąć przycisk "Kup bilet" przy wybranym wydarzeniu.</p>
                    </details>
            
                    <details>
                        <summary>
                            <span>Czy uczestnikom podobają się festiwale i czy są z nich zadowoleni</span>
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </summary>
                        <p>Tak, uczestnikom podobają się festiwale i są z nich zadowoleni, wskazują na to oceny uczestników, ktore są na poziomie az 4.9/5!.</p>
                    </details>
            
                    <details>
                        <summary>
                            <span>Jak mogę skontaktować się z organizatorami?</span>
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </summary>
                        <p>Możesz użyć formularza powyżej lub napisać bezpośrednio na adres: kontakt@festiwalowy.pl</p>
                    </details>
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