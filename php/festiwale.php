<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/StyleFestiwal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <li>„Niepokonani”</li>
                    <li>„W rytmie serca”</li>
                    <li>„Ostatni akord”</li>
                </ul>
            </div>
            <div class="artysta-card">
                <img src="../zdjecia/artysta2.png" alt="Artystka 2">
                <h3>Anna Nowak</h3>
                <p>Festiwal Kultury i Sztuki</p>
                <ul>
                    <li>„Kolory miasta”</li>
                    <li>„Taniec duszy”</li>
                    <li>„Między światłami”</li>
                </ul>
            </div>
            <div class="artysta-card">
                <img src="../zdjecia/artysta3.png" alt="Artysta 3">
                <h3>Michał Zieliński</h3>
                <p>Festiwal Komedii</p>
                <ul>
                    <li>„Stand-up: Życie po 30.”</li>
                    <li>„Rodzina vs. Rzeczywistość”</li>
                </ul>
            </div>
            <div class="artysta-card">
                <img src="../zdjecia/artysta5.png" alt="Artysta 4">
                <h3>Katarzyna Wiśniewska</h3>
                <p>Festiwal Jazzowy</p>
                <ul>
                    <li>„Nocne dźwięki”</li>
                    <li>„Improwizacje”</li>
                    <li>„Soulowe brzmienia”</li>
                </ul>
            </div>
            <div class="artysta-card">
                <img src="../zdjecia/artysta4.png" alt="Artysta 5">
                <h3>Piotr Nowakowski</h3>
                <p>Festiwal Teatralny</p>
                <ul>
                    <li>„Hamlet”</li>
                    <li>„Wesele”</li>
                    <li>„Dziady”</li>
                </ul>
            </div>
        </div>
        <button class="carousel-btn next-btn">&#10095;</button>
        <div class="carousel-dots" id="carouselDots"></div>
    </div>
</section>


    <!-- Sekcja festiwali -->
    <section class="festiwal-list">
        <div class="festival-grid">
            <div class="festiwal-card">
                <img src="../zdjecia/festiwalMuzykiRockowej.png" alt="Festiwal Muzyki Rockowej">
                <div class="festiwal-info">
                    <h3>Festiwal Muzyki Rockowej</h3>
                    <p class="krotki-opis">Trzy dni pełne energii, muzyki na żywo i niesamowitej atmosfery! Kraków, lipiec 2025.</p>
                    <ul>
                        <li>3 sceny tematyczne (klasyczny rock, alternatywa, metal)</li>
                        <li>Strefa namiotowa i pole kempingowe</li>
                        <li>Afterparty z DJ-ami</li>
                    </ul>
                    <div class="button-container">
                        <button class="kup-bilet">Kup bilet</button>
                        <button class="zobacz-wiecej" onclick="toggleOpis(this)">Zobacz więcej</button>
                    </div>
                </div>
            </div>
            <div class="festiwal-card">
                <img src="../zdjecia/festiwalFilmowy.jpg" alt="Festiwal Filmowy">
                <div class="festiwal-info">
                    <h3>Festiwal Filmowy</h3>
                    <p class="krotki-opis">Oglądaj najlepsze filmy niezależne z całego świata i poznaj ich twórców. Gdańsk, sierpień 2025.</p>
                    <ul>
                        <li>Pokazy filmowe w kinach, na plaży i dziedzińcach</li>
                        <li>Spotkania autorskie z twórcami po seansach</li>
                        <li>Konkurs główny z nagrodą publiczności</li>
                    </ul>
                    <div class="button-container">
                        <button class="kup-bilet">Kup bilet</button>
                        <button class="zobacz-wiecej" onclick="toggleOpis(this)">Zobacz więcej</button>
                    </div>
                </div>
            </div>
            <div class="festiwal-card">
                <img src="../zdjecia/festiwalKulturyiSztuki.jpg" alt="Festiwal Kultury i Sztuki">
                <div class="festiwal-info">
                    <h3>Festiwal Kultury i Sztuki</h3>
                    <p class="krotki-opis">Wystawy, koncerty, warsztaty i wiele więcej - zanurz się w świat kreatywności! Wrocław, wrzesień 2025.</p>
                    <ul>
                        <li>Spektakle uliczne i mapping 3D</li>
                        <li>Wystawy malarstwa i sztuki cyfrowej</li>
                        <li>Koncerty na dziedzińcach i dachach</li>
                    </ul>
                    <div class="button-container">
                        <button class="kup-bilet">Kup bilet</button>
                        <button class="zobacz-wiecej" onclick="toggleOpis(this)">Zobacz więcej</button>
                    </div>
                </div>
            </div>
            <div class="festiwal-card">
                <img src="../zdjecia/festiwalJedzeniaiWIna.jpg" alt="Festiwal Jedzenia i Wina">
                <div class="festiwal-info">
                    <h3>Festiwal Jedzenia i Wina</h3>
                    <p class="krotki-opis">Rozkoszuj się wykwintnymi smakami kuchni świata i regionalnymi winami. Toruń, lipiec 2025.</p>
                    <ul>
                        <li>Kuchnia włoska, francuska, tajska i regionalna</li>
                        <li>Degustacje win i pokazy sommelierów</li>
                        <li>Live cooking z mistrzami kuchni</li>
                    </ul>
                    <div class="button-container">
                        <button class="kup-bilet">Kup bilet</button>
                        <button class="zobacz-wiecej" onclick="toggleOpis(this)">Zobacz więcej</button>
                    </div>
                </div>
            </div>
            <div class="festiwal-card">
                <img src="../zdjecia/festiwalTechnologii.jpg" alt="Festiwal Technologii">
                <div class="festiwal-info">
                    <h3>Festiwal Technologii</h3>
                    <p class="krotki-opis">Nowinki technologiczne, robotyka, AI i panele dyskusyjne z ekspertami. Warszawa, październik 2025.</p>
                    <ul>
                        <li>Prezentacje startupów i nowych produktów</li>
                        <li>Strefa VR/AR z immersją</li>
                        <li>Pokazy walk robotów i AI</li>
                    </ul>
                    <div class="button-container">
                        <button class="kup-bilet">Kup bilet</button>
                        <button class="zobacz-wiecej" onclick="toggleOpis(this)">Zobacz więcej</button>
                    </div>
                </div>
            </div>
            <div class="festiwal-card">
                <img src="../zdjecia/festiwalKomedii.jpg" alt="Festiwal Komedii">
                <div class="festiwal-info">
                    <h3>Festiwal Komedii</h3>
                    <p class="krotki-opis">Wieczory pełne śmiechu z najlepszymi stand-upowcami. Poznań, listopad 2025.</p>
                    <ul>
                        <li>Stand-up z gwiazdami</li>
                        <li>Improwizacje z udziałem publiczności</li>
                        <li>Warsztaty komediowe</li>
                    </ul>
                    <div class="button-container">
                        <button class="kup-bilet">Kup bilet</button>
                        <button class="zobacz-wiecej" onclick="toggleOpis(this)">Zobacz więcej</button>
                    </div>
                </div>
            </div>
            <div class="festiwal-card">
    <img src="../zdjecia/festiwalLiteracki.png" alt="Festiwal Literacki">
    <div class="festiwal-info">
        <h3>Festiwal Literacki</h3>
        <p class="krotki-opis">Spotkania z autorami, dyskusje i warsztaty pisarskie. Katowice, maj 2025.</p>
        <ul>
            <li>Spotkania autorskie z bestsellerowymi pisarzami</li>
            <li>Warsztaty kreatywnego pisania</li>
            <li>Dyskusje panelowe o literaturze</li>
        </ul>
        <div class="button-container">
            <button class="kup-bilet">Kup bilet</button>
            <button class="zobacz-wiecej" onclick="toggleOpis(this)">Zobacz więcej</button>
        </div>
    </div>
</div>
<div class="festiwal-card">
    <img src="../zdjecia/festiwalGier.png" alt="Festiwal Gier">
    <div class="festiwal-info">
        <h3>Festiwal Gier Planszowych</h3>
        <p class="krotki-opis">Setki gier, turnieje i spotkania z twórcami. Łódź, czerwiec 2025.</p>
        <ul>
            <li>Strefa testowania nowości wydawniczych</li>
            <li>Turnieje z nagrodami</li>
            <li>Spotkania z projektantami gier</li>
        </ul>
        <div class="button-container">
            <button class="kup-bilet">Kup bilet</button>
            <button class="zobacz-wiecej" onclick="toggleOpis(this)">Zobacz więcej</button>
        </div>
    </div>
</div>
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