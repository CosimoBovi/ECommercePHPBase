<?php

    require_once "../Models/userModel.php";
    $_POST = json_decode(file_get_contents('php://input'), true);
    
    if(isset($_POST)){
        if($_POST["action"]=="register"){

            $errore = salvaUtente($_POST["user"],$_POST["pass"],$_POST["userTypeId"]);
            echo json_encode(['errore'=>$errore]);
        }
        if($_POST["action"]=="login"){

            $errore = login($_POST["user"],$_POST["pass"]);
            echo json_encode(['errore'=>$errore]);
        }

        if($_POST["action"]=="controllaLogin"){
            if(isset($_SESSION["username"])){
                echo json_encode(['username'=>$_SESSION["username"], 'userType'=>$_SESSION["userType"]]) ;
            }else{
                echo json_encode(['username'=>'','userType'=>'']) ;
            }
        }

        if($_POST["action"]=="getUserType"){


        }
    }
    if(isset($_GET["logout"])){
        session_destroy();
        header('Location: ../index.php') ;
    }

?>