# MVC

Per la creazione di questo sito web, adotteremo il modello MVC (Model-View-Controller). Il modello MVC è un'architettura che suddivide un'applicazione in tre componenti principali:

 **Modello (Model):** Questa componente gestisce i dati e modella la realtà nella nostra applicazione. Nel nostro caso, useremo il model per connetterci al database al fine di estrarre e inserire i dati nella nostra base di dati, che rappresenterà gli elementi dell'e-commerce.

2. **Vista (View):** La Vista è responsabile della presentazione dei dati agli utenti. Nel contesto del nostro sito, la Vista comprende le pagine PHP che costituiscono l'aspetto visuale, come "header.php," "navbar.php," e "footer.php." Solitamente, la view è composta solo da HTML, CSS e JS al fine di rendere il sito scalabile. Tuttavia, in questa guida, abbiamo scelto di utilizzare PHP e l'uso di `include` per semplicità e per introdurre le potenzialità del PHP.

3. **Controller (Controller):** Il Controller funge da intermediario tra le richieste degli utenti e il Modello e la Vista. Nel nostro caso, lo utilizzeremo per indirizzare correttamente le richieste provenienti dalla view alle funzionalità del model e per prelevare i dati dal model e inviarli correttamente alla view.


L'adozione del modello MVC aiuta a separare in modo chiaro la gestione dei dati, la logica di presentazione e il controllo delle interazioni degli utenti all'interno dell'applicazione. Questa suddivisione migliora l'organizzazione del codice, ne facilita la manutenzione e la scalabilità, semplifica lo sviluppo del sito web e agevola la collaborazione in un team di sviluppo. Inoltre, il modello MVC è un approccio comune nel mondo dello sviluppo web e promuove buone pratiche di programmazione.

# Struttura del progetto

Il progetto realtivo a questa guida è organizzato in una struttura di cartelle che contribuisce a mantenere il codice e i file ben organizzati. Ecco come è strutturato il progetto:

- La **cartella principale( HTDOCS )** contiene i file chiave del sito web, tra cui "index.php," "navbar.php," e altri file principali che costituiscono le pagine visibili del sito.

- All'interno della cartella principale, troverai anche una serie di sottocartelle, ognuna con un ruolo specifico:

    - **img**: Questa cartella contiene le immagini e le risorse multimediali utilizzate nel sito, come loghi, immagini dei prodotti e altri file multimediali.

    - **controller**: La cartella "controller" ospita i file che contengono la logica di controllo dell'applicazione.

    - **model**: La cartella "model" contiene i file che rappresentano il modello dei dati dell'applicazione. 

    - **js**: La cartella "js" è dedicata a file JavaScript.

Questa organizzazione a cartelle contribuisce a mantenere il progetto pulito, ordinato e facilmente gestibile, garantendo che ogni componente del sito web sia al suo posto e ben strutturata.

![Struttura Progetto MVC](StrutturaProgettoMVC.png)

# MODEL (userModel.php)

`userModel.php` è un componente chiave del Modello, e il suo scopo principale è gestire gli utenti. Questo file contiene tra le altre funzioni anche quella per la verifica delle credenziali degli utenti quando cercano di accedere al sito. La funzione `login` è un esempio di come questo processo di autenticazione potrebbe essere implementato all'interno del Modello.

```php

<?php
// Inizializzazione della sessione
session_start();

// La funzione login prende due parametri: $user e $pass, che rappresentano rispettivamente l'username e la password dell'utente.

function login($user, $pass) {
    // Verifica se l'username e la password sono corretti (nota: questo è solo un esempio semplificato).
    // Nella pratica, questa parte verrà sostituita da una chiamata a un database per verificare le credenziali.

    if ($user == "username" && $pass == "password") {
        // Se le credenziali sono corrette, impostiamo una variabile di sessione chiamata "username" con il valore di $user.
        $_SESSION["username"] = $user;

        // Stampa 0 per indicare che l'accesso è riuscito.
        echo 0;
    } else {
        // Se le credenziali non sono corrette, stampiamo 1 per indicare che l'accesso è fallito.
        echo 1;
    }
}

```

**Variabili in PHP:**

In PHP, il simbolo `$` è utilizzato per definire e accedere alle variabili. Le variabili in PHP sono contenitori per memorizzare dati, come numeri, stringhe, oggetti e altro. Quando dichiariamo una variabile, utilizziamo il simbolo `$` seguito da un nome significativo per la variabile. Ad esempio, `$user` è una variabile che può essere utilizzata per immagazzinare un valore come l'username di un utente.

```php
$user = "john_doe"; // Definizione di una variabile $user con un valore

