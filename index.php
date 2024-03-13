<?php require_once "config.php"; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="assets/modifetsup.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 d-flex justify-content-between">
                        <h2 class="pull-left">Liste des utilisateurs</h2>
                        <a href="create.php" class="btn btn-success"><i class="bi bi-plus"></i> Ajouter</a>
                    </div>
                    <?php
                    // Connexion à la base de données
                    $hôte = 'localhost';
                    $nom_base_de_données = 'authentification'; // Nom de la base de données
                    $utilisateur = 'root';
                    $mot_de_passe = ''; // Mot de passe vide

                    try {
                        // Connexion à la base de données avec PDO
                        $pdo = new PDO("mysql:host=$hôte;dbname=$nom_base_de_données", $utilisateur, $mot_de_passe);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Exécution de la requête de sélection
                        $sql = "SELECT * FROM connexion";
                        $stmt = $pdo->query($sql);

                        if($stmt->rowCount() > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Login</th>";
                                        echo "<th>Modification</th>";
                                        echo "<th>Suppression</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $stmt->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['login'] . "</td>";
                                        echo "<td><a href=\"update.php?id=" . $row['Id_Connexion'] . "\"><img src=\"assets/crayon.png\" alt=\"modifier\" class=\"modif\"></a></td>";
                                        echo "<td><a href=\"delete.php?id=" . $row['Id_Connexion'] . "\"><img src=\"assets/poubelle.png\" alt=\"supprimer\" class=\"modif\"></a></td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                        } else{
                            echo '<div class="alert alert-danger"><em>Pas d\'enregistrement</em></div>';
                        }
                    } catch(PDOException $e) {
                        echo "Erreur : " . $e->getMessage();
                    }
                    // Fermer la connexion
                    unset($pdo);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
