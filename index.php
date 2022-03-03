<?php 
        $title = "Ajouter un produit";
        include("header.php"); ?>

        <h1>Ajouter un produit</h1>
        <form action="traitement.php?action=submit" method="post" enctype="multipart/form-data">
            <p>
                <label>
                    Nom du produit :
                    <input type="text" name="name">
                </label>
            </p>
            <p>
                <label>
                    Prix du produit :
                    <input type="number" step="any" name="price">
                </label>
            </p>
            <p>
                <label>
                    Quantité désirée :
                    <input type="number" name="qtt" value="1">
                </label>
            </p>
            <p>
                <label>
                    Image (internet) du produit :
                    <input type="url" name="image">
                </label>
            </p>
            <p>
                <label>
                    Image (fichier) du produit :
                    <input type="file" name="fileImage">
                </label>
            </p>
            <p>
                <label for="description">
                    Description du produit :
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                </label>
            </p>
            <p class="addProduit">
                <input type="submit" name="submit" value="Ajouter le produit">
            </p>
        </form>
        <?php
        if (isset($_SESSION["products"]) || !empty($_SESSION["products"])) {
            echo $_SESSION["error"];
            $_SESSION["error"] = "";
        }
        ?>
    </body>
</html>