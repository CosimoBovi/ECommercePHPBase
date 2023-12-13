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

function getProducts($pageNumber, $productsPerPage) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Calcolo dell'offset per la paginazione
        $offset = ($pageNumber) * $productsPerPage;

        // Query per estrarre il set di prodotti limitato
        $sql = "SELECT * FROM Products LIMIT :offset, :productsPerPage";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':productsPerPage', $productsPerPage, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;

    } catch(PDOException $e) {
        // Gestione degli errori
        return []; // Restituisce un array vuoto in caso di errore
    }
}

function getTotalProductsCount() {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT COUNT(*) AS total FROM Products"; // Query per il conteggio dei prodotti
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total']; // Restituisce il numero totale di prodotti
    } catch(PDOException $e) {
        return -1; // Gestione degli errori nel caso in cui la query fallisca
    }
}

function getProductById($productId) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM Products WHERE ProductID = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    } catch(PDOException $e) {
        // Gestione dell'errore
        return null;
    }
}

function calculateTotalAndAveragePrices() {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT SUM(UnitPrice) AS total, AVG(UnitPrice) AS average FROM Products");
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    } catch(PDOException $e) {
        // Gestione dell'errore
        return ['error'=>'error'];
    }
}


?>