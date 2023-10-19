<?php


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbecommerce";
    session_start();

    function salvaUtente($user,$pass){
        global  $servername,$username,$dbname;

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    
        $hashedPassword = password_hash($pass,PASSWORD_DEFAULT);

        // Preparazione della query per chiamare la procedura memorizzata
        $stmt = $pdo->prepare("CALL InsertUser(:username, :password)");
    
        // Associazione dei valori ai parametri
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':password', $hashedPassword);
        
        $errore=0;
        try{
            // Esecuzione della procedura memorizzata
            $stmt->execute();
        
        }catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                $errore=1;
            } else {
                $errore=2;
            }
        }

        $pdo=null;

        return $errore;
    }

    function login($user,$pass){
        global  $servername,$username,$dbname;

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    
        $stmt = $pdo->prepare("CALL FindPasswordByUsername(:username)");

        $stmt->bindParam(':username', $user);
        $stmt->execute();

        // Estrai l'hash dalla procedura memorizzata
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if ($row) {
            $storedHash = $row['password'];

            if (password_verify($pass, $storedHash)) {
                
                $_SESSION["username"] = $user;
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }

        $pdo=null;
    }

?>