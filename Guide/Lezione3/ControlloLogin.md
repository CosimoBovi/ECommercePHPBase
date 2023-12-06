# Controllo Login

Per poter gestire il controllo del login e la visaulizzazione dell'utente loggato dobbiamo aggiungere vari elementi al model alla view e al control

# userModel.php

Introdurremo ora una nuova funzione all'interno del nostro modello utente (`userModel.php`) chiamata `testLogin()`. Questa funzione sarà responsabile per controllare se un utente è loggato nell'applicazione. Ecco una spiegazione dettagliata della funzione:

```php
function testLogin(){
    if(isset($_SESSION["username"])){
        return $_SESSION;
    }else{
        return [];
    }
}
```

- `function testLogin()`: Definiamo una nuova funzione chiamata `testLogin`.

- `if(isset($_SESSION["username"]))`: Utilizziamo l'istruzione `if` per verificare se esiste una variabile di sessione chiamata "username." La funzione `isset()` verifica se la variabile di sessione è stata impostata. Se questa variabile esiste, significa che l'utente è loggato.

- `return $_SESSION;`: Se l'utente è loggato (ovvero se la variabile di sessione "username" esiste), restituiamo il valore della variabile di sessione. Questo valore può essere utilizzato nel nostro codice per personalizzare l'esperienza dell'utente loggato.

- `else`: In caso contrario, se la variabile di sessione "username" non esiste, entriamo nell'istruzione `else`.

- `return "";`: Restituiamo un vettore vuoto. Questo significa che se l'utente non è loggato, la funzione restituirà un vettore vuoto.

Questa funzione `testLogin()` sarà utile per verificare lo stato di accesso dell'utente nell'applicazione. Se l'utente è loggato, potremo utilizzare i suoi dati per personalizzare il contenuto o fornire accesso a funzionalità specifiche. Se l'utente non è loggato, la funzione restituirà un vettore vuoto, che può essere utilizzata per identificare che l'utente non è autenticato.


# userControl.php

Introdurremo ora il fatto che nel file `userControl.php` sarà aggiunta una funzione chiamata `testLogin()` per richiamare il modello utente. Questa funzione verrà spiegata in dettaglio di seguito.

```php
if ($Dati["action"] == "userInfo") {
    // Se l'azione è "userInfo," chiama la funzione "testLogin" dal modello utente.
    // Questa funzione controlla se l'utente è loggato e restituisce il risultato.

    $risultato = testLogin();
    echo json_encode($risultato);

}
```

**Spiegazione della funzione `testLogin()` nel file `userControl.php`**:

La funzione `testLogin()` è utilizzata per verificare se un utente è attualmente loggato nell'applicazione. Ecco come funziona:

1. La condizione `if ($Dati["action"] == "userInfo")` verifica se l'azione specificata nei dati inviati corrisponde a "userInfo." Questo è il modo in cui il controllore determina quale operazione deve essere eseguita.

2. Se l'azione è "userInfo," viene chiamata la funzione `testLogin()`.

3. All'interno della funzione, viene verificato se l'utente ha una sessione attiva. 

4. Se l'utente non è loggato (ovvero, la variabile di sessione "username" non è definita), la funzione restituirà un vettore vuoto come risultato.

5. Il risultato ottenuto viene quindi convertito in formato JSON utilizzando `json_encode()` e restituito come risposta HTTP al client.

# Navbar.php

Per permettere all'interfaccia di cambiare a seconda del login dell'utente dobbiamo modificarla come segue:

```html
<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">E-Commerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="collapsibleNavbar">
      <ul class="navbar-nav me-auto" id="LeftNavList">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right" id="RightNavList">
        <!-- Gli elementi del navbar a destra verranno gestiti dinamicamente da navbar.js -->
      </ul>
    </div>
  </div>
</nav>
<script src="./js/navbar.js"></script>
```

Ora spieghiamo ciascun elemento aggiunto:

1. `<script src="./js/navbar.js"></script>`: Questa riga aggiunge un riferimento al file JavaScript `navbar.js`. Questo file contiene il codice JavaScript che gestirà dinamicamente gli elementi del tuo navbar, come ad esempio quelli nel `<ul id="RightNavList">`.

2. `<ul class="navbar-nav me-auto" id="LeftNavList">`: Questo è un elenco non ordinato (`<ul>`) che rappresenta la parte sinistra del tuo navbar. L'aggiunta dell'id "LeftNavList" potrebbe sarà utile per manipolare dinamicamente questo elenco con JavaScript.

3. `<ul class="nav navbar-nav navbar-right" id="RightNavList">`: Questo è un ulteriore elenco non ordinato che rappresenta la parte destra del navbar. Anche questo ha un id, "RightNavList", che suggerisce che verrà gestito dinamicamente nel file JavaScript `navbar.js`.


# Implementazione della Navbar con JavaScript

Ora che abbiamo configurato il nostro backend PHP e definito le funzioni necessarie per la gestione degli utenti, concentreremo la nostra attenzione sul lato frontend. La navbar, elemento essenziale di qualsiasi sito, sarà resa dinamica attraverso l'uso di JavaScript.

```javascript
let user=[];

document.addEventListener("DOMContentLoaded", function() {
    // Al caricamento della pagina, chiamiamo la funzione per visualizzare la navbar.
    visualizzaNavbar();
});

async function visualizzaNavbar(){
    // La funzione visualizzaNavbar si occupa di generare dinamicamente la navbar in base allo stato di login dell'utente.

    // Otteniamo le informazioni sull'utente attraverso la funzione testLogin.
    user = await testLogin();

    // Se l'utente è loggato, generiamo la navbar di benvenuto, altrimenti mostriamo la navbar di login.
    if(user.username!=undefined){
        generaLogout(user.username);
    } else {
        generaLogin();
    }
}

async function testLogin(){
    // La funzione testLogin effettua una richiesta asincrona al server per ottenere le informazioni sull'utente.

    let dati={};
    let ritorno=null;
    dati.action="userInfo";
    url="./Control/userControl.php";

    // Utilizziamo l'API fetch per effettuare la richiesta asincrona.
    let obj = await fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati)
    }).then((response) => response.json())
    .then((data) => {
        // Salviamo i dati nella variabile ritorno.
        ritorno = data;
    });

    return ritorno;
}

function generaLogout(username){
    // La funzione generaLogout crea dinamicamente la navbar quando l'utente è loggato.

    // Creiamo un elemento di benvenuto con il nome utente.
    let newWelcomeLi = document.createElement("li");
    newWelcomeLi.classList.add("nav-item");
    let newSpan = document.createElement("span");
    newSpan.classList.add("nav-link");
    newSpan.innerText="Benvenuto " + username;

    newWelcomeLi.appendChild(newSpan);

    // Aggiungiamo l'elemento di benvenuto alla navbar.
    document.getElementById("RightNavList").appendChild(newWelcomeLi);

    // Creiamo un elemento per il logout.
    let newLogoutLi = document.createElement("li");
    newLogoutLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href="./Control/userControl.php?logout=logout";
    newA.innerText="Logout";

    newLogoutLi.appendChild(newA);

    // Aggiungiamo l'elemento di logout alla navbar.
    document.getElementById("RightNavList").appendChild(newLogoutLi);
}


function generaLogin(){

    // Creazione di un nuovo elemento <li> per il link di login
    let newLoginLi = document.createElement("li");
    newLoginLi.classList.add("nav-item");

    // Creazione di un nuovo elemento <a> per il link di login
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href="./login.php";
    newA.innerText="Entra";

    // Aggiunta del link di login al nuovo elemento <li>
    newLoginLi.appendChild(newA);

    // Aggiunta del nuovo elemento <li> al menu di navigazione destro
    document.getElementById("RightNavList").appendChild(newLoginLi);
}
```

A titolo di esempio di seguito è mostrata la spiegazione dettagliata per la creazione del logout, le altre sezioni sono tutte molto simili:

1. **`let newLogoutLi = document.createElement("li");`**: Creazione di un nuovo elemento `<li>` (list item) che conterrà il link di logout nella barra di navigazione.

2. **`newLogoutLi.classList.add("nav-item");`**: Aggiunta della classe "nav-item" all'elemento `<li>`. Questa classe è spesso utilizzata nelle barre di navigazione Bootstrap per garantire uno stile uniforme.

3. **`let newA = document.createElement("a");`**: Creazione di un nuovo elemento `<a>` (link) all'interno dell'elemento `<li>`, che costituirà il link di logout.

4. **`newA.classList.add("nav-link");`**: Aggiunta della classe "nav-link" al link di logout. Questa classe è utilizzata per formattare correttamente i link all'interno della barra di navigazione.

5. **`newA.href="./Control/userControl.php?logout=logout";`**: Impostazione dell'attributo "href" del link di logout con l'URL corretto per gestire il logout. Quando l'utente fa clic sul link, verrà reindirizzato alla pagina di gestione del logout. L'indirizzo "./Control/userControl.php?logout=logout"; imposta l'URL del link di logout dando anche un parametro *logout=logout* che fornisce al server PHP l'informazione necessaria per gestire la richiesta di logout quando il link viene cliccato. La gestione avviene attraverso il vettore associativo $_GET in PHP, permettendo al server di identificare e eseguire le azioni di logout richieste.

6. **`newA.innerText="Logout";`**: Impostazione del testo visibile nel link di logout come "Logout". Questo è il testo che l'utente vedrà nella barra di navigazione.

7. La riga `newLogoutLi.appendChild(newA);` aggiunge l'elemento `<a>` (il link di logout) come figlio dell'elemento `<li>` appena creato. In altre parole, sta inserendo il link di logout all'interno del tag `<li>`, rendendolo parte del contenuto di quest'ultimo.


# Aggiunta Logout nel file userControl.php

Nel file `userControl.php`, sarà implementato un codice dedicato alla gestione del logout dell'utente. Questo codice è essenziale per garantire una corretta terminazione della sessione quando un utente decide di effettuare il logout dal sistema.

```php
if(isset($_GET["logout"])){
    session_start();
    session_destroy();
    header('location: ../index.php?logout');
    exit();
}
```

1. **`if(isset($_GET["logout"]))`**: Verifica se il parametro "logout" è presente nella richiesta GET. Questo parametro sarà incluso quando l'utente sceglie di effettuare il logout.

2. **`session_start()`**: Inizia o riprende la sessione esistente.

3. **`session_destroy()`**: Distrugge tutti i dati registrati in una sessione. Questo passo è fondamentale per garantire la corretta terminazione della sessione dell'utente.

4. **`header('location: ../index.php?logout')`**: Reindirizza l'utente alla pagina principale (`index.php`) con un parametro aggiuntivo "logout" nell'URL. Questo parametro può essere utilizzato per fornire un feedback all'utente sul successo del logout.

5. **`exit()`**: Termina l'esecuzione dello script PHP dopo aver effettuato il reindirizzamento. Questo previene l'esecuzione di ulteriori istruzioni che potrebbero influenzare il comportamento della pagina dopo il logout.

### **Utilizzo della Funzione di Logout**

Per attivare la funzione di logout, l'utente può accedere a `userControl.php` includendo il parametro `logout` nella richiesta GET. Ad esempio:

```
./Control/userControl.php?logout=logout
```

Questa implementazione assicura che l'utente venga disconnesso correttamente dal sistema, terminando la sessione e reindirizzandolo a `index.php` con l'indicazione che il logout è avvenuto con successo.
