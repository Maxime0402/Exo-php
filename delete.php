<?php
session_start();
include ('includes/db.php');
$conn = connect();
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

if(isset($_GET['Id_Connexion'])){
    $id = intval($_GET['Id_Connexion']); // Convertir en entier
    $sql = "DELETE FROM authentification WHERE Id_Connexion=:Id_Connexion"; // Corriger la variable à lier

    $query = $conn->prepare($sql);

    $query->bindValue(':Id_Connexion', $id, PDO::PARAM_INT); // Utiliser Id_Connexion au lieu de Id_Connection
    $query->execute();

    header('Location: welcome.php');
    exit(); // Ajouter exit() après la redirection pour arrêter l'exécution du script
}
?>
