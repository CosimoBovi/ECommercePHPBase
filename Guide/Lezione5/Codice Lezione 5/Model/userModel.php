
<?php
// Inizializzazione della sessione
session_start();

// La funzione login prende due parametri: $user e $pass, che rappresentano rispettivamente l'username e la password dell'utente.

function login($user, $pass) {
    // Verifica se l'username e la password sono corretti (nota: questo è solo un esempio semplificato).
    // Nella pratica, questa parte verrà sostituita da una chiamata a un database per verificare le credenziali.

    if ($user == "username" && $pass == "password") {
        // Se le credenziali sono corrette, impostiamo una variabile di sessione chiamata "username" con il valore di $user.
        $_SESSION["username"] = $user;

        // Ritorna 0 per indicare che l'accesso è riuscito.
        return 0;
    } else {
        // Se le credenziali non sono corrette, ritorna 1 per indicare che l'accesso è fallito.
        return 1;
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
