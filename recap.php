
        <?php 
        $title = "Récapitulatif des produits";
        include("header.php");
        echo "<h1>Recapitulatif des produits</h1>";
        if (!isset($_SESSION["products"]) || empty($_SESSION["products"])) {
            echo "<p>Aucun produit en session...</p>";
        } else {
            echo "<table>",
                    "<thead>",
                        "<tr>",
                            "<th>#</th>",
                            "<th>Nom</th>",
                            "<th>Prix</th>",
                            "<th>Quantité</th>",
                            "<th>Total</th>",
                            "<th>Supprimer</th>",
                            "<th>Modifier</th>",
                        "</tr>",
                    "</thead>",
                    "<tbody>";
            $totalGeneral = 0;
            foreach ($_SESSION["products"] as $index => $product) {
                echo    "<tr>",
                            "<td>".($index + 1)."</td>",
                            "<td><a href='detail.php?id=".$index."'>".$product["name"]."</a></td>",
                            "<td>".number_format($product["price"], 2, ",", "&nbsp;")."&nbsp;€</td>",
                            "<td><a class='minusqte' href='traitement.php?action=minusqte&id=".$index."'>-</a>".$product["qtt"]."
                            <a class='plusqte' href='traitement.php?action=plusqte&id=".$index."'>+</a></td>",
                            "<td>".number_format($product["total"], 2, ",", "&nbsp;")."&nbsp;€</td>",
                            "<td><a class='delete' href='traitement.php?action=delete&id=".$index."'>Supprimer</a></td>",
                            "<td><a class='modif' href='modif.php?id=".$index."'>Modifier</a></td>",
                        "</tr>";
                $totalGeneral += $product["total"];
            }
            echo        "<tr>",
                            "<td colspan=5>Total général : </td>",
                            "<td colspan=2><strong>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</strong></td>",
                        "</tr>",
                    "</tbody>",
                "</table>",
                "<div id='reinit'>",
                    "<a class='deleteAll' href='traitement.php?action=deleteAll'>réinitialisé</a>",
                "</div>";
                echo $_SESSION["error"];
                $_SESSION["error"] = "";
        }
        ?>
    </body>
</html>