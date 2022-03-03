<?php
$title = "Modifier le produit";
require("header.php");
if (isset($_GET["id"])) {
    $produit = $_SESSION["products"][$_GET["id"]];
    echo "<h1>Modifier le produit</h1>",
         "<p>information actuelle du produit :</p>",
         "<ul>",
            "<li>Nom : ".$produit["name"]."</li>",
            "<li>Prix : ".$produit["price"]." €</li>",
            "<li>Quantité : ".$produit["qtt"]."</li>",
            "<li>image (internet) : ".$produit["image"]."</li>",
            "<li>Description : ".$produit["description"]."</li>",
         "</ul>";
         ?>
        <form action="traitement.php?action=modif&id=<?=$_GET["id"]?>" method="post" enctype="multipart/form-data">
            <p>
                <label>
                    Modifier le nom du produit :
                    <input type="text" name="name" value="<?= $produit["name"]?>">
                </label>
            </p>
            <p>
                <label>
                    Modifier le prix du produit :
                    <input type="number" step="any" name="price" value="<?= $produit["price"]?>">
                </label>
            </p>
            <p>
                <label>
                    Modifier la quantité désirée :
                    <input type="number" name="qtt" value="<?= $produit["qtt"]?>">
                </label>
            </p>
            <p>
                <label>
                    Modifier l'image (internet) du produit :
                    <input type="url" name="image" value="<?= $produit["image"]?>">
                </label>
            </p>
            <p>
                <label>
                    Modifier l'image (fichier) du produit :
                    <input type="file" name="fileImage">
                </label>
            </p>
            <p>
                <label for="description">
                    Modifier la Description du produit :
                    <textarea name="description" id="description" cols="30" rows="10"><?= $produit["description"]?></textarea>
                </label>
            </p>
            <p class="modifProduit">
                <input type="submit" name="modif" value="Modifier le produit">
            </p>
        </form>
         <?php
        echo $_SESSION["error"];
        $_SESSION["error"] = "";

} else {
    header("Location:index.php");
    die;
}

// "name" => ucfirst($name),
// "price" => $price,
// "qtt" => $qtt,
// "total" => $price*$qtt,
// "description" => $description,
// "image" => $image,
// "fileImage" => $fileImage