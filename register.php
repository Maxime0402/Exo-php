<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>S'enregistrer</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <h2>S'enregistrer</h2>
        <form action="register.php" method="post">
            <div class="input-group">
                <input type="text" id="identifiant" name="login" placeholder="Entrer votre nom d'utilisateur">
            </div>
            <div class="input-group">
                <input type="password" id="password" name="mdp" placeholder="Entrer votre mot de passe">
            </div>
            <button type="submit">S'enregistrer</button>
            <p>Déjà un compte ? <a href="login.php">Login</a></p>
        </form>
    </div>

    <?php
if (!empty($_POST)) {
    // Connexion à la base de données
    $host = 'localhost';
    $dbname = 'authentification'; // Nom de la base de données
    $username = 'root';
    $password = ''; // Mot de passe vide

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $pdo->prepare("SELECT COUNT(*) FROM connexion WHERE login = :login");
        $existingUser->execute(array(':login' => $_POST['login']));
        $count = $existingUser->fetchColumn();

        if ($count > 0) {
            echo "Cet utilisateur existe déjà.";
            exit;
        }

        // Préparation de la requête d'insertion
        $sql = "INSERT INTO connexion (login, mdp) VALUES (:login, :mdp)"; // Correction du nom de la table
        $stmt = $pdo->prepare($sql);

        // Affectation des valeurs aux paramètres de la requête
        $username = $_POST['login'];
        $password = $_POST['mdp'];

        // Utilisation de password_hash() pour sécuriser le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Correction de la liaison des paramètres
        $stmt->bindValue(':login', $username, PDO::PARAM_STR);
        $stmt->bindValue(':mdp', $hashedPassword, PDO::PARAM_STR);

        // Exécution de la requête
        if (!$stmt->execute()) {
            echo "Echec de l'insertion : (" . $stmt->errorCode() . ") " . implode(", ", $stmt->errorInfo());
            exit;
        } else {
            echo "Les données ont été insérées avec succès.";
            header("location: welcome.php");
            exit; // Terminer le script après la redirection
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
        exit;
    }
}
?>


</body>
</html>