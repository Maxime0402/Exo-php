<?php
// Verifiez si le paramettre id existe
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Inclure le fichier config
    require_once "config.php";
    
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $login = $_POST['login'];
        
        // Preparer la requete
        $sql = "SELECT * FROM connexion WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        // Bind parameter
        $stmt->bindParam(':id', $_GET["id"], PDO::PARAM_INT);
        
        // Attempt to execute la requette
        $stmt->execute();
        
        // Fetch result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Close statement
        $stmt->closeCursor();
        
        // Close connection
        $pdo = null;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voir l'enregistrement</title>
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
                    <h1 class="mt-5 mb-3">Voir l'enregistrement</h1>
                    <?php if(isset($row) && !empty($row)): ?>
                    <div class="form-group">
                        <label>Login</label>
                        <p><b><?php echo $row["login"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <p><b><?php echo $row["mdp"]; ?></b></p>
                    </div>
                    <?php else: ?>
                    <p>Enregistrement non trouvé.</p>
                    <?php endif; ?>
                    <p><a href="index.php" class="btn btn-primary">Retour</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
