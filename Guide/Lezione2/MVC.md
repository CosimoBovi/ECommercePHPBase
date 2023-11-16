# MVC

Per la creazione di questo sito web, adotteremo il modello MVC (Model-View-Controller). Il modello MVC è un'architettura che suddivide un'applicazione in tre componenti principali:

 **Modello (Model):** Questa componente gestisce i dati e modella la realtà nella nostra applicazione. Nel nostro caso, useremo il model per connetterci al database al fine di estrarre e inserire i dati nella nostra base di dati, che rappresenterà gli elementi dell'e-commerce.

2. **Vista (View):** La Vista è responsabile della presentazione dei dati agli utenti. Nel contesto del nostro sito, la Vista comprende le pagine PHP che costituiscono l'aspetto visuale, come "header.php," "navbar.php," e "footer.php." Solitamente, la view è composta solo da HTML, CSS e JS al fine di rendere il sito scalabile. Tuttavia, in questa guida, abbiamo scelto di utilizzare PHP e l'uso di `include` per semplicità e per introdurre le potenzialità del PHP.

3. **Controller (Controller):** Il Controller funge da intermediario tra le richieste degli utenti e il Modello e la Vista. Nel nostro caso, lo utilizzeremo per indirizzare correttamente le richieste provenienti dalla view alle funzionalità del model e per prelevare i dati dal model e inviarli correttamente alla view.


L'adozione del modello MVC aiuta a separare in modo chiaro la gestione dei dati, la logica di presentazione e il controllo delle interazioni degli utenti all'interno dell'applicazione. Questa suddivisione migliora l'organizzazione del codice, ne facilita la manutenzione e la scalabilità, semplifica lo sviluppo del sito web e agevola la collaborazione in un team di sviluppo. Inoltre, il modello MVC è un approccio comune nel mondo dello sviluppo web e promuove buone pratiche di programmazione.

# Struttura del progetto

Il progetto realtivo a questa guida è organizzato in una struttura di cartelle che contribuisce a mantenere il codice e i file ben organizzati. Ecco come è strutturato il progetto:

- La **cartella principale( HTDOCS )** contiene i file chiave del sito web, tra cui "index.php," "navbar.php," e altri file principali che costituiscono le pagine visibili del sito.

- All'interno della cartella principale, troverai anche una serie di sottocartelle, ognuna con un ruolo specifico:

    - **img**: Questa cartella contiene le immagini e le risorse multimediali utilizzate nel sito, come loghi, immagini dei prodotti e altri file multimediali.

    - **controller**: La cartella "controller" ospita i file che contengono la logica di controllo dell'applicazione.

    - **model**: La cartella "model" contiene i file che rappresentano il modello dei dati dell'applicazione. 

    - **js**: La cartella "js" è dedicata a file JavaScript.

Questa organizzazione a cartelle contribuisce a mantenere il progetto pulito, ordinato e facilmente gestibile, garantendo che ogni componente del sito web sia al suo posto e ben strutturata.

![Struttura Progetto MVC](StrutturaProgettoMVC.png)

# MODEL (userModel.php)

`userModel.php` è un componente chiave del Modello, e il suo scopo principale è gestire gli utenti. Questo file contiene tra le altre funzioni anche quella per la verifica delle credenziali degli utenti quando cercano di accedere al sito. La funzione `login` è un esempio di come questo processo di autenticazione potrebbe essere implementato all'interno del Modello.

```php

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

```

Ecco una spiegazione step-by-step che tiene conto del fatto che la spiegazione è rivolta a persone che stanno apprendendo PHP per la prima volta:

1. `<?php`: Questo è il tag di apertura PHP e indica l'inizio di un blocco di codice PHP.

2. `session_start();`: Questa istruzione inizializza una sessione. Le sessioni sono una caratteristica di PHP che consente di memorizzare dati tra le pagine web.

3. La funzione `login($user, $pass)`: Questa è una funzione personalizzata che prende due parametri, `$user` e `$pass`, che rappresentano l'username e la password inseriti dall'utente.

4. All'interno della funzione, c'è un blocco condizionale (`if-else`):
   - L'istruzione `if` verifica se l'username e la password sono uguali a "username" e "password". Nota che questa è una simulazione semplificata. In un'applicazione reale, questa parte verrà sostituita da una query al database per verificare le credenziali dell'utente.
   - Se le credenziali sono corrette, viene impostata una variabile di sessione chiamata "username" con il valore dell'username dell'utente (`$_SESSION["username"] = $user;`). Questo `$user` rappresenta l'username fornito come argomento alla funzione.
   - Viene quindi ritornato "0" per indicare che l'accesso è riuscito.
   - Se le credenziali non sono corrette, viene ritornato "1" per indicare che l'accesso è fallito.

5. `?>`: Questo è il tag di chiusura PHP e indica la fine del blocco di codice PHP.

---

**Nota di Approfondimento:**

- Il simbolo `$` in PHP è utilizzato per definire e accedere alle variabili. In questo caso, `$user` è una variabile locale che rappresenta l'username passato come argomento alla funzione `login`.

- `$_SESSION["username"]` è una variabile di sessione in PHP. Le variabili di sessione sono utilizzate per memorizzare dati che devono persistere tra diverse pagine web o richieste. In questo caso, stiamo impostando la variabile di sessione "username" con il valore dell'username dell'utente. Questa variabile può essere utilizzata in altre parti dell'applicazione per verificare l'accesso dell'utente o per personalizzare l'esperienza utente in base all'username. È un esempio di vettore associativo, cioè di un vettore che ha come indici non dei numeri ma delle chiavi solitamente testuali. In questo caso "username" è la chiave e `$user` è il valore associato a quella chiave.



# CONTRL (userControl.php)

 Il file userControl.php rappresenta un esempio di un "controller" all'interno di un'applicazione web, facendo da smistamento tra l'interfaccia e il model

```php
<?php
    // Includi il file del modello utente (userModel.php).
    require_once "../Model/userModel.php";

    // Leggi i dati inviati dalla richiesta HTTP (in formato JSON) e convertili in un array associativo.
    $Dati = json_decode(file_get_contents('php://input'), true);

    // Verifica l'azione specificata nei dati.
    if ($Dati["action"] == "login") {
        // Se l'azione è "login," chiama la funzione "login" dal modello utente con l'username e la password forniti.
        
        $errore = login($Dati["username"], $Dati["password"]);
        echo json_encode(['errore'=>$errore]);
    }
?>
```

**Spiegazione del Codice in userControl.php:**

1. `require_once "../Model/userModel.php";`: Questa istruzione importa (include) il file `userModel.php` dal percorso specificato. Il file `userModel.php` contiene le funzioni per la gestione dell'utente, inclusa la funzione `login`. Questo passaggio è importante perché ci consente di utilizzare le funzioni definite nel modello utente in questo script.

2. `$Dati = json_decode(file_get_contents('php://input'), true);`: Questa istruzione legge i dati inviati nella richiesta HTTP in formato JSON. I dati vengono letti da `php://input`, che rappresenta il corpo della richiesta. Successivamente, `json_decode` converte questi dati JSON in un array associativo PHP e li memorizza nella variabile `$Dati`. Questi dati possono includere l'azione specificata, l'username e la password.

3. `if ($Dati["action"] == "login") { ... }`: Questo blocco condizionale verifica se l'azione specificata nei dati è uguale a "login". Se l'azione è "login," il blocco di codice all'interno delle parentesi graffe verrà eseguito.

4. `$errore = login($Dati["username"], $Dati["password"]);`: Se l'azione è "login," viene chiamata la funzione `login` definita nel modello utente con l'username e la password forniti. La funzione `login` può restituire 0 se l'accesso è riuscito o 1 se l'accesso è fallito. Il risultato viene memorizzato nella variabile `$errore`.

5. `echo json_encode(['errore'=>$errore]);`: La risposta viene formattata come un oggetto JSON contenente il risultato dell'operazione di login. Questo oggetto JSON include una chiave chiamata 'errore' che contiene il valore restituito dalla funzione `login`, che può essere 0 se l'accesso è riuscito o 1 se l'accesso è fallito.

In sintesi, questo script PHP riceve una richiesta HTTP contenente dati in formato JSON, verifica l'azione specificata nei dati, e se l'azione è "login," chiama la funzione di login del modello utente con l'username e la password forniti. Il risultato della funzione di login viene quindi restituito come risposta HTTP, formattato in JSON, che può essere utilizzato per determinare se l'accesso è riuscito o fallito. Questo è un esempio semplice di come il modello, il controllore e i dati interagiscono all'interno di un'applicazione.

---

**Approfondimento: L'Importanza dei JSON**

**JSON (JavaScript Object Notation):** JSON è un formato di scambio dati leggero, indipendente dal linguaggio, che viene ampiamente utilizzato per rappresentare dati strutturati. I dati in formato JSON sono rappresentati come coppie di chiavi-valore e sono facili da leggere e scrivere sia per le macchine che per gli esseri umani.

**Perché JSON è Importante:**

1. **Interoperabilità:** JSON facilita l'interscambio di dati tra diverse applicazioni e sistemi. È un formato standardizzato e ampiamente supportato, il che significa che le informazioni possono essere condivise tra diversi componenti del software senza problemi di compatibilità.

2. **Lettura e Scrittura Facili:** La struttura dei dati JSON è chiara e ben organizzata. Questo lo rende facilmente comprensibile sia per gli sviluppatori che per i sistemi informatici. La leggibilità è un vantaggio significativo quando si tratta di debug e sviluppo.

3. **Rappresentazione dei Dati Strutturati:** JSON è adatto per la rappresentazione di dati strutturati come elenchi, oggetti annidati e array. Questa flessibilità lo rende adatto per una vasta gamma di applicazioni, dall'elaborazione di dati API REST all'archiviazione di configurazioni.

In sintesi, JSON è uno strumento essenziale per lo scambio di dati tra applicazioni e sistemi diversi. La sua semplicità, leggibilità e versatilità lo rendono un'opzione ideale per rappresentare dati strutturati in molte situazioni, inclusi servizi Web, applicazioni mobili, configurazioni di applicazioni e molto altro.


# VIEW(login.php)

Nell'ambito dello sviluppo web, una "vista" rappresenta l'aspetto visuale di un'applicazione web, ovvero ciò che gli utenti vedono e con cui interagiscono. La pagina login.php è un esempio di vista all'interno di un'applicazione web che gestisce il processo di accesso degli utenti.

```php
   <?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>

    <script src="./js/login.js"></script>

    <div class="row w-100">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <form>
                <label class="w-25">username: </label> <input type="text" id="user" class="w-100 my-2"> 
                <label class="w-25">password: </label> <input type="password" id="pass" class="w-100 my-2"> 
                <input type="button" class="btn btn-success w-100 mt-5" onclick="login()" value="Entra">  
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>

    <?php include_once 'footer.php' ?>
```

1. `<?php include_once 'header.php' ?>` e `<?php include_once 'navbar.php' ?>`: Queste istruzioni includono il codice HTML dei file `header.php` e `navbar.php`. 

2. `<script src="./js/login.js"></script>`: Questa riga importa il file JavaScript `login.js`. Questo file JavaScript è responsabile dell'interazione dinamica con la pagina e verrà spiegato separatamente.

3. `<div class="row w-100">`: Questo `<div>` rappresenta una riga (row) in un layout Bootstrap. La classe `w-100` è utilizzata per garantire che il div occupi l'intera larghezza disponibile.

4. `<div class="col-md-3"></div>`: Questi due `<div>` rappresentano colonne (columns) vuote con una larghezza di 3 unità su 12. Questo viene utilizzato per creare spazi vuoti ai lati della sezione centrale.

5. `<div class="col-md-6 justify-content-center">`: Questo `<div>` rappresenta una colonna centrale con una larghezza di 6 unità su 12, occupando quindi metà della larghezza disponibile. La classe `justify-content-center` è utilizzata per centrare il contenuto orizzontalmente all'interno della colonna.

6. `<form>`: Questo elemento rappresenta un modulo HTML che gli utenti possono utilizzare per inserire dati, in questo caso, username e password.

7. `<label class="w-25">username: </label>` e `<input type="text" id="user" class="w-100 my-2">`: Queste righe rappresentano un campo per l'username. Il tag `<label>` fornisce una descrizione "username" per il campo di input, e l'elemento `<input>` con `type="text"` consente agli utenti di inserire il loro username. La classe `w-25` è utilizzata per definire una larghezza fissa del 25% per il label, mentre `w-100` definisce una larghezza del 100% per l'input. La classe `my-2` applica un margine superiore e inferiore al campo di input.

8. `<label class="w-25">password: </label>` e `<input type="password" id="pass" class="w-100 my-2">`: Queste righe rappresentano un campo per la password. Funzionano in modo simile a quanto spiegato per l'username, ma con il tipo di input `password` per nascondere i caratteri della password.

9. `<input type="button" class="btn btn-success w-100 mt-5" onclick="login()" value="Entra">`: Questa riga rappresenta un pulsante che gli utenti possono fare clic per avviare il processo di login. La classe `btn` è utilizzata per stili di pulsante Bootstrap, `btn-success` definisce uno stile di pulsante verde, `w-100` imposta la larghezza al 100%, e `mt-5` aggiunge un margine superiore al pulsante. L'attributo `onclick` chiama la funzione JavaScript `login()` quando il pulsante viene premuto.

10. `</form>`: Questo tag chiude il modulo del form.

11. `<div class="col-md-3"></div>`: Questo `<div>` rappresenta un'altra colonna vuota alla destra del modulo di login.

12. `<?php include_once 'footer.php' ?>`: Questa istruzione include il codice HTML dal file `footer.php`.

La pagina `login.php` fornisce una forma per l'inserimento di username e password e un pulsante per avviare il processo di login. La logica di gestione del login, inclusi i dettagli relativi al JavaScript, verrà spiegata separatamente una volta fornito il file JavaScript `login.js`.


# VIEW(login.js)

```js
async function login() {
    // Creiamo un oggetto 'dati' per raccogliere le informazioni dell'utente.
    let dati = {};
    dati.username = document.getElementById("user").value; // Otteniamo il valore dell'input per l'username.
    dati.password = document.getElementById("pass").value; // Otteniamo il valore dell'input per la password.
    dati.action = "login"; // Specifica l'azione da eseguire, in questo caso, "login".

    // Definiamo l'URL a cui invieremo la richiesta.
    let url = "./Control/userControl.php";

    // Usiamo l'API 'fetch' per effettuare una richiesta HTTP asincrona.
    // Questo è un modo per comunicare con il server senza dover ricaricare l'intera pagina.
    let obj = fetch(url, {
        method: "POST", // Specifichiamo il metodo HTTP come "POST".
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati) // Convertiamo l'oggetto 'dati' in formato JSON e lo includiamo nel corpo della richiesta.
    })
    .then((response) => response.json()) // Riceviamo la risposta JSON dal server.
    .then((data) => {
        // Verifichiamo se l'utente ha inserito credenziali corrette.
        if (data.errore == 0) {
            location.href = "index.php"; // Reindirizziamo l'utente a "index.php".
        } else {
            alert("Nome utente o password errati"); // Mostriamo un messaggio di errore se le credenziali sono errate.
        }
    });
}
```

**Spiegazione del Codice JavaScript:**

1. La funzione `async function login()` definisce una funzione JavaScript chiamata `login`. Questa funzione verrà chiamata quando l'utente preme il pulsante "Entra" nella vista `login.php`.

2. Creiamo un oggetto chiamato `dati` per raccogliere le informazioni inserite dall'utente, come l'username e la password.

3. Utilizziamo `document.getElementById("user").value` e `document.getElementById("pass").value` per ottenere i valori inseriti negli input dei campi username e password.

4. Specificare `dati.action = "login"` indica che l'azione da eseguire è il "login."

5. Definiamo l'URL a cui invieremo la richiesta. In questo caso, stiamo inviando una richiesta POST all'URL `./Control/userControl.php`.

6. Utilizziamo l'API `fetch` per effettuare una richiesta HTTP asincrona al server. Questo consente di inviare dati al server senza dover ricaricare l'intera pagina.

7. Configuriamo la richiesta includendo il metodo HTTP come "POST" e specificando i tipi di intestazioni accettati.

8. Nel corpo della richiesta, convertiamo l'oggetto `dati` in formato JSON utilizzando `JSON.stringify(dati)` e lo inviamo al server.

9. Riceviamo la risposta dal server, che è in formato JSON.

10. Verifichiamo se la risposta contiene un `errore` uguale a 0. Se è così, reindirizziamo l'utente a "index.php," presumibilmente dopo un login riuscito. Altrimenti, mostriamo un messaggio di errore con `alert` se le credenziali sono errate.

In sintesi, il codice JavaScript `login.js` gestisce la comunicazione tra la vista `login.php` e il server, consentendo all'utente di inserire le proprie credenziali e ottenere una risposta dal server in modo asincrono.

---

### Approfondimento su Chiamate Asincrone e Concetto di Asincronia:

Le chiamate asincrone e il concetto di asincronia sono fondamentali nello sviluppo web moderno. Ecco un approfondimento su questi concetti:

- **Asincronia:** In programmazione, il termine "asincrono" si riferisce a operazioni che non avvengono in modo sincrono o sequenziale. Invece, le operazioni asincrone possono avvenire in parallelo o in un secondo momento, senza attendere che l'operazione precedente sia completata. Questo è particolarmente utile quando si affrontano operazioni che richiedono tempo, come le richieste di rete o le operazioni di I/O.

- **Chiamate Asincrone:** Le chiamate asincrone sono comunemente utilizzate nelle applicazioni web per inviare richieste al server senza bloccare l'interfaccia utente dell'applicazione. Quando un'applicazione effettua una chiamata asincrona, questa invia una richiesta al server e continua ad eseguire altre operazioni senza attendere la risposta del server. Una volta che il server ha completato l'elaborazione della richiesta, invia una risposta, e l'applicazione riceve e gestisce la risposta in un secondo momento.

- **.then:** In JavaScript, il metodo `.then` è utilizzato per gestire promesse. Una promessa rappresenta un valore che potrebbe non essere disponibile immediatamente ma in futuro. Le chiamate asincrone restituiscono spesso promesse. Quando una promessa si risolve (quando i dati sono pronti), il metodo `.then` consente di specificare cosa fare con i dati o come gestire eventuali errori. Ad esempio, nel codice `fetch`, `.then` viene utilizzato per gestire la risposta del server una volta che è stata ricevuta.

- **Async/Await:** JavaScript offre anche le parole chiave `async` e `await` per semplificare la gestione delle chiamate asincrone. Utilizzando `async` prima di una funzione, la funzione diventa asincrona e può utilizzare l'operatore `await` all'interno di essa. L'operatore `await` attende che una promessa venga risolta e restituisce il risultato. Questo semplifica la gestione del flusso di controllo asincrono e rende il codice più leggibile.

In sintesi, le chiamate asincrone sono fondamentali per garantire che un'applicazione web possa comunicare con un server in modo efficiente, senza bloccare l'interfaccia utente e senza dover attendere risposte immediate. L'uso di `.then`, promesse, `async` e `await` consente di scrivere codice che gestisce le operazioni asincrone in modo chiaro e organizzato, migliorando l'esperienza dell'utente e l'efficienza delle applicazioni web.
