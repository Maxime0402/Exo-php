<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="assets/welcome.css">

</head>
<body>

<div class="container">
    <h1>Bienvenue, <?php echo $_SESSION['login']; ?> !</h1>
    <p>Merci de vous être connecté.</p>
</div>
    <div class="logout">
        <a href="logout.php">Déconnexion</a>
    </div>


</body>
</html>
