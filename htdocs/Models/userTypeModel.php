<?php


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbecommerce";
    session_start();

    function getAllUserTypes() {
        global $servername, $username, $dbname;
    
        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $stmt = $pdo->prepare("CALL GetAllUserTypes()");
            
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            
            return null; 
        }
    }


?>