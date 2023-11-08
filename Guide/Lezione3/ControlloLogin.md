# Controllo Login

Per poter gestire il controllo del login e la visaulizzazione dell'utente loggato dobbiamo aggiungere vari elementi al model alla view e al control

# userModel.php

Introdurremo ora una nuova funzione all'interno del nostro modello utente (`userModel.php`) chiamata `testLogin()`. Questa funzione sarà responsabile per controllare se un utente è loggato nell'applicazione. Ecco una spiegazione dettagliata della funzione:

```php
function testLogin(){
    if(isset($_SESSION["username"])){
        return $_SESSION["username"];
    }else{
        return "";
    }
}
```

- `function testLogin()`: Definiamo una nuova funzione chiamata `testLogin`.

- `if(isset($_SESSION["username"]))`: Utilizziamo l'istruzione `if` per verificare se esiste una variabile di sessione chiamata "username." La funzione `isset()` verifica se la variabile di sessione è stata impostata. Se questa variabile esiste, significa che l'utente è loggato.

- `return $_SESSION["username"];`: Se l'utente è loggato (ovvero se la variabile di sessione "username" esiste), restituiamo il valore di questa variabile, che rappresenta l'username dell'utente. Questo valore può essere utilizzato nel nostro codice per personalizzare l'esperienza dell'utente loggato.

- `else`: In caso contrario, se la variabile di sessione "username" non esiste, entriamo nell'istruzione `else`.

- `return "";`: Restituiamo una stringa vuota. Questo significa che se l'utente non è loggato, la funzione restituirà una stringa vuota.

Questa funzione `testLogin()` sarà utile per verificare lo stato di accesso dell'utente nell'applicazione. Se l'utente è loggato, potremo utilizzare il suo username per personalizzare il contenuto o fornire accesso a funzionalità specifiche. Se l'utente non è loggato, la funzione restituirà una stringa vuota, che può essere utilizzata per identificare che l'utente non è autenticato.


# userControl.php

Introdurremo ora il fatto che nel file `userControl.php` sarà aggiunta una funzione chiamata `testLogin()` per richiamare il modello utente. Questa funzione verrà spiegata in dettaglio di seguito.

```php
if ($Dati["action"] == "testLogin") {
    // Se l'azione è "testLogin," chiama la funzione "testLogin" dal modello utente.
    // Questa funzione controlla se l'utente è loggato e restituisce il risultato.

    $risultato = testLogin();
    echo json_encode(['risultato' => $risultato]);
}
```

**Spiegazione della funzione `testLogin()` nel file `userControl.php`**:

La funzione `testLogin()` è utilizzata per verificare se un utente è attualmente loggato nell'applicazione. Ecco come funziona:

1. La condizione `if ($Dati["action"] == "testLogin")` verifica se l'azione specificata nei dati inviati corrisponde a "testLogin." Questo è il modo in cui il controllore determina quale operazione deve essere eseguita.

2. Se l'azione è "testLogin," viene chiamata la funzione `testLogin()`.

3. All'interno della funzione, viene verificato se l'utente ha una sessione attiva. La funzione `isset($_SESSION["username"])` controlla se la variabile di sessione "username" è definita. Se lo è, significa che l'utente è loggato, e il suo username viene restituito come risultato.

4. Se l'utente non è loggato (ovvero, la variabile di sessione "username" non è definita), la funzione restituirà una stringa vuota come risultato.

5. Il risultato ottenuto viene quindi convertito in formato JSON utilizzando `json_encode()` e restituito come risposta HTTP al client.
