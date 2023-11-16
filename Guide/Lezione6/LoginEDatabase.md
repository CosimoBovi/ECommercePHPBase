# Login e Database

Attraverso la nostra struttura ben definita MVC (Model-View-Controller), siamo in grado di introdurre miglioramenti al nostro sistema in modo modulare. In questa fase, concentreremo la nostra attenzione sul modello, precisamente su `userModel.php`, per integrare la gestione del Login degli utenti tramite il database. La bellezza di questa architettura è che possiamo apportare modifiche al modello senza impattare il funzionamento dei livelli di visualizzazione e di controllo. Quindi, tutte le modifiche effettuate in questo contesto comprenderanno solo `userModel.php` senza impattare su altri file.

# Modifiche a userModel.php

L'unica cosa che dobbiamo fare in userModel è cambiare la funzione login per impostare il collegamento al database come segue.

```php
function login($user, $pass) {
    $servername = "localhost";
    $dbname = "ecommercedb";
    $dbusername = "root";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparazione della query per selezionare l'username e la password corrispondenti
        $stmt = $conn->prepare("SELECT Username, Password FROM Users WHERE Username = :username");
        $stmt->bindParam(':username', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se l'utente esiste nel database
        if (!$result) {
            return 2; // Utente non esiste
        }

        $hashedPassword = $result['Password'];

        // Verifica se la password fornita corrisponde a quella memorizzata nel database
        if (password_verify($pass, $hashedPassword)) {
            // Se la password è corretta, salva l'username nella sessione
            $_SESSION["username"] = $user;
            return 0; // Accesso riuscito
        } else {
            return 3; // Password errata
        }
    } catch(PDOException $e) {
        return 1; // Errore generico
    }
}
```

Gran parte del codice della funzione è molto simile alle precedenti. Questa funzione si connette al database e cerca l'utente corrispondente all'username fornito. 
1. Se l'utente non esiste, ritorna 2.
2. Se l'utente esiste, verifica se la password fornita corrisponde a quella memorizzata nel database usando `password_verify`. Se la password è corretta, salva l'username dell'utente nella sessione e ritorna 0;
3. Se la password è sbagliata, ritorna 3.
4. In caso di errore generico durante la connessione al database o l'esecuzione della query, ritorna 1.

# Modifiche a Login.js

In login.js in precedenza avevamo solo il caso di login riuscito oppure fallito, ora possiamo dare più informazioni all'utente e quindi possiamo modificarla come segue:

```js
async function login() {
    // Creiamo un oggetto 'dati' per raccogliere le informazioni dell'utente.
    let dati = {};
    dati.username = document.getElementById("user").value; // Otteniamo il valore dell'input per l'username.
    dati.password = document.getElementById("pass").value; // Otteniamo il valore dell'input per la password.
    dati.action = "login"; // Specifica l'azione da eseguire, in questo caso, "login".

    // Definiamo l'URL a cui invieremo la richiesta.
    let url = "./Control/userControl.php";

    // Usiamo l'API 'fetch' per effettuare una richiesta HTTP asincrona.
    // Questo è un modo per comunicare con il server senza dover ricaricare l'intera pagina.
    let obj = fetch(url, {
        method: "POST", // Specifichiamo il metodo HTTP come "POST".
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati) // Convertiamo l'oggetto 'dati' in formato JSON e lo includiamo nel corpo della richiesta.
    })
    .then((response) => response.json()) // Riceviamo la risposta JSON dal server.
    .then((data) => {
        // Verifichiamo se l'utente ha inserito credenziali corrette.
        if (data.errore == 0) {
            location.href = "index.php"; // Reindirizziamo l'utente a "index.php".
        } else if (data.errore == 2){
            alert("Nome utente inesistente"); 
        }else if (data.errore == 3){
            alert("Password Errata"); 
        }else{
            alert("Errore"); 
        }
    });
}
```

Abbiamo semplicemente alla funzione precedente una serie di else if per comprendere l'errore corrispondente.

---

***Approfondimento sulla Sicurezza***

Di norma, per ragioni di sicurezza, è consigliabile limitare le informazioni fornite agli utenti in caso di errori di autenticazione. Rivelare informazioni specifiche, come se l'utente non esiste o se la password è errata, potrebbe agevolare un potenziale utente malevolo nel tentativo di accedere al sistema o di ottenere credenziali valide. Questa pratica potrebbe facilitare attacchi mirati o tentativi di furto di credenziali.
Nonostante ciò abbiamo scelto di mostrare tali informazioni per scopi didattici, al fine di offrire agli studenti una panoramica completa delle possibili situazioni di autenticazione e dei relativi messaggi di errore.





