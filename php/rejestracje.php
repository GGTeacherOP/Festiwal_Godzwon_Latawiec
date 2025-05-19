<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Festiwalowy</title>
    <link rel="stylesheet" href="../styleCSS/StylLogRej.css">
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
                    <li><a href="logowanie.php">Logowanie</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="form-container">
                <h2>Rejestracja</h2>
                <form action="../php/registration.php" method="post">
                    <label for="username">Nazwa użytkownika</label>
                    <input type="text" id="username" name="nazwa" required>
            
                    <label for="firstname">Imię</label>
                    <input type="text" id="firstname" name="imie" required>
            
                    <label for="lastname">Nazwisko</label>
                    <input type="text" id="lastname" name="nazwisko" required>
            
                    <label for="birthdate">Data urodzenia</label>
                    <input type="date" id="birthdate" name="data_urodzenia" required>
            
                    <label for="email">Adres e-mail</label>
                    <input type="email" id="email" name="email" required>

                    <label for="telephone">Telefon</label>
                    <input type="number" id="telephone" name="telefon" required>
            
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="haslo" required>
            
                    <button type="submit">Zarejestruj się</button>
                    <p class="form-footer">Masz już konto? <a href="logowanie.html">Zaloguj się</a></p>
                </form>
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