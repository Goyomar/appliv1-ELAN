<?php
session_start();

switch ($_GET["action"]) {
    case 'submit':
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $price < 0 ? $price = 1 : $price = $price;
        $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);
        $qtt < 1 ? $qtt = 1 : $qtt = $qtt;
        $image = filter_input(INPUT_POST, "image", FILTER_VALIDATE_URL);

        if (isset($_FILES['fileImage'])) {
            $fileTmpPath = $_FILES['fileImage']['tmp_name'];
            $fileName = $_FILES['fileImage']['name'];

            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedfileExtensions = array("jpg", "png");
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $uploadFileDir = "uploaded_files/";
                $dest_path = $uploadFileDir.$fileName;
                
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    move_uploaded_file($fileTmpPath, $dest_path);
                }
            }
        }
        $fileImage = $dest_path;
        
        $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
        $_SESSION["error"] = "<div class='non'>Erreur veuillez réessayer</div>";
    
        if ($name && $price && $qtt && ($image || $fileImage) && $description){
            $product = [
                "name" => ucfirst($name),
                "price" => $price,
                "qtt" => $qtt,
                "total" => $price*$qtt,
                "description" => $description,
                "image" => $image,
                "fileImage" => $fileImage
            ];
    
            $_SESSION["products"][] = $product;
            $_SESSION["error"] = "<div class='oui'>Votre produit a bien été enregistré !!!</div>";
        }
        header("Location:index.php");
        break;
    
    case 'modif':// ptet mieu en mode 1 form par option pour pas de traitement inutile ? :) surtout si BBD :)))
        if (isset($_GET["id"]) && isset($_SESSION["products"][$_GET["id"]])) {
            $newName = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            $newPrice = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $newQtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);
            $newImage = filter_input(INPUT_POST, "image", FILTER_VALIDATE_URL);
            if (isset($_FILES['fileImage'])) {
                $fileTmpPath = $_FILES['fileImage']['tmp_name'];
                $fileName = $_FILES['fileImage']['name'];
    
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
    
                $allowedfileExtensions = array("jpg", "png");
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = "uploaded_files/";
                    $dest_path = $uploadFileDir.$fileName;
                    
                    if(move_uploaded_file($fileTmpPath, $dest_path)) {
                        move_uploaded_file($fileTmpPath, $dest_path);
                    }
                }
            }
            $newFileImage = $dest_path;
            $newDescription = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

            if ($newName) {
                !empty($newName) ? $_SESSION["products"][$_GET["id"]]["name"] = $newName : $_SESSION["error"] .= "ENTER A NAME ";
            }
            if ($newPrice) {
                $newPrice > 0 ? $_SESSION["products"][$_GET["id"]]["price"] = $newPrice : $_SESSION["error"] .= "ENTER A PRICE ";
            }
            if ($newQtt) {
                $newQtt >= 1 ? $_SESSION["products"][$_GET["id"]]["qtt"] = $newQtt : $_SESSION["error"] .= "ENTER A QUANTITY ";
            }
            if ($newImage){
                $_SESSION["products"][$_GET["id"]]["image"] = $newImage;
            } else {
                $_SESSION["error"] .= "ENTER AN URL IMAGE ";
            }
            if ($newFileImage) {
                unlink($_SESSION["products"][$_GET["id"]]["fileImage"]);
                $_SESSION["products"][$_GET["id"]]["fileImage"] = $newFileImage;
            } else {
                $_SESSION["error"] .= "ENTER AN IMAGE ";
            }
            if ($newDescription) {
                !empty($newDescription) ? $_SESSION["products"][$_GET["id"]]["description"] = $newDescription : $_SESSION["error"] .= "ENTER A DESCRIPTION";
            }
            
            $_SESSION["products"][$_GET["id"]]["total"] = $_SESSION["products"][$_GET["id"]]["price"] * $_SESSION["products"][$_GET["id"]]["qtt"];
            header("Location:detail.php?id=".$_GET['id']."");
        } else {
            $_SESSION["error"] = "CANNOT MODIFY : PRODUCT NOT FOUND";
            header("Location:recap.php");
        }
        break;

    case 'delete':
        if (isset($_GET["id"]) && isset($_SESSION["products"][$_GET["id"]])) {
            unlink($_SESSION["products"][$_GET["id"]]["fileImage"]);
            unset($_SESSION["products"][$_GET["id"]]);
        } else {
            $_SESSION["error"] = "CANNOT DELETE : PRODUCT NOT FOUND";
        }
        header("Location:recap.php");
        break;

    case 'deleteAll':
        foreach ($_SESSION["products"] as $product) {
            unlink($product["fileImage"]);
        }
        unset($_SESSION["products"]);
        header("Location:recap.php");
        break;

    case 'plusqte':
        if (isset($_GET["id"]) && isset($_SESSION["products"][$_GET["id"]])){
            $_SESSION["products"][$_GET["id"]]["qtt"] += 1;
            $_SESSION["products"][$_GET["id"]]["total"] = $_SESSION["products"][$_GET["id"]]["qtt"]*$_SESSION["products"][$_GET["id"]]["price"];
        } else {
            $_SESSION["error"] = "CANNOT PLUS : PRODUCT NOT FOUND";
        }
        header("Location:recap.php");
        break;

    case 'minusqte':
        if (isset($_GET["id"]) && isset($_SESSION["products"][$_GET["id"]])){
            if ($_SESSION["products"][$_GET["id"]]["qtt"] <= 1) {
                unset($_SESSION["products"][$_GET["id"]]);
            }else{
                $_SESSION["products"][$_GET["id"]]["qtt"] -= 1;
                $_SESSION["products"][$_GET["id"]]["total"] = $_SESSION["products"][$_GET["id"]]["qtt"]*$_SESSION["products"][$_GET["id"]]["price"];
            }
        } else {
            $_SESSION["error"] = "CANNOT MINUS : PRODUCT NOT FOUND";
        }
        header("Location:recap.php");
        break;

    default:
        $_SESSION["error"] = "<div class='non'>ERROR<div>";
        header("Location:index.php");
        break;
}
