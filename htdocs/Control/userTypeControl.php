<?php
require_once "../Models/usertypeModel.php";

$_POST = json_decode(file_get_contents('php://input'), true);

if(isset($_GET["action"])){
    if($_GET["action"] == "getUsertypes"){

        $userTypes = getAllUserTypes();
        if($userTypes !== null){
            echo json_encode($userTypes);
        } else {
            echo json_encode(['errore' => 'Errore nel recupero dei tipi di utenti']);
        }
        
    }
}

?>