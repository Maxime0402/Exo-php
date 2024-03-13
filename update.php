<?php
// Inclure le fichier de configuration
require_once "config.php";

// Définir les variables
$login = $mdp = "";
$login_err = $mdp_err = "";

// Vérifier si la valeur id est présente dans le POST pour la mise à jour
if(isset($_POST["id"]) && !empty($_POST["id"])) {
    // Récupérer la valeur de l'ID depuis le champ caché
    $id = $_POST["id"];

    // Valider le login
    $input_login = trim($_POST["login"]);
    if(empty($input_login)) {
        $login_err = "Veuillez entrer un login.";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/", $input_login)) {
        $login_err = "Veuillez entrer un login valide.";
    } else {
        $login = $input_login;
    }

    // Valider le mot de passe
    $input_mdp = trim($_POST["mdp"]);
    if(empty($input_mdp)) {
        $mdp_err = "Veuillez entrer un mot de passe.";
    } else {
        $mdp = $input_mdp;
    }

    // Vérifier les erreurs avant la modification
    if(empty($login_err) && empty($mdp_err)) {
        try {
            // Préparer la requête de mise à jour
            $sql = "UPDATE connexion SET login=:login, mdp=:mdp WHERE id=:id";

            // Préparation de la requête
            $stmt = $pdo->prepare($sql);

            // Liaison des paramètres
            $stmt->bindParam(":login", $param_login, PDO::PARAM_STR);
            $stmt->bindParam(":mdp", $param_mdp, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Définition des valeurs des paramètres
            $param_login = $login;
            $param_mdp = $mdp;
            $param_id = $id;

            // Exécution de la requête
            if($stmt->execute()) {
                // Enregistrement modifié, redirection vers l'index
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Une erreur est survenue.";
            }
        } catch(PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
} else {
    // Vérifier si l'ID est présent dans l'URL
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Récupérer l'ID depuis l'URL
        $id = trim($_GET["id"]);

        try {
            // Préparer la requête de sélection
            $sql = "SELECT * FROM connexion WHERE id = :id"; // Correction ici

            // Préparation de la requête
            $stmt = $pdo->prepare($sql);

            // Liaison des paramètres
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Définition des valeurs des paramètres
            $param_id = $id;

            // Exécution de la requête
            if($stmt->execute()) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Vérifier si un enregistrement correspondant a été trouvé
                if(!$row) {
                    // Pas d'enregistrement trouvé avec cet ID, redirection vers la page d'erreur
                    header("location: error.php");
                    exit();
                } else {
                    // Récupération des valeurs des champs
                    $login = $row["login"];
                    $mdp = $row["mdp"];
                }
            } else {
                echo "Oops! Une erreur est survenue.";
            }
        } catch(PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    } else {
        // Pas d'ID valide, redirection vers la page d'erreur
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'enregistrement</title>
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
                    <h2 class="mt-5">Mise à jour de l'enregistrement</h2>
                    <p>Modifier les champs et enregistrer</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Login</label>
                            <input type="text" name="login" class="form-control <?php echo (!empty($login_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $login; ?>">
                            <span class="invalid-feedback"><?php echo $login_err;?></span>
                            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Ajout d'un champ caché pour l'ID -->
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="text" name="mdp" class="form-control <?php echo (!empty($mdp_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mdp; ?>">
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
