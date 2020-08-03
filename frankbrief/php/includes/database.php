<?php
 
    /**
     * Connexion à la base de données.
     */
    function getPDO() {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=brief_equipe', 'root', '');
            $pdo->exec("SET CHARACTER SET utf8");
            return $pdo;
        } catch (PDOException $e) {
            var_dump($e);
        }
    }
 
    function countDatabaseValue($connexionBDD, $key, $value) {
        $request = "SELECT * FROM login WHERE $key = ?";
        $rowCount = $connexionBDD->prepare($request);
        $rowCount->execute(array($value));
        return $rowCount->rowCount();
    }