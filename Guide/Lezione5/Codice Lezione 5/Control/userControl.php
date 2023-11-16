<?php
    // Includi il file del modello utente (userModel.php).
    require_once "../Model/userModel.php";

    // Leggi i dati inviati dalla richiesta HTTP (in formato JSON) e convertili in un array associativo.
    $Dati = json_decode(file_get_contents('php://input'), true);

    // Verifica l'azione specificata nei dati.
    if ($Dati["action"] == "login") {
        // Se l'azione è "login," chiama la funzione "login" dal modello utente con l'username e la password forniti.
        
        $errore = login($Dati["username"], $Dati["password"]);
        echo json_encode(['errore'=>$errore]);
    }

    if ($Dati["action"] == "userInfo") {
        
        $risultato = testLogin();
        echo json_encode($risultato);


    }

    if(isset($_GET["logout"])){
        session_start();
        session_destroy();
        header('location: ../index.php?logout');
        exit();
    }


    if ($Dati["action"] == "register") {
        // Leggi i dati di registrazione inviati dalla richiesta HTTP
        $username = $Dati["username"];
        $mail = $Dati["mail"];
        $password = $Dati["password"];
        $usertype = $Dati["usertype"];
        
        // Effettua la registrazione dell'utente
        $registrationStatus = insertUser($username, $mail, $password, $usertype);
        
        // Restituisci lo stato della registrazione come risposta JSON
        echo json_encode(['registrationStatus' => $registrationStatus]);
    }

    if ($Dati["action"] == "getUserTypes") {
        // Ottieni gli elementi dalla tabella UserTypes
        $userTypes = getAllUserTypes();
        
        if ($userTypes !== false) {
            // Restituisci tutti gli elementi come risposta JSON
            echo json_encode($userTypes);
        } else {
            // Restituisci un messaggio di errore o un valore predefinito
            echo json_encode(['error' => 'Failed to retrieve user types']);
        }
    }
?>
