# Impostazione del sito

Per creare il nostro sito, utilizzeremo la tecnica della modularizzazione del codice HTML. Questo significa che divideremo la pagina web in piccoli "pezzi di puzzle" separati, come l'intestazione, la barra di navigazione e il piè di pagina. Questi pezzi possono essere riutilizzati in diverse pagine, rendendo la creazione e la manutenzione dei siti web più semplici. Se vogliamo apportare modifiche, possiamo farlo solo in uno di questi pezzi anziché in tutto il sito. In breve, la modularizzazione rende la gestione del codice più efficiente.

# Index.php

Vediamo ora come costruire un'esempio di pagina iniziale del nostro sito internet

```php
<?php include_once "header.php" ?>
<?php include_once "navbar.php" ?>

<p>Questa è la home page</p>

<?php include_once "footer.php" ?>

```


Questo codice PHP è utilizzato per comporre una pagina web combinando il contenuto da diversi file PHP. Ogni parte svolge un ruolo specifico:

- La prima riga `<?php include_once "header.php" ?>` indica al server web di includere il contenuto del file "header.php" all'interno della pagina. Di solito, l'intestazione contiene elementi come il logo e il titolo del sito.

- La seconda riga `<?php include_once "navbar.php" ?>` esegue la stessa operazione, ma per il file "navbar.php". Questo file solitamente contiene la barra di navigazione con i link alle diverse sezioni del sito.

- La riga `<p>Questa è la home page</p>` rappresenta il contenuto principale della pagina, che in questo caso è un semplice paragrafo che dichiara che ci troviamo sulla pagina principale.

- Infine, l'ultima riga `<?php include_once "footer.php" ?>` include il file "footer.php", che di solito contiene informazioni come il copyright o i dati di contatto.

L'utilizzo di `include_once` garantisce che questi file vengano inclusi solo una volta nella pagina, evitando duplicazioni indesiderate.

In breve, questo codice PHP sta assemblando una pagina web combinando il contenuto da diversi file PHP, seguendo il principio di modularizzazione spiegato in precedenza. Ciò semplifica la creazione e la manutenzione del sito, consentendo modifiche facili e una migliore organizzazione del codice.
