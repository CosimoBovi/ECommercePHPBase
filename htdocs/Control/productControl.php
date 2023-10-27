<?php

    require_once "../Models/productModel.php";
    $_POST = json_decode(file_get_contents('php://input'), true);

    if(isset($_POST)){
        if($_POST["action"]=="insertProduct"){

            $errore = insertProduct($_POST["productName"],$_POST["productDescription"],$_POST["productPrice"],$_POST["userSellerID"]);
            echo json_encode(['errore'=>$errore]);
        }

    }


?>