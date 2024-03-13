<?php
    function connect() {
        // Vérifier si des données POST ont été envoyées
        $servername="localhost";
        $username="root";
        $password="";
        $dbname="authentification";
        
        try {
            // Connexion à la base de données
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            return $conn; // Retourner le résultat de l'exécution
        } 
        catch (PDOException $e) {
            return null; // Retourner false en cas d'échec */
        }
    }
?>
