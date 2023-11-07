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
        } else {
            alert("Nome utente o password errati"); // Mostriamo un messaggio di errore se le credenziali sono errate.
        }
    });
}
