<?php
    $title = "detail du produit";
        include("header.php");
        if(isset($_GET["id"]) && isset($_SESSION["products"][$_GET["id"]])){
            $produit = $_SESSION["products"][$_GET["id"]];

            echo $_SESSION["error"];
                 $_SESSION["error"] = "";

            echo "<h1>".$produit["name"]."</h1>",
                 "<img src='".$produit["image"]."' alt=':('>",
                 "<p>".$produit["description"]."</p>",
                 "<h2>Prix : ".$produit["price"]." €</h2>";
            echo "<img src='".$produit["fileImage"]."'>";

        } else {
            header("Location:recap.php");
            die;
        }
        
?>