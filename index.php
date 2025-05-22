<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Festiwal Godz W Latawiec</title>
    <link rel="stylesheet" href="styleCSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <?php include 'php/header.php'; ?>
        
        <main>
            <?php if (isset($_SESSION['sukces'])): ?>
                <div class="success-message">
                    <?php 
                    echo $_SESSION['sukces'];
                    unset($_SESSION['sukces']);
                    ?>
                </div>
            <?php endif; ?>
        </main>
        
        <?php include 'php/footer.php'; ?>
    </div>
</body>
</html> 