# Registrazione di un utente

Andiamo ora a collegare il database appena creato con il sito php che stiamo costruendo. La prima cosa che andremo a fare sarà permettere alla nostra applicazione di registrare un utente, che sia esso un acquirente o un venditore per il nostro sito ecommerce

# Inserimento dei tipi di utente

Prima di iniziare dobbiamo inserire i vari tipi di utente, per farlo scriviamo una query di inserimento direttamente nel nostro db, seguendo la guida a questo link [Dove scrivere le query](Guide/Lezione4/Database.md#dove-scrivere-le-query)

```sql
INSERT INTO UserTypes (type, description)
VALUES 
    ('Administrator', 'Ruolo dell\'amministratore con pieni privilegi di gestione del sistema.'),
    ('Seller', 'Ruolo del venditore che gestisce i prodotti e le vendite.'),
    ('Buyer', 'Ruolo dell\'acquirente che effettua acquisti e visualizza prodotti disponibili.');
```

In questo modo abbiamo i tre tipi di utenti che possiamo salvare all'interno del nostro database.

# Modifiche a userModel.php

All'interno del nostro progetto MVC gestiremo direttamente i tipi di utenti all'interno del Controllore e del Modello degli Utenti anziché crearne uno separato. Questa scelta è stata motivata dal fatto che i tipi di utenti sono molto legati all'utente stesso, e aggiungere altri file complicherebbe solo il nostro sistema.

