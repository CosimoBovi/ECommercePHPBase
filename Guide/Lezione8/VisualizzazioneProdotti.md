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
        $offset = ($pageNumber - 1) * $productsPerPage;

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
   - L'offset si calcola moltiplicando il numero della pagina meno uno per il numero di prodotti per pagina. Ad esempio, per la pagina 2 con 10 prodotti per pagina, l'offset sarà 10 (pagina 2 - 1 * 10).

4. **Utilizzo dell'Offset nella Query SQL**:
   - Nella query SQL, l'offset determina da quale riga iniziare a estrarre i dati. Combinato con `LIMIT`, permette di estrarre solo una sezione specifica dei risultati. 
   - Ad esempio, `LIMIT 10, 10` recupera i prodotti dall'undicesimo al ventesimo all'interno del set totale di prodotti.

5. **Vantaggi della Paginazione con `LIMIT`**:
   - La paginazione con `LIMIT` migliora l'esperienza utente consentendo di visualizzare grandi set di dati in porzioni gestibili.
   - Migliora l'efficienza e la velocità di caricamento dei dati evitando di dover recuperare e mostrare tutti i dati in una singola volta.

In sintesi, `getProducts` utilizza `LIMIT` e l'offset per estrarre un numero specifico di prodotti per pagina, migliorando l'usabilità dell'applicazione e ottimizzando la gestione di grandi quantità di dati.

# Aggiunte a ProductControl.php


```php
if ($Dati["action"] == "getProducts" && isset($Dati["pageNumber"])) {
    //Visto che voglio solo 9 prodotti, come numero di prodotti passo il numero fisso 9 
    $products = getProducts($Dati["pageNumber"], 9);
    echo json_encode(['products' => $products]);
}
```

In product control come al solito richiamiamo solamento la funzione del model e ritorniamo un JSON con un echo. 

# Modifiche ad index.php

Per semplicità visto che i prodotti sono accessibili a tutti modifico la index.php per permettere di mostrare i prodotti.

