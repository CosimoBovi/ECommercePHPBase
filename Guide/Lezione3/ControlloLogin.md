# Controllo Login

Per poter gestire il controllo del login e la visaulizzazione dell'utente loggato dobbiamo aggiungere vari elementi al model alla view e al control

# userModel.php

Introdurremo ora una nuova funzione all'interno del nostro modello utente (`userModel.php`) chiamata `testLogin()`. Questa funzione sarà responsabile per controllare se un utente è loggato nell'applicazione. Ecco una spiegazione dettagliata della funzione:

```php
function testLogin(){
    if(isset($_SESSION["username"])){
        return $_SESSION["username"];
    }else{
        return "";
    }
}
```

- `function testLogin()`: Definiamo una nuova funzione chiamata `testLogin`.

- `if(isset($_SESSION["username"]))`: Utilizziamo l'istruzione `if` per verificare se esiste una variabile di sessione chiamata "username." La funzione `isset()` verifica se la variabile di sessione è stata impostata. Se questa variabile esiste, significa che l'utente è loggato.

- `return $_SESSION["username"];`: Se l'utente è loggato (ovvero se la variabile di sessione "username" esiste), restituiamo il valore di questa variabile, che rappresenta l'username dell'utente. Questo valore può essere utilizzato nel nostro codice per personalizzare l'esperienza dell'utente loggato.

- `else`: In caso contrario, se la variabile di sessione "username" non esiste, entriamo nell'istruzione `else`.

- `return "";`: Restituiamo una stringa vuota. Questo significa che se l'utente non è loggato, la funzione restituirà una stringa vuota.

Questa funzione `testLogin()` sarà utile per verificare lo stato di accesso dell'utente nell'applicazione. Se l'utente è loggato, potremo utilizzare il suo username per personalizzare il contenuto o fornire accesso a funzionalità specifiche. Se l'utente non è loggato, la funzione restituirà una stringa vuota, che può essere utilizzata per identificare che l'utente non è autenticato.


# userControl.php

Introdurremo ora il fatto che nel file `userControl.php` sarà aggiunta una funzione chiamata `testLogin()` per richiamare il modello utente. Questa funzione verrà spiegata in dettaglio di seguito.

```php
if ($Dati["action"] == "userInfo") {
    // Se l'azione è "userInfo," chiama la funzione "testLogin" dal modello utente.
    // Questa funzione controlla se l'utente è loggato e restituisce il risultato.

    $risultato = testLogin();
    echo json_encode(['username'=>$risultato]);

}
```

**Spiegazione della funzione `testLogin()` nel file `userControl.php`**:

La funzione `testLogin()` è utilizzata per verificare se un utente è attualmente loggato nell'applicazione. Ecco come funziona:

1. La condizione `if ($Dati["action"] == "userInfo")` verifica se l'azione specificata nei dati inviati corrisponde a "userInfo." Questo è il modo in cui il controllore determina quale operazione deve essere eseguita.

2. Se l'azione è "userInfo," viene chiamata la funzione `testLogin()`.

3. All'interno della funzione, viene verificato se l'utente ha una sessione attiva. La funzione `isset($_SESSION["username"])` controlla se la variabile di sessione "username" è definita. Se lo è, significa che l'utente è loggato, e il suo username viene restituito come risultato.

4. Se l'utente non è loggato (ovvero, la variabile di sessione "username" non è definita), la funzione restituirà una stringa vuota come risultato.

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
document.addEventListener("DOMContentLoaded", function() {
    // Al caricamento della pagina, chiamiamo la funzione per visualizzare la navbar.
    visualizzaNavbar();
});

async function visualizzaNavbar(){
    // La funzione visualizzaNavbar si occupa di generare dinamicamente la navbar in base allo stato di login dell'utente.

    // Otteniamo le informazioni sull'utente attraverso la funzione testLogin.
    user = await testLogin();

    // Se l'utente è loggato, generiamo la navbar di benvenuto, altrimenti mostriamo la navbar di login.
    if(user.username != ''){
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
```

---

## Spiegazione dettagliata Navbar.JS

#### **1. Evento "DOMContentLoaded"**

```javascript
document.addEventListener("DOMContentLoaded", function() {
    visualizzaNavbar();
});
```

Al caricamento della pagina (`DOMContentLoaded`), viene chiamata la funzione `visualizzaNavbar()`. Questo assicura che la navbar sia generata dinamicamente non appena la pagina è completamente caricata.

#### **2. Funzione `visualizzaNavbar()`**

```javascript
async function visualizzaNavbar(){
    user = await testLogin();

    if(user.username != ''){
        generaLogout(user.username);
    } else {
        generaLogin();
    }
}
```

La funzione `visualizzaNavbar()` è responsabile della generazione dinamica della navbar. Innanzitutto, ottiene le informazioni sull'utente chiamando la funzione asincrona `testLogin()`. Se l'utente è loggato, viene generata la navbar di benvenuto attraverso `generaLogout()`, altrimenti viene mostrata la navbar di login attraverso `generaLogin()`.

#### **3. Funzione `testLogin()`**

```javascript
async function testLogin(){
    let dati = {};
    let ritorno = null;
    dati.action = "userInfo";
    url = "./Control/userControl.php";

    let obj = await fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati)
    }).then((response) => response.json())
    .then((data) => {
        ritorno = data;
    });

    return ritorno;
}
```

La funzione `testLogin()` effettua una richiesta asincrona al server per ottenere le informazioni sull'utente. Utilizza l'API `fetch` per inviare una richiesta POST al server. Le informazioni ottenute vengono restituite sotto forma di oggetto JSON.

#### **4. Funzione `generaLogout(username)`**

```javascript
function generaLogout(username){
    let newWelcomeLi = document.createElement("li");
    newWelcomeLi.classList.add("nav-item");
    let newSpan = document.createElement("span");
    newSpan.classList.add("nav-link");
    newSpan.innerText = "Benvenuto " + username;

    newWelcomeLi.appendChild(newSpan);

    document.getElementById("RightNavList").appendChild(newWelcomeLi);

    let newLogoutLi = document.createElement("li");
    newLogoutLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href = "./Control/userControl.php?logout=logout";
    newA.innerText = "Logout";

    newLogoutLi.appendChild(newA);
    document.getElementById("RightNavList").appendChild(newLogoutLi);
}
```

La funzione `generaLogout(username)` crea dinamicamente la navbar quando l'utente è loggato. Aggiunge un elemento di benvenuto e un elemento per il logout alla navbar.
