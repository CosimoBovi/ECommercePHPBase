# Aggiunta dei prodotti

Ora che abbiamo la possibilità di gestire gli utenti concentriamoci sulla gestione dei prodotti. In questa guida seguiremo tutta la parte di progettazione della tabella prodotti nel database, fino ad arrivare alla possibilità per un venditore di inserire il proprio prodotto.

# Progettazione tabella prodotti

Per la tabella prodotti seguiremo questo modello logico

```
Products(ProductID, Name, Description, UnitPrice, ImageLink, UserSellerID)
```
