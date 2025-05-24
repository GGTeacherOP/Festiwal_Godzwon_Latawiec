<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: logowanie.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mój Profil</title>
    <style>
        .dashboard-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>Twój panel użytkownika</h1>
        
        <div class="dashboard-box">
            <h2>Twoje dane</h2>
            <p><strong>Imię:</strong> <?= htmlspecialchars($_SESSION['imie']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
        </div>
        
        <div class="dashboard-box">
            <h2>Szybkie akcje</h2>
            <a href="festiwale.php" class="btn">Zobacz festiwale</a>
            <a href="edit_profile.php" class="btn">Edytuj profil</a>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>