<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Festiwalowy</title>
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
            
                <h2>Formularz kontaktowy</h2>
                <form action="#" method="post">
                    <label for="name">Imię i nazwisko</label>
                    <input type="text" id="name" name="name" required />
            
                    <label for="email">Adres email</label>
                    <input type="email" id="email" name="email" required />
            
                    <label for="message">Wiadomość</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
            
                    <button type="submit">Wyślij wiadomość</button>
                </form>
            
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

            <div class="section join-team">
                <h2>Dołącz do naszego zespołu!</h2>
                <p class="join-description">Zostań częścią zespołu największych festiwali w kraju. Poszukujemy pasjonatów kultury i wydarzeń!</p>
                
                <div class="positions-container">
                    <div class="position-tabs">
                        <button class="position-tab active" onclick="otworzNowe('volunteer')">Wolontariusz</button>
                        <button class="position-tab" onclick="otworzNowe('organizer')">Organizator</button>
                        <button class="position-tab" onclick="otworzNowe('technician')">Technik</button>
                        <button class="position-tab" onclick="otworzNowe('security')">Ochrona</button>
                    </div>
                    
                    <div id="volunteer" class="position-content" style="display: block;">
                        <h3>Wolontariusz Festiwalowy</h3>
                        <div class="position-details">
                            <div class="detail-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Wymagana dostępność: min. 3 dni festiwalu</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-user-friends"></i>
                                <span>Zadania: obsługa gości, pomoc przy organizacji, informacja</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-gift"></i>
                                <span>Benefity: bezpłatny wstęp, koszulka, certyfikat</span>
                            </div>
                        </div>
                        <p>Jako wolontariusz będziesz mieć wyjątkową okazję doświadczyć festiwalu od kuchni i poznać wspaniałych ludzi!</p>
                        <a href="#application-form" class="btn">Aplikuj na wolontariusza</a>
                    </div>
                    
                    <div id="organizer" class="position-content">
                        <h3>Organizator Wydarzeń</h3>
                        <div class="position-details">
                            <div class="detail-item">
                                <i class="fas fa-tasks"></i>
                                <span>Zadania: koordynacja zespołów, nadzór nad realizacją programu</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-briefcase"></i>
                                <span>Wymagania: doświadczenie w organizacji wydarzeń</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Forma współpracy: umowa zlecenie lub o dzieło</span>
                            </div>
                        </div>
                        <p>To stanowisko dla osób z inicjatywą, które potrafią działać pod presją czasu i zarządzać zespołem.</p>
                        <a href="#application-form" class="btn">Aplikuj na organizatora</a>
                    </div>
                    
                    <div id="technician" class="position-content">
                        <h3>Technik Sceniczny</h3>
                        <div class="position-details">
                            <div class="detail-item">
                                <i class="fas fa-sliders-h"></i>
                                <span>Zadania: obsługa sprzętu nagłośnieniowego/oświetleniowego</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-tools"></i>
                                <span>Wymagania: doświadczenie techniczne, znajomość sprzętu</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>Godziny pracy: zmiany dzienne i nocne</span>
                            </div>
                        </div>
                        <p>Dołącz do naszego zespołu technicznego i pomóż stworzyć niezapomniane widowiska!</p>
                        <a href="#application-form" class="btn">Aplikuj na technika</a>
                    </div>
                    
                    <div id="security" class="position-content">
                        <h3>Pracownik Ochrony</h3>
                        <div class="position-details">
                            <div class="detail-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Zadania: zapewnienie bezpieczeństwa uczestnikom</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-id-card"></i>
                                <span>Wymagania: licencja pracownika ochrony</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-tshirt"></i>
                                <span>Wyposażenie: zapewniamy uniform i niezbędny sprzęt</span>
                            </div>
                        </div>
                        <p>Zadbaj o bezpieczeństwo tysięcy uczestników podczas największych festiwali w kraju.</p>
                        <a href="#application-form" class="btn">Aplikuj na ochronę</a>
                    </div>
                </div>
                
                <div id="application-form" class="application-form">
                    <h3>Formularz aplikacyjny</h3>
                    <form id="job-application">
                        <div class="form-group">
                            <label for="position">Stanowisko:</label>
                            <select id="position" name="position" required>
                                <option value="">-- Wybierz stanowisko --</option>
                                <option value="volunteer">Wolontariusz</option>
                                <option value="organizer">Organizator</option>
                                <option value="technician">Technik</option>
                                <option value="security">Ochrona</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Imię i nazwisko:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Telefon:</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="experience">Doświadczenie (opcjonalnie):</label>
                            <textarea id="experience" name="experience" rows="4"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="motivation">Dlaczego chcesz do nas dołączyć?</label>
                            <textarea id="motivation" name="motivation" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="cv">Załącz CV (PDF, max 5MB):</label>
                            <input type="file" id="cv" name="cv" accept=".pdf" required>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <input type="checkbox" id="consent" name="consent" required>
                            <label for="consent">Wyrażam zgodę na przetwarzanie moich danych osobowych w celu rekrutacji.</label>
                        </div>
                        
                        <button type="submit" class="btn">Wyślij aplikację</button>
                    </form>
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
<script src="../JavaScript/kontaktScript.js"></script>
</html>