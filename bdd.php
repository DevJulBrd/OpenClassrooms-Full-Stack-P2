<?php

// Fonction qui permet la connexion a la base de donnee
function getPDO() : PDO {
    static $pdo = null;
    if($pdo === null){
        // Variables necessaires decomposees 
        $host = 'localhost';
        $dbname = 'artbox';
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $user = 'root';
        $password = '';

        try {
            $pdo = new PDO($dsn, $user, $password);
        }
        // Recuperationb des erreurs de connexion 
        catch (PDOException $e){
            die('Erreur connexion BDD : ' . $e->getMessage());
        }
    }
    return $pdo
}