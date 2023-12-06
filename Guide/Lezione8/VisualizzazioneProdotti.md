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

Per semplicità visto che i prodotti sono accessibili a tutti modifico la index.php per permettere di mostrare i prodotti.

```html

<?php include_once "header.php" ?>
<?php include_once "navbar.php" ?>

<script src="./js/products.js"></script>

<div class="mx-4" style="flex: 1" id="productSection">

    <h3> Elenco dei prodotti disponibili </h3>
    
    <div class="row" id="productsList">

    </div>
    
   
</div>

<ul class="pagination mt-auto justify-content-center" id="Pages">
          
</ul>

<?php include_once "footer.php" ?>



```


```js




```
