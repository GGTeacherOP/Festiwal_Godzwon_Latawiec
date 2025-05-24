<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Festiwalowy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styleCSS/Style.css">
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
    $welcomeName = $_SESSION['user_name'] ?? $_SESSION['imie'] ?? 'Użytkowniku';
    echo '<li class="welcome-message">Witaj, ' . htmlspecialchars($welcomeName) . '!</li>';
    echo '<li><a href="user_dashboard.php">Mój profil</a></li>';
    echo '<li><a href="wyloguj.php">Wyloguj</a></li>';
} else {
    echo '<li><a href="logowanie.php">Logowanie</a></li>';
    echo '<li><a href="rejestracja.php">Rejestracja</a></li>';
}
?>
                </ul>
            </nav>
        </header>
    
        <main>
            <?php if (isset($_SESSION['sukces'])): ?>
                <div class="success-message">
                    <?php 
                    echo $_SESSION['sukces'];
                    unset($_SESSION['sukces']);
                    ?>
                </div>
            <?php endif; ?>
            <?php
            if (isset($_SESSION['login_success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['login_success'] . '</div>';
                unset($_SESSION['login_success']);
            }
            if (isset($_SESSION['logout_message'])) {
                echo '<div class="alert alert-info">' . $_SESSION['logout_message'] . '</div>';
                unset($_SESSION['logout_message']);
            }
            ?>
            <section class="hero">
                <h1>Witamy w Systemie Festiwalowym</h1>
                <p>Dołącz do najlepszych wydarzeń kulturalnych w kraju. Rejestruj się, przeglądaj programy i twórz
                    niezapomniane wspomnienia!</p>
                <a href="rejestracje.php" class="btn">Zarejestruj się teraz</a>
            </section>
            <section>
                <h2>Nadchodzące festiwale</h2>
                <div class="festival-grid">
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'projekt_godzwon_latawiec');
                    
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    // Pobranie 3 najbliższych wydarzeń
                    $currentDate = date('Y-m-d H:i:s');
                    $sql = "SELECT w.*, k.nazwa AS kategoria, l.nazwa AS miejsce 
                            FROM wydarzenia w
                            JOIN kategoria_wydarzenia k ON w.kategoria_id = k.kategoria_id
                            JOIN lokalizacja l ON w.lokalizacja_id = l.lokalizacja_id
                            WHERE w.rozpoczecie > '$currentDate'
                            ORDER BY w.rozpoczecie ASC
                            LIMIT 3";
                    
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $startDate = new DateTime($row['rozpoczecie']);
                            $endDate = new DateTime($row['zakonczenie']);
                            $image_url = "https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80";
                            if ($row['kategoria_id'] == 10) { // Kino Niezależne
                                $image_url = "https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80";
                            } elseif ($row['kategoria_id'] == 11) { // Sztuka Nowoczesna
                                $image_url = "https://images.unsplash.com/photo-1547891654-e66ed7ebb968?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80";
                            }
                            
                            echo '<div class="festival-card">';
                            echo '  <div class="festival-img">';
                            echo '    <img src="'.$image_url.'" alt="'.$row['tytul'].'">';
                            echo '  </div>';
                            echo '  <div class="festival-info">';
                            echo '    <h3>'.$row['tytul'].'</h3>';
                            echo '    <div class="festival-date">';
                            echo '      <i class="far fa-calendar-alt"></i> '.$startDate->format('d.m.Y').' - '.$endDate->format('d.m.Y');
                            echo '    </div>';
                            echo '    <div class="festival-location">';
                            echo '      <i class="fas fa-map-marker-alt"></i> '.$row['miejsce'];
                            echo '    </div>';
                            echo '    <p>'.$row['opis'].'</p>';
                            echo '  </div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="festival-card">';
                        echo '  <div class="festival-info">';
                        echo '    <h3>Brak nadchodzących wydarzeń</h3>';
                        echo '    <p>Sprawdź później lub zobacz inne dostępne festiwale.</p>';
                        echo '  </div>';
                        echo '</div>';
                    }
                    
                    $conn->close();
                    ?>
                </div>
            </section>
            <section class="gallery-section">
                <h2>Galeria z poprzednich festiwali</h2>
                <p class="gallery-description">Zobacz najlepsze momenty z naszych wydarzeń i poczuj atmosferę festiwali!
                </p>

                <div class="gallery-container">
                    <div class="gallery-item">
                        <img src="../zdjecia/galeria1.jpg" alt="Koncert na festiwalu muzycznym">
                        <div class="gallery-caption">Koncert główny - Festiwal Muzyki 2024</div>
                    </div>
                    <div class="gallery-item">
                        <img src="../zdjecia/galeria2.jpg" alt="Widownia podczas koncertu">
                        <div class="gallery-caption">Entuzjastyczna publiczność</div>
                    </div>
                    <div class="gallery-item">
                        <img src="../zdjecia/galeria3.jpg" alt="Artysta podczas występu">
                        <div class="gallery-caption">Występ artysty na głównej scenie</div>
                    </div>
                    <div class="gallery-item">
                        <img src="../zdjecia/galeria4.jpg" alt="Warsztaty festiwalowe">
                        <div class="gallery-caption">Warsztaty artystyczne dla uczestników</div>
                    </div>
                    <div class="gallery-item">
                        <img src="../zdjecia/galeria5.jpg" alt="Scena wieczorna">
                        <div class="gallery-caption">Wieczorny klimat na festiwalu</div>
                    </div>
                    <div class="gallery-item">
                        <img src="../zdjecia/galeria6.jpg" alt="Food trucki festiwalowe">
                        <div class="gallery-caption">Strefa food trucków</div>
                    </div>
                </div>

                <div class="gallery-controls">
                    <button class="gallery-btn" onclick="pokazPoprzednieGaleria()"><i class="fas fa-chevron-left"></i>
                        Poprzednie</button>
                    <button class="gallery-btn" onclick="pokanNastepneGaleria()">Następne <i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </section>

<section class="accommodation-section">
    <h2>Polecane noclegi w okolicy</h2>
    <p class="accommodation-description">Zarezerwuj wygodny nocleg w pobliżu festiwalu i ciesz się pełnym komfortem!</p>

    <div class="accommodation-grid">
            <?php
                $conn = new mysqli('localhost', 'root', '', 'projekt_godzwon_latawiec');
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                // Pobranie noclegów z bazy danych - upewnij się, że masz 6 rekordów w bazie
                $sql = "SELECT n.*, l.nazwa AS lokalizacja_nazwa 
                        FROM noclegi n
                        JOIN lokalizacja l ON n.lokalizacja_id = l.lokalizacja_id
                        WHERE n.dostepnosc = 1
                        ORDER BY n.cena_za_noc ASC
                        LIMIT 7";
                
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $zdjecia_noclegow = [
                        "../zdjecia/kempingFestiwalowy.png",
                        "../zdjecia/HostelFestiwal.png",
                        "../zdjecia/pensjonatZacisze.png",
                        "../zdjecia/HotelMiejski.png",
                        "../zdjecia/HotelPremium.jpg",
                        "../zdjecia/apartamentNadBrzegiem.jpg"
                    ];
                    
                    $counter = 0;
                    while($row = $result->fetch_assoc()) {
                        $image_path = $zdjecia_noclegow[$counter % count($zdjecia_noclegow)];
                        
                        $style = ($counter >= 3) ? 'style="display: none;"' : '';
                        
                        echo '<div class="accommodation-card" '.$style.'>';
                        echo '  <div class="accommodation-img">';
                        echo '    <img src="'.$image_path.'" alt="'.$row['nazwa'].'">';
                        echo '    <div class="accommodation-rating">';
                        echo '      <i class="fas fa-star"></i> 4.'.rand(5,9);
                        echo '    </div>';
                        echo '  </div>';
                        echo '  <div class="accommodation-info">';
                        echo '    <h3>'.$row['nazwa'].'</h3>';
                        echo '    <div class="accommodation-location">';
                        echo '      <i class="fas fa-map-marker-alt"></i> '.$row['lokalizacja_nazwa'];
                        echo '    </div>';
                        echo '    <div class="accommodation-features">';
                        
                        // Losowe cechy dla każdego noclegu
                        $features = [
                            ['icon' => 'fa-wifi', 'text' => 'Darmowe WiFi'],
                            ['icon' => 'fa-parking', 'text' => 'Parking'],
                            ['icon' => 'fa-utensils', 'text' => 'Restauracja'],
                            ['icon' => 'fa-swimming-pool', 'text' => 'Basen'],
                            ['icon' => 'fa-coffee', 'text' => 'Śniadanie'],
                            ['icon' => 'fa-concierge-bell', 'text' => 'Obsługa 24/7']
                        ];
                        shuffle($features);
                        
                        for ($i = 0; $i < 3; $i++) {
                            echo '<span><i class="fas '.$features[$i]['icon'].'"></i> '.$features[$i]['text'].'</span>';
                        }
                        
                        echo '    </div>';
                        echo '    <div class="accommodation-price">';
                        echo '      Od '.number_format($row['cena_za_noc'], 2, ',', ' ').' zł/noc';
                        echo '    </div>';
                        echo '    <a href="#" class="btn btn-small">Sprawdź dostępność</a>';
                        echo '  </div>';
                        echo '</div>';
                        
                        $counter++;
                    }
                    
                    // Debug - wyświetl liczbę znalezionych noclegów
                    echo '<!-- DEBUG: Znaleziono '.$counter.' noclegów -->';
                } else {
                    echo '<div class="accommodation-card">';
                    echo '  <div class="accommodation-info">';
                    echo '    <h3>Brak dostępnych noclegów</h3>';
                    echo '    <p>Sprawdź później dostępne opcje zakwaterowania.</p>';
                    echo '  </div>';
                    echo '</div>';
                }
                
                $conn->close();
                ?>
            </div>

            <div class="accommodation-more">
                <a href="#" class="btn btn-outline">Zobacz więcej noclegów</a>
            </div>
        </section>

            <section class="transport-section">
                <h2>Wspólny transport na festiwale</h2>
                <p class="transport-description">Dołącz do organizowanych przejazdów lub zorganizuj własny i podziel się kosztami z innymi uczestnikami!</p>

                <div class="transport-grid">
                    <div class="transport-card">
                        <div class="transport-icon">
                            <i class="fas fa-bus fa-3x"></i>
                        </div>
                        <div class="transport-info">
                            <h3>Autokar z Warszawy</h3>
                            <div class="transport-details">
                                <div><i class="fas fa-calendar-alt"></i> 14.07.2025, 18:00</div>
                                <div><i class="fas fa-map-marker-alt"></i> Zbiórka: Dworzec Zachodni</div>
                                <div><i class="fas fa-users"></i> Wolnych miejsc: 12/50</div>
                                <div><i class="fas fa-money-bill-wave"></i> Cena: 60 zł/os</div>
                            </div>
                            <a href="#" class="btn btn-small">Dołącz do przejazdu</a>
                        </div>
                    </div>

                    <div class="transport-card">
                        <div class="transport-icon">
                            <i class="fas fa-car fa-3x"></i>
                        </div>
                        <div class="transport-info">
                            <h3>Samochód z Krakowa</h3>
                            <div class="transport-details">
                                <div><i class="fas fa-calendar-alt"></i> 02.08.2025, 16:00</div>
                                <div><i class="fas fa-map-marker-alt"></i> Zbiórka: Galeria Krakowska</div>
                                <div><i class="fas fa-users"></i> Wolnych miejsc: 2/4</div>
                                <div><i class="fas fa-money-bill-wave"></i> Cena: 40 zł/os</div>
                            </div>
                            <a href="#" class="btn btn-small">Dołącz do przejazdu</a>
                        </div>
                    </div>

                    <div class="transport-card">
                        <div class="transport-icon">
                            <i class="fas fa-car fa-3x"></i>
                        </div>
                        <div class="transport-info">
                            <h3>Samochód z Mielca</h3>
                            <div class="transport-details">
                                <div><i class="fas fa-calendar-alt"></i> 25.07.2025, 13:00</div>
                                <div><i class="fas fa-map-marker-alt"></i> Zbiórka: Dworzec Autobusowy Mielec</div>
                                <div><i class="fas fa-users"></i> Wolnych miejsc: 5/7</div>
                                <div><i class="fas fa-money-bill-wave"></i> Cena: 50 zł/os</div>
                            </div>
                            <a href="#" class="btn btn-small">Dołącz do przejazdu</a>
                        </div>
                    </div>
                    
                    <div class="transport-card">
                        <div class="transport-icon">
                            <i class="fas fa-train fa-3x"></i>
                        </div>
                        <div class="transport-info">
                            <h3>Pociąg z Gdańska</h3>
                            <div class="transport-details">
                                <div><i class="fas fa-calendar-alt"></i> 21.09.2025, 08:30</div>
                                <div><i class="fas fa-map-marker-alt"></i> Zbiórka: Gdańsk Główny</div>
                                <div><i class="fas fa-users"></i> Wolnych miejsc: 8/15</div>
                                <div><i class="fas fa-money-bill-wave"></i> Cena: 45 zł/os</div>
                            </div>
                            <a href="#" class="btn btn-small">Dołącz do przejazdu</a>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <h2>Nasze statystyki</h2>
                <div class="stats">
                    <div class="stat-card">
                        <i class="fas fa-users fa-2x" style="color: #5a60e3;"></i>
                        <div class="stat-number">10,000+</div>
                        <div class="stat-label">Uczestników rocznie</div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-calendar-alt fa-2x" style="color: #5a60e3;"></i>
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Wydarzeń</div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-map-marked-alt fa-2x" style="color: #5a60e3;"></i>
                        <div class="stat-number">12</div>
                        <div class="stat-label">Miast</div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-star fa-2x" style="color: #5a60e3;"></i>
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Zadowolonych uczestników</div>
                    </div>
                </div>
            </section>

            <section>
                <h2>Uczestnicy festiwali</h2>
                <div class="participants">
                    <div class="participant-card">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Anna Kowalska"
                            class="participant-img">
                        <h3 class="participant-name">Anna Kowalska</h3>
                        <div class="participant-role">Fotografka</div>
                        <p class="participant-bio">Uwielbiam dokumentować festiwalowe emocje. Od 5 lat z nami!</p>
                    </div>
                    <div class="participant-card">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Marek Nowak"
                            class="participant-img">
                        <h3 class="participant-name">Marek Nowak</h3>
                        <div class="participant-role">Meloman</div>
                        <p class="participant-bio">Na każdym festiwalu muzycznym od 2018 roku. Moja pasja!</p>
                    </div>
                    <div class="participant-card">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Katarzyna Wiśniewska"
                            class="participant-img">
                        <h3 class="participant-name">Katarzyna Wiśniewska</h3>
                        <div class="participant-role">Wolontariuszka</div>
                        <p class="participant-bio">Pomagam przy organizacji, bo kocham festiwalową atmosferę.</p>
                    </div>
                    <div class="participant-card">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Piotr Lewandowski"
                            class="participant-img">
                        <h3 class="participant-name">Piotr Lewandowski</h3>
                        <div class="participant-role">Bloger</div>
                        <p class="participant-bio">Relacjonuję festiwale dla moich czytelników. Najlepsze wrażenia!</p>
                    </div>
                </div>
            </section>
            <section class="cytaty">
                <div id="quote-container">
                    <p id="quote-text">„Festiwal to przestrzeń spotkań, emocji i pasji — nasza strona łączy ludzi z ich
                        doświadczeniami.”</p>
                </div>
                <div class="quote-buttons">
                    <button onclick="poprzedniCytat()"><i class="fas fa-arrow-left"></i> Poprzedni</button>
                    <button onclick="nastepnyCytat()">Następny <i class="fas fa-arrow-right"></i></button>
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
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i
                            class="fab fa-facebook"></i></a>
                    <a href="https://instagram.com" target="_blank" class="instagram" aria-label="Instagram"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com" target="_blank" class="twitter" aria-label="Twitter"><i
                            class="fab fa-twitter"></i></a>
                    <a href="https://youtube.com" target="_blank" class="youtube" aria-label="YouTube"><i
                            class="fab fa-youtube"></i></a>
                </div>
                <p>&copy; 2025 System Festiwalowy. Wszelkie prawa zastrzeżone.</p>
            </div>
        </footer>
    </div>
    <script src="../JavaScript/indexScript.js"></script>
</body>

</html>