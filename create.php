<?php
// Inclure le fichier config
require_once "config.php";
 
// Definir les variables
$login = $mdp = "";
$login_err = $mdp_err = "";
 
// Traitement
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate login
    $input_login = trim($_POST["login"]);
    if(empty($input_login)){
        $login_err = "Veuillez entrer un nom.";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/", $input_login)){
        $login_err = "Veuillez entrer un nom valide.";
    } else{
        $login = $input_login;
    }
    
    // Validate mot de passe
    $input_mdp = trim($_POST["mdp"]);
    if(empty($input_mdp)){
        $mdp_err = "Veuillez entrer un mot de passe.";     
    } else{
        $mdp = $input_mdp;
    }

    // vérifiez les erreurs avant enregistrement
        if (!empty($_POST)) {
            // Connexion à la base de données
            $host = 'localhost';
            $dbname = 'authentification'; // Nom de la base de données
            $username = 'root';
            $password = ''; // Mot de passe vide

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Prepare an insert statement
            $sql = "INSERT INTO connexion (login, mdp) VALUES (:login, :mdp)";
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
            $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
            
            // Execute the prepared statement
            $stmt->execute();
            
            // Redirect to index page
            header("location: index.php");
            exit();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
        // Close connection
        unset($pdo);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Créer un enregistrement</h2>
                    <p>Remplir le formulaire pour enregistrer l'étudiant dans la base de données</p>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Login</label>
                            <input type="text" name="login" class="form-control <?php echo (!empty($login_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $login; ?>">
                            <span class="invalid-feedback"><?php echo $login_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" name="mdp" class="form-control <?php echo (!empty($mdp_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mdp; ?>">
                            <span class="invalid-feedback"><?php echo $mdp_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
