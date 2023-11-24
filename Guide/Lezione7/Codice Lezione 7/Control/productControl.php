<?php

// Includi il file del modello prodotto (productModel.php).
require_once "../Model/productModel.php";

// Leggi i dati inviati dalla richiesta HTTP (in formato JSON) e convertili in un array associativo.
$Dati = json_decode(file_get_contents('php://input'), true);

// Per utilizzare le variabili di sessione usiamo session_start() 
session_start();

if ($Dati["action"] == "insertProduct") {
    // Controlla se l'azione richiesta è l'inserimento di un nuovo prodotto
    
    // Verifica se l'utente è loggato e se è un venditore (UsertypeID 2)
    if(isset($_SESSION["userID"]) && isset($_SESSION["usertypeID"]) && $_SESSION["usertypeID"] == 2){
        // Se l'utente è loggato come venditore, raccogli i dati del nuovo prodotto
        $name = $Dati["name"];
        $description = $Dati["description"];
        $unitPrice = $Dati["unitPrice"];
        
        // Ottieni l'ID dell'utente venditore dalla sessione
        $userSellerID = $_SESSION["userID"];
        
        // Chiamata alla funzione per l'inserimento del prodotto con i dati forniti
        $insertionStatus = insertProduct($name, $description, $unitPrice, $userSellerID);
        
        // Restituisci lo stato dell'inserimento come risposta JSON
        echo json_encode(['insertionStatus' => $insertionStatus]);
    } else {
        // Se l'utente non è loggato come venditore, restituisci un codice di errore (9)
        //echo json_encode(['insertionStatus' => 9]);
        echo json_encode($_SESSION);

    }
}

?>