# Registrazione di un utente

Andiamo ora a collegare il database appena creato con il sito php che stiamo costruendo. La prima cosa che andremo a fare sarà permettere alla nostra applicazione di registrare un utente, che sia esso un acquirente o un venditore per il nostro sito ecommerce

# Inserimento dei tipi di utente

Prima di iniziare dobbiamo inserire i vari tipi di utente, per farlo scriviamo una query di inserimento direttamente nel nostro db, seguendo la guida a questo link [Dove scrivere le query](Guide/Lezione4/Database.md#dove-scrivere-le-query)

```sql
INSERT INTO UserTypes (type, description)
VALUES 
    ('Administrator', 'Ruolo dell\'amministratore con pieni privilegi di gestione del sistema.'),
    ('Seller', 'Ruolo del venditore che gestisce i prodotti e le vendite.'),
    ('Buyer', 'Ruolo dell\'acquirente che effettua acquisti e visualizza prodotti disponibili.');
```

In questo modo abbiamo i tre tipi di utenti che possiamo salvare all'interno del nostro database.

# Introduzione alle modifiche al progetto

All'interno del nostro progetto MVC gestiremo direttamente i tipi di utenti all'interno del Controllore e del Modello degli Utenti anziché crearne uno separato. Questa scelta è stata motivata dal fatto che i tipi di utenti sono molto legati all'utente stesso, e aggiungere altri file complicherebbe solo il nostro sistema.

Per applicare i nuovi elementi al nostro sitema partirò dal modificare il Model dell'utente, poi passerò al Control e infine passerò alla view. Questo approccio è definito top down, ed è molto utilizzato quando si vogliono aggiungere nuovi elementi ad un progetto mvc.

# Modifiche a userModel.php

Allinterno dell'userModel.php creato in precedenza, aggiungiamo la seguente funzione per inserire un utente.

```php
function insertUser($username, $password, $usertype) {
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
        $sql = "INSERT INTO Users (Username, Password, Usertypeid) VALUES (:username, :password, :usertype)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
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
```

Vediamo dettagliatamente come è strutturata:

### Connessione al Database
```php
$servername = "localhost";
$dbname = "ecommercedb";
$dbusername = "root";
$dbpassword = "";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```
- La variabile `$servername` rappresenta il server dove è ospitato il database, mentre `$dbname` contiene il nome del database a cui ci si connette.
- `PDO` è un'interfaccia per lavorare con database in PHP, e qui viene utilizzata per stabilire una connessione al database MySQL.
- `setAttribute` viene usato per impostare il modo di gestione degli errori durante le operazioni col database. In questo caso, si imposta il livello di errore a `ERRMODE_EXCEPTION`, il che significa che verranno sollevate eccezioni in caso di errori.

### Gestione dell'Inserimento
```php
 // Hash della password prima di salvarla nel database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO Users (Username, Password, Usertypeid) VALUES (:username, :password, :usertype)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':usertype', $usertype);

$stmt->execute();

return 0; // Ritorna 0 se l'inserimento è avvenuto con successo
```
- Viene preparata una query SQL per inserire i dati nella tabella `Users`. Si utilizzano dei placeholder `:username`, `:password`, `:usertype` che verranno sostituiti con i valori effettivi tramite `bindParam`.
- La funzione `password_hash` viene utilizzata per criptare la password prima di essere salvata nel database per garantire maggiore sicurezza.
- La query viene eseguita attraverso `$stmt->execute()`.
- Se non ci sono errori e l'inserimento avviene con successo arriva fino al return e ritorna 0.

### Gestione degli Errori
```php
catch(PDOException $e) {
    $errorCode = $e->getCode();

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
```
- In caso di eccezione, viene catturata e gestita con `catch(PDOException $e)`.
- Viene ottenuto il codice di errore con `$e->getCode()` per verificare se si tratta di una violazione delle chiavi univoche.
- Se il codice di errore corrisponde a una violazione delle chiavi univoche (`'23000'` o `1062`), si analizza il messaggio di errore per determinare se si tratta di un duplicato per l'username o per l'email.
- strpos controlla se nel messaggio di errore sono presenti le stringhe 'Duplicate entry' e 'Username' o 'Mail'
- Viene restituito un codice specifico a seconda del tipo di violazione dell'unicità.


# Modifiche a userControl.php

Le modifiche ad userControl sono molto semplici, in quanto seguiremo lo schema già visto in precedenza qui [CONTROL userControl.php](../Lezione2/MVC.md#contrl-usercontrolphp) aggiungendo il seguente if di seguito agli altri.

```php
if ($Dati["action"] == "register") {
    // Leggi i dati di registrazione inviati dalla richiesta HTTP
    $username = $Dati["username"];
    $password = $Dati["password"];
    $usertype = $Dati["usertype"];
    
    // Effettua la registrazione dell'utente
    $registrationStatus = registerUser($username, $password, $usertype);
    
    // Restituisci lo stato della registrazione come risposta JSON
    echo json_encode(['registrationStatus' => $registrationStatus]);
}
```

