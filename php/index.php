
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
                    <li><a href="logowanie.php">Logowanie</a></li>
              
                </ul>
            </nav>
        </header>
        <main>
            
   
            <section class="hero">
                <h1>Witamy w Systemie Festiwalowym</h1>
                <p>Dołącz do najlepszych wydarzeń kulturalnych w kraju. Rejestruj się, przeglądaj programy i twórz
                    niezapomniane wspomnienia!</p>
                <a href="rejestracje.php" class="btn">Zarejestruj się teraz</a>
            </section>
            <section>
                <h2>Nadchodzące festiwale</h2>
                <div class="festival-grid">
                    <div class="festival-card">
                        <div class="festival-img">
                            <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                alt="Festiwal Muzyki Alternatywnej">
                        </div>
                        <div class="festival-info">
                            <h3>Festiwal Muzyki Alternatywnej</h3>
                            <div class="festival-date">
                                <i class="far fa-calendar-alt"></i> 15-18.07.2025
                            </div>
                            <div class="festival-location">
                                <i class="fas fa-map-marker-alt"></i> Warszawa
                            </div>
                            <p>Największe gwiazdy muzyki alternatywnej na jednej scenie. 3 dni niezapomnianych wrażeń!
                            </p>
                        </div>
                    </div>

                    <div class="festival-card">
                        <div class="festival-img">
                            <img src="https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                alt="Festiwal Kina Niezależnego">
                        </div>
                        <div class="festival-info">
                            <h3>Festiwal Kina Niezależnego</h3>
                            <div class="festival-date">
                                <i class="far fa-calendar-alt"></i> 03-10.08.2025
                            </div>
                            <div class="festival-location">
                                <i class="fas fa-map-marker-alt"></i> Kraków
                            </div>
                            <p>Pokazy filmowe, spotkania z twórcami i warsztaty filmowe. Odkryj kino na nowo!</p>
                        </div>
                    </div>

                    <div class="festival-card">
                        <div class="festival-img">
                            <img src="https://images.unsplash.com/photo-1547891654-e66ed7ebb968?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                alt="Festiwal Sztuki Nowoczesnej">
                        </div>
                        <div class="festival-info">
                            <h3>Festiwal Sztuki Nowoczesnej</h3>
                            <div class="festival-date">
                                <i class="far fa-calendar-alt"></i> 22-28.09.2025
                            </div>
                            <div class="festival-location">
                                <i class="fas fa-map-marker-alt"></i> Gdańsk
                            </div>
                            <p>Instalacje, performance i wystawy najciekawszych współczesnych artystów.</p>
                        </div>
                    </div>
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
                    <div class="accommodation-card">
                        <div class="accommodation-img">
                            <img src="../zdjecia/hotelPremium.jpg" alt="Hotel Premium">
                            <div class="accommodation-rating">
                                <i class="fas fa-star"></i> 4.8
                            </div>
                        </div>
                        <div class="accommodation-info">
                            <h3>Hotel Premium</h3>
                            <div class="accommodation-location">
                                <i class="fas fa-map-marker-alt"></i> 1.2 km od festiwalu
                            </div>
                            <div class="accommodation-features">
                                <span><i class="fas fa-wifi"></i> Darmowe WiFi</span>
                                <span><i class="fas fa-parking"></i> Parking</span>
                                <span><i class="fas fa-utensils"></i> Restauracja</span>
                            </div>
                            <div class="accommodation-price">
                                Od 250 zł/noc
                            </div>
                            <a href="#" class="btn btn-small">Sprawdź dostępność</a>
                        </div>
                    </div>

                    <div class="accommodation-card">
                        <div class="accommodation-img">
                            <img src="../zdjecia/festiwalHostel.png" alt="Hostel Festiwalowy">
                            <div class="accommodation-rating">
                                <i class="fas fa-star"></i> 4.5
                            </div>
                        </div>
                        <div class="accommodation-info">
                            <h3>Hostel Festiwalowy</h3>
                            <div class="accommodation-location">
                                <i class="fas fa-map-marker-alt"></i> 800 m od festiwalu
                            </div>
                            <div class="accommodation-features">
                                <span><i class="fas fa-wifi"></i> WiFi</span>
                                <span><i class="fas fa-users"></i> Wspólna kuchnia</span>
                                <span><i class="fas fa-bicycle"></i> Wypożyczalnia rowerów</span>
                            </div>
                            <div class="accommodation-price">
                                Od 80 zł/noc
                            </div>
                            <a href="#" class="btn btn-small">Sprawdź dostępność</a>
                        </div>
                    </div>

                    <div class="accommodation-card">
                        <div class="accommodation-img">
                            <img src="../zdjecia/apartamentNadBrzegiem.jpg" alt="Apartamenty Nad Brzegiem">
                            <div class="accommodation-rating">
                                <i class="fas fa-star"></i> 4.9
                            </div>
                        </div>
                        <div class="accommodation-info">
                            <h3>Apartamenty Nad Brzegiem</h3>
                            <div class="accommodation-location">
                                <i class="fas fa-map-marker-alt"></i> 2 km od festiwalu
                            </div>
                            <div class="accommodation-features">
                                <span><i class="fas fa-swimming-pool"></i> Basen</span>
                                <span><i class="fas fa-umbrella-beach"></i> Plaża</span>
                                <span><i class="fas fa-warehouse"></i> Apartamenty</span>
                            </div>
                            <div class="accommodation-price">
                                Od 350 zł/noc
                            </div>
                            <a href="#" class="btn btn-small">Sprawdź dostępność</a>
                        </div>
                    </div>
                    
                    <div class="accommodation-card" style="display: none;">
                        <div class="accommodation-img">
                            <img src="../zdjecia/hotelMiejski.png" alt="Hotel Miejski">
                            <div class="accommodation-rating"><i class="fas fa-star"></i> 4.6</div>
                        </div>
                        <div class="accommodation-info">
                            <h3>Hotel Miejski</h3>
                            <div class="accommodation-location"><i class="fas fa-map-marker-alt"></i> 1.5 km od
                                festiwalu</div>
                            <div class="accommodation-features">
                                <span><i class="fas fa-wifi"></i> WiFi</span>
                                <span><i class="fas fa-concierge-bell"></i> Obsługa 24/7</span>
                            </div>
                            <div class="accommodation-price">Od 200 zł/noc</div>
                            <a href="#" class="btn btn-small">Sprawdź dostępność</a>
                        </div>
                    </div>

                    <div class="accommodation-card" style="display: none;">
                        <div class="accommodation-img">
                            <img src="../zdjecia/pensjonatZacisze.png" alt="Pensjonat Zacisze">
                            <div class="accommodation-rating"><i class="fas fa-star"></i> 4.4</div>
                        </div>
                        <div class="accommodation-info">
                            <h3>Pensjonat Zacisze</h3>
                            <div class="accommodation-location"><i class="fas fa-map-marker-alt"></i> 2.3 km od
                                festiwalu</div>
                            <div class="accommodation-features">
                                <span><i class="fas fa-coffee"></i> Śniadanie w cenie</span>
                                <span><i class="fas fa-tree"></i> Ogród</span>
                            </div>
                            <div class="accommodation-price">Od 150 zł/noc</div>
                            <a href="#" class="btn btn-small">Sprawdź dostępność</a>
                        </div>
                    </div>

                    <div class="accommodation-card" style="display: none;">
                        <div class="accommodation-img">
                            <img src="../zdjecia/kempingFestiwalowy.png" alt="Kemping Festiwalowy">
                            <div class="accommodation-rating"><i class="fas fa-star"></i> 4.1</div>
                        </div>
                        <div class="accommodation-info">
                            <h3>Kemping Festiwalowy</h3>
                            <div class="accommodation-location"><i class="fas fa-map-marker-alt"></i> 500 m od festiwalu
                            </div>
                            <div class="accommodation-features">
                                <span><i class="fas fa-fire"></i> Miejsce na ognisko</span>
                                <span><i class="fas fa-shower"></i> Prysznice</span>
                            </div>
                            <div class="accommodation-price">Od 60 zł/noc</div>
                            <a href="#" class="btn btn-small">Sprawdź dostępność</a>
                        </div>
                    </div>

                </div>

                <div class="accommodation-more">
                    <a href="#" class="btn btn-outline">Zobacz więcej noclegów</a>
                </div>

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