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

La pagina `userModel.php` che è stata fornita sembra essere un semplice esempio di un file PHP che contiene funzioni per la gestione dell'autenticazione degli utenti. Queste funzioni, anche se semplificate, possono aiutare a comprendere i concetti di base di PHP e la gestione di sessioni. Ecco una spiegazione step-by-step che tiene conto del fatto che la spiegazione è rivolta a persone che stanno apprendendo PHP per la prima volta:

1. `<?php`: Questo è il tag di apertura PHP e indica l'inizio di un blocco di codice PHP.

2. `session_start();`: Questa istruzione inizializza una sessione. Le sessioni sono una caratteristica di PHP che consente di memorizzare dati tra le pagine web.

3. La funzione `login($user, $pass)`: Questa è una funzione personalizzata che prende due parametri, `$user` e `$pass`, che rappresentano l'username e la password inseriti dall'utente.

4. All'interno della funzione, c'è un blocco condizionale (`if-else`):
   - L'istruzione `if` verifica se l'username e la password sono uguali a "username" e "password". Nota che questa è una simulazione semplificata. In un'applicazione reale, questa parte verrà sostituita da una query al database per verificare le credenziali dell'utente.
   - Se le credenziali sono corrette, viene impostata una variabile di sessione chiamata "username" con il valore dell'username dell'utente (`$_SESSION["username"] = $user;`). Questo `$user` rappresenta l'username fornito come argomento alla funzione.
   - Viene quindi stampato "0" per indicare che l'accesso è riuscito.
   - Se le credenziali non sono corrette, viene stampato "1" per indicare che l'accesso è fallito.

5. `?>`: Questo è il tag di chiusura PHP e indica la fine del blocco di codice PHP.

---

**Nota di Approfondimento:**

- Il simbolo `$` in PHP è utilizzato per definire e accedere alle variabili. In questo caso, `$user` è una variabile locale che rappresenta l'username passato come argomento alla funzione `login`.

- `$_SESSION["username"]` è una variabile di sessione in PHP. Le variabili di sessione sono utilizzate per memorizzare dati che devono persistere tra diverse pagine web o richieste. In questo caso, stiamo impostando la variabile di sessione "username" con il valore dell'username dell'utente. Questa variabile può essere utilizzata in altre parti dell'applicazione per verificare l'accesso dell'utente o per personalizzare l'esperienza utente in base all'username. È un esempio di vettore associativo, cioè di un vettore che ha come indici non dei numeri ma delle chiavi solitamente testuali. In questo caso "username" è la chiave e `$user` è il valore associato a quella chiave.


