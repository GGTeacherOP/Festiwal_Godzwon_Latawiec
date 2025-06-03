<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    echo "Brak ID użytkownika.";
    exit();
}

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $rola = $_POST['rola'];

    $stmt = $pdo->prepare("UPDATE uzytkownicy SET imie = ?, nazwisko = ?, email = ?, rola = ? WHERE uzytkownicy_id = ?");
    $stmt->execute([$imie, $nazwisko, $email, $rola, $id]);

    $_SESSION['success'] = "Dane użytkownika zostały zaktualizowane.";
    header("Location: panel_wlasciciela.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE uzytkownicy_id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Użytkownik nie istnieje.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj użytkownika</title>
    <link rel="stylesheet" href="../styleCSS/Style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="dashboard" style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <h2>Edytuj użytkownika</h2>
        <form method="post">
            <label>Imię:</label><br>
            <input type="text" name="imie" value="<?php echo htmlspecialchars($user['imie']); ?>" required><br><br>

            <label>Nazwisko:</label><br>
            <input type="text" name="nazwisko" 
       value="<?php echo isset($user['nazwisko']) ? htmlspecialchars($user['nazwisko']) : ''; ?>" <br><br>
            
            <label>Email:</label><br>
            <input type="email" name="email" 
       value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" 
       required ><br><br>


            <label>Rola:</label><br>
            <select name="rola">
                <option value="uzytkownik" <?= $user['rola'] === 'uzytkownik' ? 'selected' : '' ?>>Użytkownik</option>
                <option value="wlasciciel" <?= $user['rola'] === 'wlasciciel' ? 'selected' : '' ?>>Właściciel</option>
            </select><br><br>

            <button type="submit">Zapisz zmiany</button>
            <a href="panel_wlasciciela.php" style="margin-left: 20px;">Anuluj</a>
        </form>
    </div>
</body>
</html>
