
<?php
// Inizializzazione della sessione
session_start();

// La funzione login prende due parametri: $user e $pass, che rappresentano rispettivamente l'username e la password dell'utente.

function login($user, $pass) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM Users WHERE Username = :username");
        $stmt->bindParam(':username', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return 2; // Utente non esiste
        }

        $hashedPassword = $result['Password'];

        if (password_verify($pass, $hashedPassword)) {
            $_SESSION["username"]=$user;
            $_SESSION["userID"]=$result['UserID'];
            $_SESSION["usertypeID"]=$result['Usertypeid'];
            return 0; // Accesso riuscito
        } else {
            return 3; // Password errata
        }
    } catch(PDOException $e) {
        return 1; // Errore generico
    }
}

function testLogin(){
    if(isset($_SESSION["username"])){
        return $_SESSION;
    }else{
        return [];
    }
}

function insertUser($username, $mail, $password, $usertype) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Hash della password prima di salvarla nel database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Query per l'inserimento dell'utente
        $sql = "INSERT INTO Users (Username, Mail, Password, Usertypeid) VALUES (:username, :mail, :password, :usertype)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':usertype', $usertype);

        $stmt->execute();

        return 0; // Ritorna 0 se l'inserimento è avvenuto con successo
    } catch(PDOException $e) {
        $errorCode = $e->getCode();

        // Verifica il codice di errore per violazione delle chiavi univoche
        if ($errorCode === '23000' || $errorCode === 1062) {
            $errorMessage = $e->getMessage();

            if (strpos($errorMessage, 'Duplicate entry') !== false && strpos($errorMessage, 'Username') !== false) {
                return 2; // Codice di errore per username già esistente
            } elseif (strpos($errorMessage, 'Duplicate entry') !== false && strpos($errorMessage, 'Mail') !== false) {
                return 3; // Codice di errore per email già esistente
            }
        } else {
            return 1; // Errore generico
        }
    }
}

function getAllUserTypes() {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM UserTypes WHERE type != 'Administrator'");
        $stmt->execute();

        $userTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userTypes;
    } catch(PDOException $e) {
        // Gestione degli errori
        return false;
    }
}
?>