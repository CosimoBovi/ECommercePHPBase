
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

        // Ritorna 0 per indicare che l'accesso è riuscito.
        return 0;
    } else {
        // Se le credenziali non sono corrette, ritorna 1 per indicare che l'accesso è fallito.
        return 1;
    }
}

function testLogin(){
    if(isset($_SESSION["username"])){
        return $_SESSION;
    }else{
        return [];
    }
}
?>
