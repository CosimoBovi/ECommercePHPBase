# Aggiunta dei prodotti

Ora che abbiamo la possibilità di gestire gli utenti concentriamoci sulla gestione dei prodotti. In questa guida seguiremo tutta la parte di progettazione della tabella prodotti nel database, fino ad arrivare alla possibilità per un venditore di inserire il proprio prodotto.

# Progettazione tabella prodotti

Per la tabella prodotti seguiremo questo modello logico

```
Products(ProductID, Name, Description, UnitPrice, ImageLink, UserSellerID)
```

Dove UserSellerID sarà chiave esterna della tabella Users, e definirà il venditore che ha inserito quel prodotto.

La create table relativa sarà la seguente

```sql
CREATE TABLE Products (
    ProductID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Description TEXT,
    UnitPrice DECIMAL(10, 2) NOT NULL,
    ImageLink VARCHAR(255),
    UserSellerID INT NOT NULL,
    FOREIGN KEY (UserSellerID) REFERENCES Users(UserID)
);
```

Ecco una spiegazione dettagliata dei campi della query fornita:

- `ProductID`: È un campo di tipo `INT` che funge da chiave primaria (`PRIMARY KEY`) e viene incrementato automaticamente (`AUTO_INCREMENT`) ogni volta che viene inserito un nuovo record nella tabella. Garantisce un identificatore unico per ogni prodotto.
- `Name`: È un campo di tipo `VARCHAR(100)` che memorizza il nome del prodotto. Viene impostato come `NOT NULL` per garantire che sia sempre presente un valore.
- `Description`: È un campo di tipo `TEXT` che può contenere una descrizione più lunga del prodotto.
- `UnitPrice`: È un campo di tipo `DECIMAL(10, 2)` che memorizza il prezzo del prodotto, limitato a 10 cifre totali di cui 2 dopo la virgola. Viene impostato come `NOT NULL` per garantire che sia sempre presente un valore.
- `ImageLink`: È un campo di tipo `VARCHAR(255)` che contiene il percorso dell'immagine del prodotto.
- `UserSellerID`: È un campo di tipo `INT` che funge da chiave esterna (`FOREIGN KEY`) e fa riferimento alla colonna `UserID` della tabella `Users`. Indica l'utente venditore associato a questo prodotto ed è impostato come `NOT NULL` per garantire l'integrità dei dati.

# productModel.php

Creaiamo ora il file productModel.php **all'interno della cartella che contiene i Model** e iniziamo scrivendo la funzione per inserire un nuovo prodotto.

```php
<?php

function insertProduct($name, $description, $unitPrice, $userSellerID) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Imposta il link dell'immagine inizialmente a NULL
        $imageLink = null;

        // Query per l'inserimento del prodotto
        $sql = "INSERT INTO Products (Name, Description, UnitPrice, ImageLink, UserSellerID) VALUES (:name, :description, :unitPrice, :imageLink, :userSellerID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':unitPrice', $unitPrice);
        $stmt->bindParam(':imageLink', $imageLink);
        $stmt->bindParam(':userSellerID', $userSellerID);

        $stmt->execute();

        return 0; // Ritorna 0 se l'inserimento è avvenuto con successo
    } catch(PDOException $e) {
       
        return 1; // Errore generico

    }
}

?>
```

Questa funzione `insertProduct` prende in input i dettagli del prodotto e tenta di inserirli nella tabella `Products` del database. La struttura è molto simile a quella della funzione `insertUser` per l'inserimento dell'utente, ma adattata per i dettagli specifici del prodotto, come il nome, la descrizione, il prezzo, il link dell'immagine e l'ID del venditore. Se l'inserimento ha successo, la funzione restituisce `0`, altrimenti restituirà un codice di errore appropriato (ad esempio `1` per un errore generico, `2` per chiave duplicata). Per ora impostiamo il link dell'immagine a null, con lo scopo di aggiungere un'immagine al prodotto solo in seguito.

# productControl.php

Come avevamo fatto precedentemente con gli utenti, creeremo anche un Control per i prodotti **all'interno della cartella Control** , che gestirà le richieste provenienti dalla View e le indirizzerà al Model. Il control per i prodotti sarà molto simile a quello per gli utenti e consisterà in una serie di if che determineranno l'azione da compiere.

```php
<?php

// Includi il file del modello prodotto (productModel.php).
require_once "../Model/productModel.php";

// Leggi i dati inviati dalla richiesta HTTP (in formato JSON) e convertili in un array associativo.
$Dati = json_decode(file_get_contents('php://input'), true);

// Per utilizzare le variabili di sessione usiamo session_start() 
session_start();

if ($Dati["action"] == "insertProduct") {
    // Controlla se l'azione richiesta è l'inserimento di un nuovo prodotto
    
    // Verifica se l'utente è loggato e se è un venditore (UsertypeID 2)
    if(isset($_SESSION["userID"]) && isset($_SESSION["usertypeID"]) && $_SESSION["usertypeID"] == 2){
        // Se l'utente è loggato come venditore, raccogli i dati del nuovo prodotto
        $name = $Dati["name"];
        $description = $Dati["description"];
        $unitPrice = $Dati["unitPrice"];
        
        // Ottieni l'ID dell'utente venditore dalla sessione
        $userSellerID = $_SESSION["userID"];
        
        // Chiamata alla funzione per l'inserimento del prodotto con i dati forniti
        $insertionStatus = insertProduct($name, $description, $unitPrice, $userSellerID);
        
        // Restituisci lo stato dell'inserimento come risposta JSON
        echo json_encode(['insertionStatus' => $insertionStatus]);
    } else {
        Se l'utente non è loggato come venditore, restituisci un codice di errore (9)
        echo json_encode(['insertionStatus' => 9]);
        
    }
}

?>
```

La parte iniziale permette di connetterci al Model e recuperare i dati dalla view come avevamo fatto per gli utenti. Il resto del codice è spiegato in seguito:

1. **Controllo dell'azione richiesta:** Inizia controllando se l'azione richiesta è quella di inserire un nuovo prodotto nel sistema. Questo passaggio è identificato tramite la condizione `if ($Dati["action"] == "insertProduct")`.

2. **Verifica dell'autenticazione:** Successivamente, verifica se l'utente è autenticato attraverso la sessione attiva. Questo controllo avviene con `isset($_SESSION["userID"])`, assicurandosi che l'ID dell'utente sia stato memorizzato nella sessione.

3. **Controllo del tipo di utente:** Verifica se il tipo di utente corrisponde a un venditore. Controlla la variabile `$_SESSION["usertypeID"]`, garantendo che sia impostata correttamente e corrisponda all'ID associato ai venditori (in questo caso, UsertypeID 2).

4. **Acquisizione dei dati del prodotto:** Se l'utente supera con successo i controlli di autenticazione e tipologia, acquisisce i dati relativi al nuovo prodotto che si desidera inserire. Questi dati includono nome, descrizione, prezzo unitario e link all'immagine del prodotto.
   
5. **Associazione del venditore al prodotto:** Viene assegnato l'ID del venditore, memorizzato nella sessione come `$_SESSION["userID"]`, alla variabile `$userSellerID`. Questo collegamento permette di associare correttamente il prodotto al venditore autenticato prima dell'inserimento nel database.

6. **Esecuzione dell'inserimento:** Una volta ottenuti tutti i dati necessari, chiama la funzione `insertProduct` nel modello dei prodotti, passando i dati ottenuti come argomenti per aggiungere il nuovo prodotto al database.

7. **Risposta in base all'autenticazione:** Se l'utente non supera con successo i controlli di autenticazione o tipologia, il controllo restituirà un codice di errore specifico (9). Ciò indica che l'utente non è autorizzato a eseguire l'azione di inserimento del prodotto.

Questa struttura di controllo garantisce che solo venditori autenticati e autorizzati possano aggiungere nuovi prodotti al database, contribuendo alla sicurezza e all'integrità del sistema di gestione dei prodotti.

# View insertProduct.php

Passiamo ora alla view, come sempre ci concentreremo prima sul form per poi passare al js. **Ricordiamo che la view va creata direttamente nalla cartella principale e non in sottocartelle**

```php
    <?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>
    
    <script src="./js/insertProduct.js"></script>
    
    <div class="row w-100">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <form id="productForm">
                <label class="w-25">Nome: </label>
                <input type="text" id="productName" class="form-control w-100 my-2">
                
                <label class="w-25">Descrizione: </label>
                <textarea id="productDescription" class="form-control w-100 my-2"></textarea>
                
                <label class="w-25">Prezzo Unitario: </label>
                <input type="number" id="productPrice" class="form-control w-100 my-2">
                
                <input type="button" class="btn btn-success w-100 mt-3" onclick="insertProduct()" value="Inserisci Prodotto">
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
    
    <?php include_once 'footer.php' ?>
```

La struttura è simile a quella vista in [VIEW login.php](Guide/Lezione2/MVC.md#viewloginphp), per la spiegazione si rimanda quindi al link corrispondente.

# View insertProduct.js

Per l'inserimento di un prodotto useremo un codice molto simile a quello utilizzato per la [registrazione di un utente](Guide/Lezione5/registrazione.md#registerjs---registrazione-di-un-utente). **Ricordiamo che il codice va nella cartella js**

```javascript
function insertProduct() {
    let productName = document.getElementById('productName').value;
    let productDescription = document.getElementById('productDescription').value;
    let productPrice = document.getElementById('productPrice').value;

    let productData = {
        name: productName,
        description: productDescription,
        unitPrice: productPrice,
        action: "insertProduct"
    };

    let productUrl = "./Control/productControl.php";

    fetch(productUrl, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(productData)
    })
    .then((response) => response.json())
    .then((data) => {
        if(data.insertionStatus === 0) {
            alert("Prodotto inserito con successo");
            location.href = "index.php"; // Reindirizziamo l'utente a "index.php".
        } else if(data.insertionStatus === 1) {
            alert("Errore");
        } else if(data.insertionStatus === 9) {
            alert("Per inserire un prodotto fai l'accesso come venditore");
        }
       
    })
    .catch((error) => {
        console.error('Errore durante l\'inserimento del prodotto:', error);
    });
}

```
Il concetto è quello che abbiamo visto anche nelle guide precedenti, con la differenza che controlliamo un codice di errore diverso.


# Modifiche a navbar.js

Modifichiamo ora il codice di generazione della navbar in navbar.js per distinguere le funzioni di venditore e compratore.

L'introduzione di funzioni per distinguere tra venditore e compratore mira a personalizzare l'esperienza utente. Ad esempio, i venditori potranno accedere a strumenti di gestione dei prodotti, mentre gli acquirenti potrebbero visualizzare opzioni di navigazione più orientate all'acquisto.

Vediamo prima tutto il codice con i commenti nei punti aggiunti

```javascript
    document.addEventListener("DOMContentLoaded", function() {
    
    visualizzaNavbar();
    
});


async function visualizzaNavbar(){

    user = await testLogin();

    if(user.username!=undefined){
        generaLogout(user.username);
        // aggiunta di una funzione per generare la navbar in base al tipo di utente.
        generaNavbar(user.usertypeID)
    }else{
        generaLogin();
    }
}


async function testLogin(){

    let dati={};
    let ritorno=null;
    dati.action="userInfo";
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
        
        ritorno= data;
        
    })

    return ritorno;

}


function generaLogout(username){

    let newWelcomeLi = document.createElement("li");
    newWelcomeLi.classList.add("nav-item");
    let newSpan = document.createElement("span");
    newSpan.classList.add("nav-link");
    newSpan.innerText="Benvenuto " + username;

    newWelcomeLi.appendChild(newSpan);

    document.getElementById("RightNavList").appendChild(newWelcomeLi);

    let newLogoutLi = document.createElement("li");
    newLogoutLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href="./Control/userControl.php?logout=logout";
    newA.innerText="Logout";

    newLogoutLi.appendChild(newA);
    document.getElementById("RightNavList").appendChild(newLogoutLi);
}


function generaLogin(){

    let newLoginLi = document.createElement("li");
    newLoginLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href="./login.php";
    newA.innerText="Entra";

    newLoginLi.appendChild(newA);
    document.getElementById("RightNavList").appendChild(newLoginLi);
}


// Scrivo una funzione per distinguere il tipo di utente
function generaNavbar(usertypeID){

    if(usertypeID==2){
        generaNavbarSeller();
    }else if(usertypeID==3){
        generaNavbarBuyer();
    }

}

// Per evitare di riscrivere sempre lo stesso codice scrivo 
// una funzione per generare un campo della navbar
function generaNavLink(Pagina, Testo){

    let newLi = document.createElement("li");
    newLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href=Pagina;
    newA.innerText=Testo;
    newLi.appendChild(newA);

    return newLi;

}

function generaNavbarSeller(){

    // Uso la funzione creata per generare un link all'inserimento prodotto
    
    let linkProdotto = generaNavLink("./insertProduct.php","Inserisci Prodotto");

    document.getElementById("LeftNavList").appendChild(linkProdotto);

}
```

Vediamo ora i punti di codice nel dettaglio:

nella function di visualizzaNavbar aggiungiamo semplicemente una nuova chiamata a funzione

```javascript
async function visualizzaNavbar(){

    user = await testLogin();

    if(user.username!=undefined){
        generaLogout(user.username);
        // aggiunta di una funzione per generare la navbar in base al tipo di utente.
        generaNavbar(user.usertypeID)
    }else{
        generaLogin();
    }
}
```


Questa funzione servirà solo a distinguere stra venditore e compratore.

```javascript
// Scrivo una funzione per distinguere il tipo di utente
function generaNavbar(usertypeID){

    if(usertypeID==2){
        generaNavbarSeller();
    }else if(usertypeID==3){
        generaNavbarBuyer();
    }

}
```

Per ora implementiamo solo la funzione per il venditore, nelle guide successive sarà proposta anche quella per gli acquirenti.
Prima di farlo però scrivo una funzione per aggiungere un campo alla navbar, perchè è un codice che riutilizzerò molte volte. Il codice mostrato è già stato spiegato in [Gestione Navbar con JS](../Lezione3/ControlloLogin.md#implementazione-della-navbar-con-javascript) e consiste nel creare un elemento li e un elemento a che indirizzino alla pagina scelta visualizzando il testo scelto.

```javascript
// Per evitare di riscrivere sempre lo stesso codice scrivo 
// una funzione per generare un campo della navbar
function generaNavLink(Pagina, Testo){

    let newLi = document.createElement("li");
    newLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href=Pagina;
    newA.innerText=Testo;
    newLi.appendChild(newA);

    return newLi;

}
```

Infine implementiamo la funzione per generare la navbar del venditore, che per ora consisterà soltanto in visualizzare la pagina di inserimento dei prodotti.

```javascript
function generaNavbarSeller(){

    // Uso la funzione creata per generare un link all'inserimento prodotto
    
    let linkProdotto = generaNavLink("./insertProduct.php","Inserisci Prodotto");

    document.getElementById("LeftNavList").appendChild(linkProdotto);

}
```

Quindi possiamo concludere dicendo che le nuove funzioni introdotte, come generaNavLink e generaNavbarSeller, sono fondamentali per la creazione dinamica della barra di navigazione. generaNavLink è stata progettata per semplificare la generazione di collegamenti, rendendo più agevole l'aggiunta di nuove voci nella barra di navigazione. D'altra parte, generaNavbarSeller è stata ideata per mostrare solo le opzioni pertinenti ai venditori, come ad esempio l'accesso diretto alla pagina di inserimento prodotti, ottimizzando così la navigazione e l'usabilità per questa categoria di utenti.
