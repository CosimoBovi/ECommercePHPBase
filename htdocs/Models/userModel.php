<?php


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbecommerce";
    session_start();

    function salvaUtente($user, $pass, $usertypeid) {
        global $servername, $username, $dbname;
    
        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    
            // Preparazione della query per chiamare la procedura memorizzata
            $stmt = $pdo->prepare("CALL InsertUser(:username, :password, :usertypeid)");
    
            // Associazione dei valori ai parametri
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':usertypeid', $usertypeid);
    
            $errore = 0;
    
            // Esecuzione della procedura memorizzata
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                $errore = 1; // Violazione di unicità (username duplicato)
            } else {
                $errore = 2; // Altro errore
            }
    
            $pdo = null;
        }
    
        return $errore;
    }
    

    function login($user,$pass){
        global  $servername,$username,$dbname;

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    
        $stmt = $pdo->prepare("CALL FindUserByUsername(:username)");

        $stmt->bindParam(':username', $user);
        $stmt->execute();

        // Estrai l'hash dalla procedura memorizzata
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if ($row) {
            $storedHash = $row['Password'];
          
            if (password_verify($pass, $storedHash)) {
                
                $_SESSION["username"] = $user;
                $_SESSION["userID"]=$row["User_ID"];
                
                $stmt = $pdo->prepare("CALL GetUserTypeByName(:username)");

                $stmt->bindParam(':username', $user);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION["userType"]=$row["type"];
                
                

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