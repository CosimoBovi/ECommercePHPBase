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

