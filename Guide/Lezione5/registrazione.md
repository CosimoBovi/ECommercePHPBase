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
```

Vediamo dettagliatamente come è strutturata:

**1. Connessione al Database**
```php
$servername = "localhost";
$dbname = "ecommercedb";
$dbusername = "root";
$dbpassword = "";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```
- La variabile `$servername` rappresenta il server dove è ospitato il database, mentre `$dbname` contiene il nome del database a cui ci si connette.
- Le varibili `$dbusername` e `$dbpassword` sono le credianzili di accesso al db, visto che non le abbiamo modificate usiamo quelle di default di MySQL.
- `PDO` è un'interfaccia per lavorare con database in PHP, e qui viene utilizzata per stabilire una connessione al database MySQL.
- `setAttribute` viene usato per impostare il modo di gestione degli errori durante le operazioni col database. In questo caso, si imposta il livello di errore a `ERRMODE_EXCEPTION`, il che significa che verranno sollevate eccezioni in caso di errori.

**2. Gestione dell'Inserimento**
```php
 // Hash della password prima di salvarla nel database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO Users (Username, Password, Usertypeid) VALUES (:username, :password, :usertype)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':mail', $mail);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':usertype', $usertype);

$stmt->execute();

return 0; // Ritorna 0 se l'inserimento è avvenuto con successo
```
- Viene preparata una query SQL per inserire i dati nella tabella `Users`. Si utilizzano dei placeholder `:username`, `:mail`, `:password`, `:usertype` che verranno sostituiti con i valori effettivi tramite `bindParam`.
- La funzione `password_hash` viene utilizzata per criptare la password prima di essere salvata nel database per garantire maggiore sicurezza.
- La query viene eseguita attraverso `$stmt->execute()`.
- Se non ci sono errori e l'inserimento avviene con successo arriva fino al return e ritorna 0.

**3. Gestione degli Errori** 
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
        $mail = $Dati["mail"];
        $password = $Dati["password"];
        $usertype = $Dati["usertype"];
        
        // Effettua la registrazione dell'utente
        $registrationStatus = insertUser($username, $mail, $password, $usertype);
        
        // Restituisci lo stato della registrazione come risposta JSON
        echo json_encode(['registrationStatus' => $registrationStatus]);
    }
```


# Estrazione dei tipi di utente in userModel.php

Per permettere la registrazione di un utente è necessario fornire una scelta corretta dei tipi di utenti. Per questo dobbiamo scrivere una funzione che estragga i tipi di utenti nel database. Scegliamo di farlo in userModel.php

```php
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
```
Fonisco una spiegazione dettagliata degli elementi non visti in precedenza:

1. **Preparazione della query SQL:** Dopo aver stabilito la connessione, la funzione prepara una query SQL per selezionare tutti gli elementi dalla tabella degli user types (`SELECT * FROM UserTypes WHERE type != 'Administrator'`). Eliminiamo gli amministratori perchè non permettiamo agli utenti di registrarsi come amministratore.

2. **Recupero dei risultati:** Se la query è eseguita con successo, la funzione `$stmt->fetchAll(PDO::FETCH_ASSOC);` ottiene i dati risultanti dalla query. Essa itererà attraverso i risultati ottenuti e li inserirà uno per uno all'interno di un array.

3. **Restituzione dei dati:** Alla fine, l'array che contiene tutti i tipi di utenti viene restituito alla parte del codice che ha invocato la funzione `getAllUserTypes()`.


# Estrazione dei tipi di utente - Modifiche a userControl.php

In userControl.php aggiungiamo un'altro if per gestire l'accesso alla funzione appena creata.

```php
if ($Dati["action"] == "getUserTypes") {
    // Ottieni gli elementi dalla tabella UserTypes
    $userTypes = getAllUserTypes();
    
    if ($userTypes !== false) {
        // Restituisci tutti gli elementi come risposta JSON
        echo json_encode($userTypes);
    } else {
        // Restituisci un messaggio di errore o un valore predefinito
        echo json_encode(['error' => 'Failed to retrieve user types']);
    }
}
```


# VIEW registrazione utente - register.php

Creiamo ora una nuova pagina chiamata register.php simile a login.php per permettere all'utente la registrazione

```html
    <?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>

    <script src="./js/register.js"></script>

    <div class="row w-100">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <form id="registrationForm">
                <label class="w-25">Username: </label> <input type="text" id="username" class=" form-control w-100 my-2"> <br>
                <label class="w-25">email: </label> <input type="email" id="mail" class="form-control w-100 my-2"> <br>
                <label class="w-25">Password: </label> <input type="password" id="password" class=" form-control w-100 my-2"> <br>
                <label class="w-25">User Type: </label>
                <select id="userType" class="form-control w-100 my-2">
                    <!-- Opzioni per gli user types verranno caricate dinamicamente con JavaScript -->
                </select> <br>
                <input type="button" class="btn btn-success w-100 mt-3" onclick="registerUser()" value="Registrati">  
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>

    <?php include_once 'footer.php' ?>
```
Come si nota l'aggiunta maggiore è quella di una select inizialmente vuota. Il suo ID è `userTypeSelect`. Sarà poi riempita dinamicamente utilizzando JavaScript. Questo significa che, attraverso JavaScript, andremo a popolare le opzioni all'interno della select box con i tipi di utenti disponibili nel sistema, recuperati dal backend tramite una chiamata AJAX.

Una volta che le opzioni sono state caricate nella select, l'utente potrà selezionare il tipo di utente desiderato e poi fare clic sul pulsante "Registrati" per inviare i dati al server e completare il processo di registrazione.

Da notare che il js collegato è register.js che sarà fornito di seguito

# register.js - caricamento dinamico dei tipi di utenti


```js
document.addEventListener("DOMContentLoaded", function() {
    
    userTypeGenerator();
    
});

async function userTypeGenerator(){

    let dati={};
    dati.action="getUserTypes";
    url="./Control/userControl.php";

    let obj = await fetch(url,
    {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati)
    }).then((response) => response.json())
    .then((data) => {
        
        if (!('error' in data)) {

           data.forEach(element => {
                let newOption = document.createElement("option");
                newOption.value = element.Usertypeid;
                newOption.innerText = element.Type;
                document.getElementById("userType").appendChild(newOption);
           });
        }
        
    })
}

```

Questo codice JavaScript è progettato per popolare dinamicamente le opzioni di una select box nell'HTML.

1. **DOMContentLoaded:** Questo evento indica che viene chiamata la funzione `userTypeGenerator()` solo quando la pagina è completamente caricata.

2. **userTypeGenerator():** Questa funzione si occupa di ottenere i dati degli user types dal server. Utilizza l'oggetto `fetch` per inviare una richiesta POST al server (`./Control/userControl.php`) per ottenere l'elenco degli user types. I dati sono inviati e ricevuti nel formato JSON.

3. **Risposta del server:** Se la richiesta al server ha successo, la funzione riceve i dati degli user types come oggetto JSON. Controlla se non ci sono errori (verificando se non c'è la chiave 'error' nell'oggetto ricevuto). Se non ci sono errori, itera attraverso ogni elemento dell'array ricevuto.

4. **Popolamento della select box:** Per ogni elemento nell'array ricevuto, la funzione crea un nuovo elemento `<option>` per la select box. Imposta il valore (`value`) dell'opzione come Usertypeid e il testo mostrato all'utente (`innerText`) come Type. Queste opzioni vengono poi aggiunte come figli dell'elemento select box con id "userType".

In sintesi, questo script attende il caricamento completo della pagina e, una volta caricato, invia una richiesta al server per ottenere gli user types e li visualizza come opzioni all'interno della select box nell'HTML.


# register.js - registrazione di un utente

Ora che il nostro form è completo aggiungiamo al js la funzione registerUser() che era presente nel button del form

```js
function registerUser(){

    let username = document.getElementById('username').value;
    let mail = document.getElementById('mail').value;
    let password = document.getElementById('password').value;
    let userType = document.getElementById('userType').value;

    let dati = {
        username: username,
        mail: mail,
        password: password,
        usertype: userType,
        action: "register"
    };

    let url = "./Control/userControl.php";

    
    let response =  fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati)
    }).then((response) => response.json())
    .then((data) => {
        
        if(data.registrationStatus==0) {
            alert("registrazione avvenuta con successo");
            location.href="./index.php";
        }else if(data.registrationStatus==1){
            alert("errore");
        }else if(data.registrationStatus==2){
            alert("Username esistente");
        }else if(data.registrationStatus==3){
            alert("Mail esistente");
        }
    })
    
}

```

1. **Recupero dei dati**: La funzione recupera i valori inseriti negli input del form per `username`, `mail`, `password` e `userType`.

2. **Creazione dei dati da inviare**: I dati recuperati vengono inseriti in un oggetto `dati`, insieme all'azione "register", in modo che possano essere inviati al server per la registrazione dell'utente.

3. **Chiamata fetch**: Viene effettuata una richiesta `fetch` verso il server (`userControl.php`) usando il metodo POST, con intestazioni di tipo JSON, e includendo nel corpo della richiesta i dati dell'utente convertiti in formato JSON.

4. **Gestione della risposta**: Una volta ottenuta la risposta dal server sotto forma di JSON, vengono gestiti i vari casi possibili:
   - Se `registrationStatus` è 0, significa che la registrazione è avvenuta con successo e viene mostrato un messaggio di avvenuta registrazione. Successivamente l'utente viene reindirizzato alla pagina principale.
   - Se `registrationStatus` è 1, si verifica un errore generico e viene mostrato un messaggio di errore.
   - Se `registrationStatus` è 2, l'username inserito esiste già e viene mostrato un messaggio corrispondente.
   - Se `registrationStatus` è 3, l'indirizzo email inserito esiste già e viene mostrato un messaggio corrispondente.

# Modifiche a Login.js

Come ultima cosa diamo un modo all'utente per arrivare alla pagina di registrazione, per farlo aggiungo semplicemente un link ad un button nella pagina di login.php

```php
   <?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>

    <script src="./js/login.js"></script>

    <div class="row w-100">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <form>
                <label class="w-25">username: </label> <input type="text" id="user" class="form-control w-100 my-2"> 
                <label class="w-25">password: </label> <input type="password" id="pass" class="form-control w-100 my-2"> 
                <input type="button" class="btn btn-success w-100 mt-5" onclick="login()" value="Entra">  
                <a href="./register.php"><input type="button" class="btn btn-success w-100 mt-5" value="Registrati"> </a>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>

    <?php include_once 'footer.php' ?>
```

il codice aggiunto è 

```php
<a href="./register.php"><input type="button" class="btn btn-success w-100 mt-5" value="Registrati"> </a>
```
