<?php

    require_once "../Models/userModel.php";
    $_POST = json_decode(file_get_contents('php://input'), true);
    
    if($_POST["action"]=="register"){

        salvaUtente($_POST["user"],$_POST["pass"]);
    }
    if($_POST["action"]=="login"){

        login($_POST["user"],$_POST["pass"]);
    }

?>