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

        echo "Utente inserito con successo!";
    } catch(PDOException $e) {
        echo "Errore nell'inserimento dell'utente: " . $e->getMessage();
    }

    $conn = null;
}
?>
```

### Spiegazione Dettagliata:

1. **Connessione al Database:** Utilizza PDO per connettersi al database MySQL.

2. **Pulizia dei Dati:** Utilizza `htmlspecialchars` per evitare attacchi di XSS (Cross-Site Scripting).

3. **Criptazione della Password:** Utilizza `password_hash` per criptare la password in modo sicuro prima di salvarla nel database.

4. **Preparazione della Query:** Utilizza prepared statements per evitare SQL injection e inserire i valori in modo sicuro.

5. **Esecuzione della Query:** Esegue la stored procedure con `execute()`.

6. **Gestione degli Errori:** Utilizza `try-catch` per gestire gli errori nel caso in cui la connessione o l'esecuzione della query falliscano.
