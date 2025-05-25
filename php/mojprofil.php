<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: logowanie.php');
    exit();
}

$user_id = $_SESSION['user_id'] ?? $_SESSION['id_uzytkownika'] ?? null;
$user_role = $_SESSION['user_role'] ?? null;
$user_name = $_SESSION['user_name'] ?? $_SESSION['user_firstname'] ?? 'Użytkownik';

if (!$user_id) {
    echo 'Błąd sesji użytkownika.';
    exit();
}

// Obsługa edycji profilu
if (isset($_POST['edit_profile'])) {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $stmt = $pdo->prepare('UPDATE uzytkownicy SET imie=?, nazwisko=?, email=?, telefon=? WHERE uzytkownicy_id=?');
    $stmt->execute([$imie, $nazwisko, $email, $telefon, $user_id]);
    $_SESSION['sukces'] = 'Dane zostały zaktualizowane!';
    header('Location: mojprofil.php');
    exit();
}
// Obsługa zmiany hasła
if (isset($_POST['change_password'])) {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $repeat = $_POST['repeat_password'];
    $stmt = $pdo->prepare('SELECT haslo FROM uzytkownicy WHERE uzytkownicy_id=?');
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!password_verify($old, $row['haslo'])) {
        $error = 'Stare hasło nieprawidłowe!';
    } elseif ($new !== $repeat) {
        $error = 'Nowe hasła nie są identyczne!';
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE uzytkownicy SET haslo=? WHERE uzytkownicy_id=?');
        $stmt->execute([$hash, $user_id]);
        $_SESSION['sukces'] = 'Hasło zostało zmienione!';
        header('Location: mojprofil.php');
        exit();
    }
}

// Pobierz aktualne dane użytkownika
$stmt = $pdo->prepare('SELECT * FROM uzytkownicy WHERE uzytkownicy_id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'Nie znaleziono użytkownika.';
    exit();
}

include 'header.php';
echo '<main class="dashboard">';
echo '<h1>Twój profil</h1>';
if (isset($_SESSION['sukces'])) {
    echo '<div class="success-message">' . $_SESSION['sukces'] . '</div>';
    unset($_SESSION['sukces']);
}
if (isset($error)) {
    echo '<div class="error-message">' . $error . '</div>';
}

// Przycisk edycji profilu i zmiany hasła
?>
<div style="margin-bottom:20px;">
    <button onclick="document.getElementById('editProfile').style.display='block'">Edytuj profil</button>
    <button onclick="document.getElementById('changePassword').style.display='block'">Zmień hasło</button>
    <a href="wyloguj.php" class="btn">Wyloguj</a>
</div>

<div id="editProfile" style="display:none;">
    <h3>Edycja profilu</h3>
    <form method="post">
        <input type="hidden" name="edit_profile" value="1">
        <label>Imię: <input type="text" name="imie" value="<?= htmlspecialchars($user['imie']) ?>" required></label><br>
        <label>Nazwisko: <input type="text" name="nazwisko" value="<?= htmlspecialchars($user['nazwisko']) ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></label><br>
        <label>Telefon: <input type="text" name="telefon" value="<?= htmlspecialchars($user['telefon']) ?>" required></label><br>
        <button type="submit">Zapisz</button>
        <button type="button" onclick="document.getElementById('editProfile').style.display='none'">Anuluj</button>
    </form>
</div>
<div id="changePassword" style="display:none;">
    <h3>Zmiana hasła</h3>
    <form method="post">
        <input type="hidden" name="change_password" value="1">
        <label>Stare hasło: <input type="password" name="old_password" required></label><br>
        <label>Nowe hasło: <input type="password" name="new_password" required></label><br>
        <label>Powtórz nowe hasło: <input type="password" name="repeat_password" required></label><br>
        <button type="submit">Zmień hasło</button>
        <button type="button" onclick="document.getElementById('changePassword').style.display='none'">Anuluj</button>
    </form>
</div>
<?php

if ($user['rola'] === 'wlasciciel') {
    // Panel właściciela
    echo '<h2>Panel właściciela</h2>';
    // Podsumowanie finansowe
    // Suma wypłat dla pracowników (wydatki)
    $wydatki = $pdo->query("SELECT SUM(kwota) as suma FROM zarobki")->fetch(PDO::FETCH_ASSOC)['suma'] ?? 0;
    // Suma przychodów z biletów (dochody)
    $dochody = $pdo->query("SELECT COALESCE(SUM(w.cena), 0) as suma FROM bilety b JOIN wydarzenia w ON b.wydarzenia_id = w.wydarzenia_id")->fetch(PDO::FETCH_ASSOC)['suma'] ?? 0;
    $bilans = $dochody - $wydatki;
    echo '<h3>Podsumowanie finansowe</h3>';
    echo '<ul>';
    echo '<li>Dochody: ' . htmlspecialchars($dochody) . ' zł</li>';
    echo '<li>Wydatki: ' . htmlspecialchars($wydatki) . ' zł</li>';
    echo '<li>Bilans: ' . htmlspecialchars($bilans) . ' zł</li>';
    echo '</ul>';
    // Lista pracowników z edycją/usuwaniem
    $pracownicy = $pdo->query("SELECT u.uzytkownicy_id, u.imie, u.nazwisko, u.nazwa, u.email, p.stanowisko, p.zarobki, u.rola FROM uzytkownicy u LEFT JOIN pracownicy p ON u.uzytkownicy_id = p.uzytkownicy_id WHERE u.rola != 'wlasciciel'")->fetchAll(PDO::FETCH_ASSOC);
    echo '<h3>Pracownicy</h3>';
    echo '<table><tr><th>Imię i nazwisko</th><th>Login</th><th>Email</th><th>Stanowisko</th><th>Rola</th><th>Zarobki</th><th>Akcje</th></tr>';
    foreach ($pracownicy as $p) {
        echo '<tr><td>' . htmlspecialchars($p['imie'] . ' ' . $p['nazwisko']) . '</td><td>' . htmlspecialchars($p['nazwa']) . '</td><td>' . htmlspecialchars($p['email']) . '</td><td>' . htmlspecialchars($p['stanowisko'] ?? $p['rola']) . '</td><td>' . htmlspecialchars($p['rola']) . '</td><td>' . htmlspecialchars($p['zarobki'] ?? '-') . ' zł</td>';
        echo '<td><a href="?edit_pracownik=' . $p['uzytkownicy_id'] . '">Edytuj</a> | <a href="?delete_pracownik=' . $p['uzytkownicy_id'] . '" onclick="return confirm(\'Na pewno usunąć?\')">Usuń</a></td></tr>';
    }
    echo '</table>';
    echo '<a href="?add_pracownik=1" class="btn">Dodaj pracownika</a>';
    // Podgląd klientów i ich biletów
    $klienci = $pdo->query("SELECT * FROM uzytkownicy WHERE rola = 'klient'")->fetchAll(PDO::FETCH_ASSOC);
    echo '<h3>Klienci i ich bilety</h3>';
    foreach ($klienci as $k) {
        echo '<div style="margin-bottom:10px;"><strong>' . htmlspecialchars($k['imie'] . ' ' . $k['nazwisko']) . ' (' . htmlspecialchars($k['email']) . ')</strong>';
        $bilety = $pdo->prepare('SELECT b.*, w.tytul, w.rozpoczecie FROM bilety b JOIN wydarzenia w ON b.wydarzenia_id = w.wydarzenia_id WHERE b.uzytkownicy_id = ?');
        $bilety->execute([$k['uzytkownicy_id']]);
        $lista_biletow = $bilety->fetchAll(PDO::FETCH_ASSOC);
        if ($lista_biletow) {
            echo '<ul>';
            foreach ($lista_biletow as $b) {
                echo '<li>Wydarzenie: ' . htmlspecialchars($b['tytul']) . ' | Data: ' . htmlspecialchars($b['rozpoczecie']) . ' | Nr biletu: ' . htmlspecialchars($b['bilet_id']) . ' | Cena: ' . (isset($b['cena']) ? htmlspecialchars($b['cena']) . ' zł' : '-') . '</li>';
            }
            echo '</ul>';
        } else {
            echo ' - brak biletów';
        }
        echo '</div>';
    }
}
elseif (in_array($user['rola'], ['sprzataczka','informatyk','organizator','technik sceniczny','specjalista ds. promocji','koordynator wolontariuszy'])) {
    // Panel pracownika
    $pracownik = $pdo->prepare('SELECT * FROM pracownicy WHERE uzytkownicy_id = ?');
    $pracownik->execute([$user_id]);
    $prac = $pracownik->fetch(PDO::FETCH_ASSOC);
    echo '<h2>Panel pracownika</h2>';
    echo '<p><strong>Imię i nazwisko:</strong> ' . htmlspecialchars($user['imie'] . ' ' . $user['nazwisko']) . '</p>';
    echo '<p><strong>Stanowisko:</strong> ' . htmlspecialchars($prac['stanowisko'] ?? $user['rola']) . '</p>';
    echo '<p><strong>Zarobki:</strong> ' . htmlspecialchars($prac['zarobki'] ?? '-') . ' zł</p>';
    // Historia wypłat
    $wplaty = $pdo->prepare('SELECT * FROM zarobki WHERE uzytkownicy_id = ? ORDER BY data_wyplaty DESC');
    $wplaty->execute([$user_id]);
    $lista_wyplat = $wplaty->fetchAll(PDO::FETCH_ASSOC);
    echo '<h3>Historia wypłat</h3>';
    if ($lista_wyplat) {
        echo '<ul>';
        foreach ($lista_wyplat as $w) {
            echo '<li>' . htmlspecialchars($w['data_wyplaty']) . ': ' . htmlspecialchars($w['kwota']) . ' zł (' . htmlspecialchars($w['opis']) . ')</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Brak wypłat.</p>';
    }
    // Rezerwacje noclegów
    $rezerwacje = $pdo->prepare('SELECT r.*, n.nazwa AS nocleg FROM rezerwacje_noclegow r JOIN noclegi n ON r.nocleg_id = n.nocleg_id WHERE r.uzytkownicy_id = ?');
    $rezerwacje->execute([$user_id]);
    $lista_rez = $rezerwacje->fetchAll(PDO::FETCH_ASSOC);
    echo '<h3>Twoje rezerwacje noclegów</h3>';
    if ($lista_rez) {
        echo '<ul>';
        foreach ($lista_rez as $r) {
            echo '<li>' . htmlspecialchars($r['nocleg']) . ' | ' . htmlspecialchars($r['data_przyjazdu']) . ' - ' . htmlspecialchars($r['data_wyjazdu']) . ' | Status: ' . htmlspecialchars($r['status']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Brak rezerwacji noclegów.</p>';
    }
}
else {
    // Panel klienta
    echo '<h2>Panel klienta</h2>';
    echo '<p><strong>Imię i nazwisko:</strong> ' . htmlspecialchars($user['imie'] . ' ' . $user['nazwisko']) . '</p>';
    echo '<p><strong>Email:</strong> ' . htmlspecialchars($user['email']) . '</p>';
    // Bilety
    $bilety = $pdo->prepare('SELECT b.bilet_id, w.tytul, w.rozpoczecie, w.cena FROM bilety b JOIN wydarzenia w ON b.wydarzenia_id = w.wydarzenia_id WHERE b.uzytkownicy_id = ?');
    $bilety->execute([$user_id]);
    $lista_biletow = $bilety->fetchAll(PDO::FETCH_ASSOC);
    echo '<h3>Twoje bilety</h3>';
    if ($lista_biletow) {
        echo '<table class="bilety-tabela">';
        echo '<tr><th>Wydarzenie</th><th>Data</th><th>Cena</th><th>Nr biletu</th></tr>';
        foreach ($lista_biletow as $b) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($b['tytul']) . '</td>';
            echo '<td>' . htmlspecialchars($b['rozpoczecie']) . '</td>';
            echo '<td>' . (isset($b['cena']) ? htmlspecialchars($b['cena']) . ' zł' : '-') . '</td>';
            echo '<td>' . htmlspecialchars($b['bilet_id']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Nie masz jeszcze żadnych biletów.</p>';
    }
    // Rezerwacje noclegów
    $rezerwacje = $pdo->prepare('SELECT r.*, n.nazwa AS nocleg FROM rezerwacje_noclegow r JOIN noclegi n ON r.nocleg_id = n.nocleg_id WHERE r.uzytkownicy_id = ?');
    $rezerwacje->execute([$user_id]);
    $lista_rez = $rezerwacje->fetchAll(PDO::FETCH_ASSOC);
    echo '<h3>Twoje rezerwacje noclegów</h3>';
    if ($lista_rez) {
        echo '<ul>';
        foreach ($lista_rez as $r) {
            echo '<li>' . htmlspecialchars($r['nocleg']) . ' | ' . htmlspecialchars($r['data_przyjazdu']) . ' - ' . htmlspecialchars($r['data_wyjazdu']) . ' | Status: ' . htmlspecialchars($r['status']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Brak rezerwacji noclegów.</p>';
    }
}
echo '</main>';
include 'footer.php'; 