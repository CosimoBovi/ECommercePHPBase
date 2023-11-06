# Impostazione del sito

Per creare il nostro sito, utilizzeremo la tecnica della modularizzazione del codice HTML. Questo significa che divideremo la pagina web in piccoli "pezzi di puzzle" separati, come l'intestazione, la barra di navigazione e il piè di pagina. Questi pezzi possono essere riutilizzati in diverse pagine, rendendo la creazione e la manutenzione dei siti web più semplici. Se vogliamo apportare modifiche, possiamo farlo solo in uno di questi pezzi anziché in tutto il sito. In breve, la modularizzazione rende la gestione del codice più efficiente.

# index.php

Vediamo ora come costruire un'esempio di pagina iniziale del nostro sito internet

```php
<?php include_once "header.php" ?>
<?php include_once "navbar.php" ?>

<p>Questa è la home page</p>

<?php include_once "footer.php" ?>

```


Questo codice utilizza PHP, un linguaggio di programmazione spesso combinato con HTML per creare pagine web dinamiche. La parte PHP inizia e termina con `<?php` e `?>`, in questo caso viene utilizzata per includere il contenuto di tre file diversi all'interno di una pagina web.

- La prima riga `<?php include_once "header.php" ?>` indica al server web di includere il contenuto del file "header.php" all'interno della pagina. Di solito, l'intestazione contiene elementi come il logo e il titolo del sito.

- La seconda riga `<?php include_once "navbar.php" ?>` esegue la stessa operazione, ma per il file "navbar.php". Questo file solitamente contiene la barra di navigazione con i link alle diverse sezioni del sito.

- La riga `<p>Questa è la home page</p>` rappresenta il contenuto principale della pagina, che in questo caso è un semplice paragrafo che dichiara che ci troviamo sulla pagina principale.

- Infine, l'ultima riga `<?php include_once "footer.php" ?>` include il file "footer.php", che di solito contiene informazioni come il copyright o i dati di contatto.

L'utilizzo di `include_once` garantisce che questi file vengano inclusi solo una volta nella pagina, evitando duplicazioni indesiderate.

In breve, questo codice PHP sta assemblando una pagina web combinando il contenuto da diversi file PHP, seguendo il principio di modularizzazione spiegato in precedenza. Ciò semplifica la creazione e la manutenzione del sito, consentendo modifiche facili e una migliore organizzazione del codice.


# header.php

```html
<!DOCTYPE html>
<html data-bs-theme="dark">
    <head>
        <title> E-Commerce </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="d-flex flex-column min-vh-100">
        
        <hgroup class="text-center">
            <h1> E-Commerce </h1>
            <h2> Benvenuto nel mio E-Commerce </h2>
        </hgroup>
```


Questo codice HTML rappresenta la struttura di base della pagina "header.php" del nostro sito web e utilizza Bootstrap per la formattazione e il layout. Ecco una breve spiegazione di ciascuna parte:

1. `<!DOCTYPE html>`: Questa dichiarazione definisce il tipo di documento HTML utilizzato, indicando che si tratta di un documento HTML5.

2. `<html data-bs-theme="dark">`: Questo elemento `<html>` definisce l'inizio del documento HTML e specifica un attributo personalizzato `data-bs-theme` che potrebbe essere utilizzato per impostare un tema scuro (questo può essere parte di un uso personalizzato e non standard di Bootstrap).

3. `<head>`: Questa sezione contiene le informazioni sull'intestazione del documento, come il titolo della pagina e i collegamenti a fogli di stile e script esterni.

4. `<title> E-Commerce </title>`: Questo è il titolo della pagina web visualizzato nella barra del titolo del browser.

5. `<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">`: Questo tag `<link>` carica il foglio di stile CSS di Bootstrap dalla CDN (Content Delivery Network), che consente di applicare lo stile Bootstrap alla pagina.

6. `<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>`: Questo tag `<script>` carica il file JavaScript di Bootstrap dalla CDN, che fornisce funzionalità interattive di Bootstrap.

7. `<body class="d-flex flex-column min-vh-100">`: Questo è il corpo principale della pagina. L'attributo `class` applica classi CSS Bootstrap per creare un layout flessibile con altezza minima del 100% della viewport(la finestra visibile all'interno del browser).

8. `<hgroup class="text-center">`: Questo gruppo di titoli (`<h1>` e `<h2>`) è centrato orizzontalmente sulla pagina e rappresenta il titolo principale e una breve introduzione al sito web.

In generale, questo codice HTML crea una pagina di base con il titolo "E-Commerce" e utilizza Bootstrap per gestire la formattazione e il layout della pagina.

# navbar.php

```html
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">E-Commerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
```


Questo codice HTML rappresenta la struttura della barra di navigazione della pagina "navbar.php". Ecco una breve spiegazione di ciascuna parte:

- `<nav class="navbar navbar-expand-sm bg-dark navbar-dark">`: Questo elemento `<nav>` rappresenta la barra di navigazione. Le classi Bootstrap (`navbar`, `navbar-expand-sm`, `bg-dark`, `navbar-dark`) definiscono lo stile e il comportamento della barra di navigazione.

- `<div class="container-fluid">`: Questo `<div>` è un contenitore che aiuta a gestire la larghezza della barra di navigazione e ad allinearla correttamente.

- `<a class="navbar-brand" href="index.php">E-Commerce</a>`: Questo è il logo o il nome del marchio nella barra di navigazione.

- `<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">`: Questo è il pulsante del menu di navigazione che appare quando la larghezza dello schermo è troppo piccola per visualizzare tutti i collegamenti.

- `<div class="collapse navbar-collapse" id="collapsibleNavbar">`: Questo `<div>` contiene i collegamenti di navigazione e viene visualizzato quando il pulsante del menu è attivato.

- `<ul class="navbar-nav me-auto">`: Questa lista non ordinata (`<ul>`) contiene i collegamenti della barra di navigazione e si allinea automaticamente a destra.

- `<li class="nav-item">`: Ogni collegamento di navigazione è racchiuso in un elemento `<li>`, che rappresenta un elemento della lista.

- `<a class="nav-link" href="index.php">Home</a>`: Questo è un collegamento di navigazione che reindirizza alla pagina principale ("index.php").

In sintesi, il codice HTML crea una barra di navigazione con il nome del marchio, un pulsante di menu per i dispositivi mobili e un collegamento "Home". Le classi Bootstrap vengono utilizzate per definire lo stile e il comportamento della barra di navigazione.



# footer.php

```html
<footer class="mt-auto d-flex flex-wrap justify-content-between align-items-center py-3 border-top">
    <p class="col-md-4 mb-0 text-body-secondary"> E-Commerce Company </p>

    <a href="index.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      E-Commerce
    </a>

    <ul class="nav col-md-4 justify-content-end">
      <li class="nav-item"><a href="index.php" class="nav-link px-2 text-body-secondary">Home</a></li>
    </ul>
</footer>
</body>
</html>
```


Questo codice HTML rappresenta la struttura del piè di pagina nella pagina "footer.php." Ecco una breve spiegazione di ciascuna parte:

- `<footer class="mt-auto d-flex flex-wrap justify-content-between align-items-center py-3 border-top">`: Questo elemento `<footer>` rappresenta il piè di pagina del sito. Le classi Bootstrap sono utilizzate per definire l'allineamento, lo stile e la disposizione del piè di pagina.

- `<p class="col-md-4 mb-0 text-body-secondary"> E-Commerce Company </p>`: Questo paragrafo (`<p>`) contiene il nome dell'azienda (in questo caso, "E-Commerce Company"). Le classi Bootstrap definiscono la larghezza della colonna e il colore del testo.

- `<a href="index.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">E-Commerce</a>`: Questo è un collegamento che porta alla pagina principale ("index.php"). Le classi Bootstrap gestiscono la larghezza della colonna e lo stile del collegamento.

- `<ul class="nav col-md-4 justify-content-end">`: Questa è una lista non ordinata (`<ul>`) che contiene un collegamento di navigazione.

- `<li class="nav-item"><a href="index.php" class="nav-link px-2 text-body-secondary">Home</a></li>`: Questo è un collegamento di navigazione nella lista, che reindirizza alla pagina principale ("index.php").

In sintesi, il codice HTML crea il piè di pagina con il nome dell'azienda, un collegamento al sito e un collegamento "Home". Le classi Bootstrap vengono utilizzate per definire lo stile e la disposizione del piè di pagina.

