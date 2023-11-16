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
?>
