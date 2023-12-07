# Visualizzazione Prodotti

Ora che abbiamo aggiunto i prodotti dobbiamo permette la visualizzazione degli stessi, la visualizzazione dei prodotti seguirà un'insieme di regole:

- Tutti possono vedere i prodotti, anche gli utenti non registrati
- Solo gli utenti registrati possono acquistare i prodotti
- I prodotti devono essere visualizzati in un numero massimo di 9 per pagina

# Aggiunte a ProductModel.php

```php
function getProducts($pageNumber, $productsPerPage) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Calcolo dell'offset per la paginazione
        $offset = $pageNumber * $productsPerPage;

        // Query per estrarre il set di prodotti limitato
        $sql = "SELECT * FROM Products LIMIT :offset, :productsPerPage";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':productsPerPage', $productsPerPage, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;

    } catch(PDOException $e) {
        // Gestione degli errori
        return []; // Restituisce un array vuoto in caso di errore
    }
}
```

Analizziamo la function nel dettaglio:

1. **Scopo della funzione**:
   - La funzione `getProducts` nel `productModel` è progettata per recuperare un insieme limitato di prodotti basato sul numero di prodotti desiderati per pagina e sulla pagina selezionata.

2. **Utilizzo di `LIMIT` in SQL**:
   - La clausola `LIMIT` in SQL permette di limitare il numero di righe restituite da una query. In questo contesto, viene utilizzata per estrarre solo una porzione specifica dei risultati totali.

3. **Calcolo dell'Offset per la Paginazione**:
   - L'offset indica da dove iniziare a recuperare i dati all'interno di un set di risultati. Per la paginazione, calcoliamo l'offset basandoci sul numero di prodotti desiderati per pagina e sulla pagina corrente. 
   - L'offset si calcola moltiplicando il numero della pagina per il numero di prodotti per pagina. Ad esempio, per la pagina 2 con 10 prodotti per pagina, l'offset sarà 20 (pagina 2 * 10).

4. **Utilizzo dell'Offset nella Query SQL**:
   - Nella query SQL, l'offset determina da quale riga iniziare a estrarre i dati. Combinato con `LIMIT`, permette di estrarre solo una sezione specifica dei risultati. 
   - Ad esempio, `LIMIT 10, 10` recupera i prodotti dall'undicesimo al ventesimo all'interno del set totale di prodotti.

5. **Vantaggi della Paginazione con `LIMIT`**:
   - La paginazione con `LIMIT` migliora l'esperienza utente consentendo di visualizzare grandi set di dati in porzioni gestibili.
   - Migliora l'efficienza e la velocità di caricamento dei dati evitando di dover recuperare e mostrare tutti i dati in una singola volta.

In sintesi, `getProducts` utilizza `LIMIT` e l'offset per estrarre un numero specifico di prodotti per pagina, migliorando l'usabilità dell'applicazione e ottimizzando la gestione di grandi quantità di dati.


Inoltre per gestire bene la visualizazione è necessario scrivere una funzione che ritorni quanti prodotti abbiamo all'interno del nostro database

```php
function getTotalProductsCount() {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT COUNT(*) AS total FROM Products"; // Query per il conteggio dei prodotti
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total']; // Restituisce il numero totale di prodotti
    } catch(PDOException $e) {
        return -1; // Gestione degli errori nel caso in cui la query fallisca
    }
}
```

# Aggiunte a ProductControl.php


```php
if ($Dati["action"] == "getProducts" && isset($Dati["pageNumber"])) {
    //Visto che voglio solo 9 prodotti, come numero di prodotti passo il numero fisso 9 
    $products = getProducts($Dati["pageNumber"], 9);
    echo json_encode(['products' => $products]);
}

if ($Dati["action"] == "getProductsCount"){
    $productsCount=getTotalProductsCount();
    echo json_encode(['productsCount' => $productsCount]);
}
```

In product control come al solito richiamiamo solamento la funzione del model e ritorniamo un JSON con un echo, sia per i prodotti che per il numero totale di prodotti

# Modifiche ad index.php

Visto che i prodotti sono accessibili a tutti modifichiamo la index.php per permettere di mostrare i prodotti.

```html
<?php include_once "header.php" ?>
<?php include_once "navbar.php" ?>

<!-- Collegamento al file JavaScript per gestire la visualizzazione dei prodotti -->
<script src="./js/products.js"></script>

<!-- Sezione principale dell'interfaccia utente -->
<div class="mx-4" style="flex: 1" id="productSection">

    <!-- Intestazione che indica l'elenco dei prodotti disponibili -->
    <h3> Elenco dei prodotti disponibili </h3>
    
    <!-- Div in cui verranno visualizzati i prodotti -->
    <div class="row" id="productsList">

    </div>
    
</div>

<!-- Paginazione per navigare tra le pagine dei prodotti -->
<ul class="pagination mt-auto justify-content-center" id="Pages">
          
</ul>

<!-- Inclusione del file footer.php per i contenuti aggiuntivi -->
<?php include_once "footer.php" ?>
```

Quindi abbiamo aggiunto una serie di sezioni collegate con degli id che saranno gestiti dal js, allo scopo di mostrare i prodotti estratti dal database.


# Aggiunta di products.js

Il codice per mostrare i prodotti in JS è molto corposo però è anche molto ripetitivo e sfrutta elementi che abbiamo visto in precedenza.

Per via della lunghezza dividiamolo in due parti 

```javascript
// Attende il caricamento completo del documento HTML prima di eseguire il codice JavaScript
document.addEventListener("DOMContentLoaded", function() {
    
    // Invoca le funzioni per la generazione della paginazione e la visualizzazione dei prodotti
    pageGeneration();
    productView(0);
    
});

// Funzione asincrona per generare la paginazione
async function pageGeneration(){

    // Definizione dei dati per la richiesta al server tramite API
    let dati={};
    dati.action="getProductsCount"; // Specifica l'azione richiesta al server
    url="./Control/productControl.php"; // URL dell'endpoint API per il controllo dei prodotti

    // Chiamata asincrona fetch per ottenere il conteggio totale dei prodotti
    let obj = await fetch(url,
    {
        method: "POST", // Metodo della richiesta POST per inviare dati al server
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json' // Specifica il tipo di dati accettati e inviati
        },
        body: JSON.stringify(dati) // Converte i dati in formato JSON da inviare al server
    }).then((response) => response.json()) // Converte la risposta in formato JSON
    .then((data) => {
        
        // Calcola il numero totale di pagine basato sul conteggio dei prodotti e il limite visualizzato per pagina cioè 9
        numberOfPages=Math.floor(data.productsCount/9)+1;

        // Ottiene il riferimento all'elemento HTML che conterrà i numeri di pagina
        let productPagination = document.getElementById("Pages");

        // Itera attraverso il numero di pagine calcolato per creare i numeri di pagina nella paginazione
        for(let i=0;i<numberOfPages;i++){

            // Crea un nuovo elemento lista (li) per ogni numero di pagina
            let newLi = document.createElement("li");
            newLi.classList.add("page-item"); // Aggiunge la classe CSS per la formattazione

            // Crea un nuovo elemento anchor (a) per collegare i numeri di pagina
            let newA = document.createElement("a");
            newA.classList.add("page-link"); // Aggiunge la classe CSS per la formattazione
            newA.href="#"; // Imposta l'href a "#" per evitare l'aggiornamento della pagina

            // Aggiunge un listener per il click sul numero di pagina per chiamare la funzione productView con il numero di pagina corrente
            newA.addEventListener("click", function() {
                productView(i);
            });

            // Imposta il testo del numero di pagina come il numero corrente (incrementato di 1 per visualizzazione umana)
            newA.innerText=(i+1);

            // Aggiunge il link del numero di pagina all'elemento lista
            newLi.appendChild(newA);

            // Aggiunge l'elemento lista alla paginazione
            productPagination.appendChild(newLi);
        }
    });
}
```

Questa sezione di codice si occupa della generazione dinamica della paginazione dei prodotti, calcolando il numero di pagine necessarie in base al totale dei prodotti presenti nel sistema e creando un elenco di numeri di pagina interattivi per la navigazione. Vediamo nel dettaglio le parti di codice nuove:

- **Calcolo del Numero di Pagine:**
   - `numberOfPages = Math.floor(data.productsCount/9) + 1;` calcola il numero totale di pagine basato sul conteggio dei prodotti e il limite visualizzato per pagina.

- **Creazione della Paginazione:**
   - `document.getElementById("Pages")` ottiene il riferimento all'elemento HTML che conterrà i numeri di pagina.
   - `for(let i=0; i<numberOfPages; i++) {...}` itera attraverso il numero di pagine calcolato per creare i numeri di pagina nella paginazione.
   - `createElement` crea elementi HTML `<li>` e `<a>` per ogni numero di pagina.
   - `addEventListener` imposta un listener per il click su ogni numero di pagina, chiamando la funzione `productView(i)` per visualizzare i prodotti della pagina selezionata.
   - `appendChild` aggiunge gli elementi creati all'interno dell'elemento della paginazione.
 
Ora vediamo la seconda sezione del codice JS che servirà a mostrare i prodotti della pagina selezionata.

```javascript
// Funzione che visualizza un elenco di prodotti in base alla pagina specificata
function productView(pageNumber){

    let dati={};
    dati.action="getProducts"; // Azione per richiedere l'elenco dei prodotti
    dati.pageNumber=pageNumber; // Numero di pagina dei prodotti da visualizzare
    url="./Control/productControl.php"; // Percorso del file di controllo PHP

    // Richiesta asincrona POST per ottenere l'elenco dei prodotti
    let obj = fetch(url,
    {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati) // Invio dei dati al server
    }).then((response) => response.json()) // Conversione della risposta in formato JSON
    .then((data) => {
        
        document.getElementById("productsList").innerHTML=""; // Pulisce l'elenco dei prodotti

        // Ciclo attraverso l'array dei prodotti restituiti dalla richiesta
        data.products.forEach(prodotto => {
            createCard(prodotto.ProductID,prodotto.Name,prodotto.ImageLink,prodotto.Description,prodotto.UnitPrice,user.length !== 0);
        });

    });

}

// Funzione per creare la struttura HTML di una carta per il prodotto
function createCard(Id, Title, Image, Description, Price, isUser){
    /* 
        Struttura HTML di una carta per visualizzare i dettagli del prodotto
        Utilizza le informazioni fornite per costruire la carta del prodotto
    */

    let divContainer = document.createElement("div"); // Creazione del contenitore della carta
    divContainer.classList.add("col-md-4"); // Aggiunta delle classi CSS
    divContainer.style.padding="10px"; // Stile CSS

    let divCard=document.createElement("div"); // Creazione della carta
    divCard.classList.add("card"); // Aggiunta delle classi CSS
    let imgCard= document.createElement("img"); // Creazione dell'immagine della carta
    imgCard.classList.add("card-img-top"); // Aggiunta delle classi CSS

    // Verifica e impostazione dell'immagine del prodotto
    if(Image==null){
        imgCard.src="./img/placeholder.png"; // Immagine predefinita se non c'è un'immagine del prodotto
    } else {
        imgCard.src=Image; // Immagine del prodotto
    }
    divCard.appendChild(imgCard); // Aggiunta dell'immagine alla carta

    let divBody=document.createElement("div"); // Creazione del corpo della carta
    divCard.classList.add("card-body"); // Aggiunta delle classi CSS

    let hCard=document.createElement("h5"); // Creazione del titolo della carta
    hCard.classList.add("card-title"); // Aggiunta delle classi CSS
    hCard.innerText=Title; // Titolo del prodotto
    divBody.appendChild(hCard); // Aggiunta del titolo al corpo della carta

    let pCard=document.createElement("p"); // Creazione del testo della carta
    pCard.classList.add("card-text"); // Aggiunta delle classi CSS
    pCard.innerHTML=Description + "<br/>" + Price ; // Descrizione e prezzo del prodotto
    divBody.appendChild(pCard); // Aggiunta del testo al corpo della carta

    // Aggiunta di un link per i dettagli del prodotto se è un utente autorizzato
    if(isUser){
        let newLi = document.createElement("a");
        newLi.classList.add("btn");
        newLi.classList.add("btn-primary");
        newLi.href="./productDetails.php?ProductID="+Id;
        newLi.innerText="Dettagli Prodotto";
        divBody.appendChild(newLi);
    }

    // Completamento della struttura della carta e aggiunta alla pagina HTML
    divCard.appendChild(divBody);
    divContainer.appendChild(divCard);
    document.getElementById("productsList").appendChild(divContainer); // Aggiunta della carta alla lista dei prodotti
}
```
Vediamo le parti di codice più importanti:

1. **Funzione `productView(pageNumber)`:**
   - Questa funzione è chiamata quando si seleziona una specifica pagina di prodotti per visualizzarne l'elenco.
   - `pageNumber` è l'indice della pagina dei prodotti da visualizzare.

2. **Richiesta al Server - Recupero dei Prodotti:**
   - `dati` contiene le informazioni necessarie per la richiesta al server, inclusa l'azione (`getProducts`) e il numero di pagina.
   - `fetch(url, {...})` esegue una richiesta asincrona POST al server per ottenere i prodotti da visualizzare sulla pagina specificata.

3. **Creazione delle Carte dei Prodotti:**
   - `.then((response) => response.json())` converte la risposta del server in formato JSON.
   - `document.getElementById("productsList").innerHTML="";` svuota l'elemento HTML che conterrà l'elenco dei prodotti per prepararlo alla nuova visualizzazione.
   - `data.products.forEach(...)` cicla attraverso l'array dei prodotti restituiti dalla richiesta.
   - `createCard(...)` viene chiamata per ciascun prodotto per creare la struttura HTML della carta dei prodotti.

4. **Funzione `createCard(...)` - Creazione delle Carte dei Prodotti:**
   - `createCard(...)` genera la struttura HTML per visualizzare ciascun prodotto come una carta.
   - `divContainer` è un contenitore per ogni carta dei prodotti, con formattazione CSS.
   - `divCard` rappresenta la carta stessa, con l'aggiunta dell'immagine del prodotto.
   - `divBody` contiene il corpo della carta con il titolo e la descrizione del prodotto.
   - Se `isUser` è vero, viene aggiunto un link per dettagliare ulteriormente il prodotto.

5. **Aggiunta alla Pagina HTML:**
   - `document.getElementById("productsList").appendChild(divContainer);` aggiunge ogni carta dei prodotti all'elemento HTML per l'elenco dei prodotti.
