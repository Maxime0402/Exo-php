<!DOCTYPE html>
    <html lang="fr">
        <head>

            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Se connecter</title>
            <link rel="stylesheet" href="assets/style.css">
            
        </head>
        <body>

            <div class="login-container">

                <h2>Connexion</h2>

                <form action="login.php" method="post">

                    <div class="input-group">
                        <input type="text" id="username" name="login" placeholder="Entrer votre nom d'utilisateur">
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" name="mdp" placeholder="Entrer votre mot de passe">
                    </div>

                    <button type="submit">Se connecter</button>

                    Pas de compte ?<a href="register.php">Register</a>

                </form>

            </div>
            <?php
                session_start();

                if (!empty($_POST)) {
                    // Connexion à la base de données
                    $host = 'localhost';
                    $dbname = 'authentification'; // Nom de la base de données
                    $username = 'root';
                    $password = ''; // Mot de passe vide

                    try {
                        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Récupérer les données du formulaire
                        $login = $_POST['login'];
                        $mdp = $_POST['mdp'];

                        // Requête SQL paramétrée pour vérifier l'existence de l'utilisateur
                        $sql = "SELECT login, mdp FROM connexion WHERE login=:login";
                        $stmt = $conn->prepare($sql);

                        // Vérifier si la préparation de la requête a réussi
                        if (!$stmt) {
                            die("Erreur de préparation de la requête.");
                        }

                        $stmt->bindParam(':login', $login);

                        // Exécuter la requête
                        if ($stmt->execute()) {
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($result && password_verify($mdp, $result['mdp'])) {
                                session_start();
                                // Utilisateur authentifié, démarrer une session et rediriger
                                $_SESSION['login'] = $login;
                                header("location: index.php");
                                exit;
                            } else {
                                echo "Nom d'utilisateur ou mot de passe incorrect.";
                            }
                        } else {
                            echo "Erreur lors de l'exécution de la requête.";
                        }
                    } catch (PDOException $e) {
                        echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
                    }

                    // Fermer la connexion à la base de données
                    $conn = null;
                }
                ?>

    </body>
    </html>
