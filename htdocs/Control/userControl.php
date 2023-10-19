<?php

    require_once "../Models/userModel.php";
    $_POST = json_decode(file_get_contents('php://input'), true);
    
    if($_POST["action"]=="register"){

        $errore = salvaUtente($_POST["user"],$_POST["pass"]);
        echo json_encode(['errore'=>$errore]);
    }
    if($_POST["action"]=="login"){

        $errore = login($_POST["user"],$_POST["pass"]);
        echo json_encode(['errore'=>$errore]);
    }

?>