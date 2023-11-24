<?php

function insertProduct($name, $description, $unitPrice, $userSellerID) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Imposta il link dell'immagine inizialmente a NULL
        $imageLink = null;

        // Query per l'inserimento del prodotto
        $sql = "INSERT INTO Products (Name, Description, UnitPrice, ImageLink, UserSellerID) VALUES (:name, :description, :unitPrice, :imageLink, :userSellerID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':unitPrice', $unitPrice);
        $stmt->bindParam(':imageLink', $imageLink);
        $stmt->bindParam(':userSellerID', $userSellerID);

        $stmt->execute();

        return 0; // Ritorna 0 se l'inserimento è avvenuto con successo
    } catch(PDOException $e) {
        return 1; // Errore generico
        
    }
}

?>