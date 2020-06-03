<?php

$pdo = new PDO("mysql:host=remotemysql.com;dbname=8Dxns0bFic;charset=utf8;", "8Dxns0bFic", "GGU8VJwBpv");

$pdoStatement = $pdo->prepare($requeteSQL);

$pdoStatement->execute($tabAssoColonneValeur);