<?php


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbecommerce";
    session_start();

    function insertProduct($productName, $productDescription, $productPrice, $userSellerID) {
        global $servername, $username, $dbname;
    
        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    
            // Definisci i parametri di input
            $params = [
                ':productName' => $productName,
                ':productDescription' => $productDescription,
                ':productPrice' => $productPrice,
                ':userSellerID' => $userSellerID,
            ];
    
            // Preparazione della query per chiamare la procedura memorizzata
            $stmt = $pdo->prepare("CALL InsertProduct(:productName, :productDescription, :productPrice, :userSellerID)");
    
            // Associazione dei parametri
            $stmt->bindParam(':productName', $params[':productName']);
            $stmt->bindParam(':productDescription', $params[':productDescription']);
            $stmt->bindParam(':productPrice', $params[':productPrice']);
            $stmt->bindParam(':userSellerID', $params[':userSellerID']);
    
            // Esecuzione della procedura memorizzata
            $stmt->execute();
    
            // Recupera il risultato dalla procedura (l'ID del nuovo prodotto)
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $pdo = null;
    
            // Restituisci l'ID del nuovo prodotto
            return $result['newProductID'];
        } catch (PDOException $e) {
            // Gestisci eventuali errori qui
            // Ad esempio, puoi registrare gli errori o restituire un codice di errore
            return -1; // Modifica in base alle tue esigenze
        }
    }



?>