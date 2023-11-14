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

# Ibntroduzione alle modifiche al progetto

All'interno del nostro progetto MVC gestiremo direttamente i tipi di utenti all'interno del Controllore e del Modello degli Utenti anziché crearne uno separato. Questa scelta è stata motivata dal fatto che i tipi di utenti sono molto legati all'utente stesso, e aggiungere altri file complicherebbe solo il nostro sistema.

Per applicare i nuovi elementi al nostro sitema partirò dal modificare il Model dell'utente, poi passerò al Control e infine passerò alla view. Questo approccio è definito top down, ed è molto utilizzato quando si vogliono aggiungere nuovi elementi ad un progetto mvc.

# Modifiche a userModel.php



```php
<?php
function insertUser($username, $password, $usertype) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Pulizia dei dati per prevenire SQL injection
        $username = htmlspecialchars($username);
        $usertype = htmlspecialchars($usertype);

        // Criptazione della password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("CALL insert_user(:username, :password, :usertype)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':usertype', $usertype);

        $stmt->execute();

        echo 0; // Successo
    } catch(PDOException $e) {
        $errorCode = $e->getCode();

        // Verifica il codice di errore per violazione delle chiavi univoche
        if ($errorCode === '23000' || $errorCode === 1062) {
            $errorMessage = $e->getMessage();
    
            if (strpos($errorMessage, 'Username') !== false) {
                echo 2; // Codice di errore per username già esistente
            } elseif (strpos($errorMessage, 'Mail') !== false) {
                echo 3; // Codice di errore per email già esistente
            }
        } else {
            echo 1; // Errore generico
        }
    }

    $conn = null;
}
?>
```


### 1. Connessione al Database
Nel codice, si utilizza PDO per connettersi al database MySQL utilizzando i dettagli come hostname, nome utente e password forniti. Successivamente, si imposta l'attributo `ATTR_ERRMODE` per abilitare la modalità di segnalazione degli errori, che consente di gestire le eccezioni in caso di errori durante la connessione o l'esecuzione delle query.

### 2. Pulizia dei Dati
Per prevenire attacchi di XSS, si utilizza `htmlspecialchars`. Questa funzione converte i caratteri speciali in entità HTML, impedendo così l'esecuzione di script dannosi nel browser dell'utente quando si visualizzano i dati sul front-end.

### 3. Criptazione della Password
La funzione `password_hash` viene utilizzata per criptare la password in modo sicuro prima di salvarla nel database. Questo processo di hash crittografa la password, rendendola inaccessibile e non reversibile.

### 4. Preparazione della Query
L'uso di prepared statements aiuta a prevenire le SQL injection. Nel codice, si prepara una query utilizzando `prepare()` e si utilizzano i placeholder (come `:username`, `:password`, `:usertype`) per i valori che verranno inseriti in modo sicuro.

### 5. Esecuzione della Query
Dopo aver preparato la query, si esegue la stored procedure utilizzando `execute()`. Questo passaggio inserisce i valori forniti in modo sicuro nella stored procedure e esegue la query sul database.

### 6. Gestione degli Errori
L'uso del costrutto `try-catch` è cruciale per gestire gli errori. All'interno del blocco `try`, viene eseguito il codice che potrebbe generare un'eccezione. Se si verifica un errore durante la connessione o l'esecuzione della query, il blocco `catch` cattura l'eccezione e consente di gestire l'errore in modo appropriato. Di seguoto la gestione errori dettagliata: 

1. **Errore di Violazione Chiavi Univoche:** La clausola `if ($errorCode === '23000' || $errorCode === 1062)` controlla se l'errore è una violazione delle chiavi univoche, indicato dai codici specifici ('23000' o 1062).

2. **Esame del Messaggio di Errore:** Se si verifica una violazione delle chiavi univoche, si acquisisce il messaggio di errore con `$errorMessage = $e->getMessage();`.

3. **Ricerca delle Stringhe 'Username' e 'Mail':** Utilizzando `strpos`, si verifica se il messaggio di errore contiene riferimenti alle stringhe 'Username' o 'Mail'. La funzione `strpos` restituisce la posizione del testo cercato all'interno della stringa, quindi se trova la stringa cercata, restituisce la posizione della sua prima occorrenza (un valore diverso da `false`). 

4. **Restituzione dei Codici di Errore:** Se viene rilevato 'Username' nel messaggio di errore, viene restituito il codice `2` come indicatore di errore per l'username già esistente. Se viene rilevato 'Mail' nel messaggio di errore, viene restituito il codice `3` come indicatore di errore per l'email già esistente. Se non si rilevano queste stringhe nel messaggio di errore, viene restituito il codice `1` come errore generico.

Questa procedura consente di distinguere tra l'errore di inserimento dovuto a un username già esistente e quello dovuto a un'email già presente nel database.


# Modifiche a userControl.php

Le modifiche ad userControl sono molto semplici, in quanto seguiremo lo schema già visto in precedenza qui [CONTROL userControl.php](../Lezione2/MVC.md#contrl-usercontrolphp)

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

