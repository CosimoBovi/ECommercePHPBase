<?php


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbecommerce";

    function salvaUtente($user,$pass){
        global  $servername,$username,$dbname;

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    
        $hashedPassword = password_hash($pass,PASSWORD_DEFAULT);

        // Preparazione della query per chiamare la procedura memorizzata
        $stmt = $pdo->prepare("CALL InsertUser(:username, :password)");
    
        // Associazione dei valori ai parametri
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':password', $hashedPassword);
    
        // Esecuzione della procedura memorizzata
        $stmt->execute();
    }

    function login($user,$pass){
        global  $servername,$username,$dbname;

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    
        $stmt = $pdo->prepare("CALL FindUser(:username)");

        $stmt->bindParam(':username', $user);
        $stmt->execute();

        // Estrai l'hash dalla procedura memorizzata
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if ($row) {
            $storedHash = $row['Password'];

            if (password_verify($pass, $storedHash)) {
                echo "Password corretta. Accesso consentito.";
            } else {
                echo "Password errata. Accesso negato.";
            }
        } else {
            echo "Utente non trovato nel database.";
        }

    }

?>