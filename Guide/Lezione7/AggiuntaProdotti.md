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

Creaiamo ora il file productModel.php all'interno della cartella che contiene i Model e iniziamo scrivendo la funzione per inserire un nuovo prodotto.

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

Come avevamo fatto precedentemente con gli utenti, creeremo anche un Control per i prodotti, che gestirà le richieste provenienti dalla View e le indirizzerà al Model. Il control per i prodotti sarà molto simile a quello per gli utenti e consisterà in una serie di if che determineranno l'azione da compiere.

```php
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
        // Se l'utente non è loggato come venditore, restituisci un codice di errore (9)
        echo json_encode(['insertionStatus' => 9]);
    }
}
```

Certamente, ecco una spiegazione a punti del codice "insertProduct":

1. **Controllo dell'azione richiesta:** Inizia controllando se l'azione richiesta è quella di inserire un nuovo prodotto nel sistema. Questo passaggio è identificato tramite la condizione `if ($Dati["action"] == "insertProduct")`.

2. **Verifica dell'autenticazione:** Successivamente, verifica se l'utente è autenticato attraverso la sessione attiva. Questo controllo avviene con `isset($_SESSION["userID"])`, assicurandosi che l'ID dell'utente sia stato memorizzato nella sessione.

3. **Controllo del tipo di utente:** Verifica se il tipo di utente corrisponde a un venditore. Controlla la variabile `$_SESSION["usertypeID"]`, garantendo che sia impostata correttamente e corrisponda all'ID associato ai venditori (in questo caso, UsertypeID 2).

4. **Acquisizione dei dati del prodotto:** Se l'utente supera con successo i controlli di autenticazione e tipologia, acquisisce i dati relativi al nuovo prodotto che si desidera inserire. Questi dati includono nome, descrizione, prezzo unitario e link all'immagine del prodotto.
   
5. **Associazione del venditore al prodotto:** Viene assegnato l'ID del venditore, memorizzato nella sessione come `$_SESSION["userID"]`, alla variabile `$userSellerID`. Questo collegamento permette di associare correttamente il prodotto al venditore autenticato prima dell'inserimento nel database.

6. **Esecuzione dell'inserimento:** Una volta ottenuti tutti i dati necessari, chiama la funzione `insertProduct` nel modello dei prodotti, passando i dati ottenuti come argomenti per aggiungere il nuovo prodotto al database.

7. **Risposta in base all'autenticazione:** Se l'utente non supera con successo i controlli di autenticazione o tipologia, il controllo restituirà un codice di errore specifico (9). Ciò indica che l'utente non è autorizzato a eseguire l'azione di inserimento del prodotto.

Questa struttura di controllo garantisce che solo venditori autenticati e autorizzati possano aggiungere nuovi prodotti al database, contribuendo alla sicurezza e all'integrità del sistema di gestione dei prodotti.

# View insertProduct.php

Passiamo ora alla view, come sempre ci concentreremo prima sul form per poi passare al js

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

Per l'inserimento di un prodotto useremo un codice molto simile a quello utilizzato per la [registrazione di un utente](Guide/Lezione5/registrazione.md#registerjs---registrazione-di-un-utente)

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
