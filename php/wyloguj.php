<?php
session_start();
$user_name = $_SESSION['user_name'] ?? '';
session_destroy();
$_SESSION['logout_message'] = "Wylogowano pomyślnie. Do widzenia, " . htmlspecialchars($user_name) . "!";
header("Location: index.php");
exit();
?>