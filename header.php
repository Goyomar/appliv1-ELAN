<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title><?=$title?></title>
    </head>
    <body>
        <header>
            <ul>
                <li><a href="/appli/index.php">Ajouter un produit</a></li>
                <li><a href="/appli/recap.php">Recapitulatif des produits</a></li>
                <li><?php
                if (!isset($_SESSION["products"]) || empty($_SESSION["products"])) {
                    echo "0";
                } else {
                    echo count($_SESSION["products"]);
                }
                 ?> enregistré</li>
            </ul>
        </header>