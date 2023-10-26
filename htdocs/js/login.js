



async function login(){

    let dati={};
    dati.user=document.getElementById("user").value;
    dati.pass=document.getElementById("pass").value;
    dati.action="login";
    url="./Control/userControl.php";

    let obj = fetch(url,
    {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati)
    }).then((response) => response.json())
    .then((data) => {
        if(data.errore==0){
            location.href="index.php";
        }else if(data.errore==1){
            alert("password errata")
        }else if(data.errore==2){
            alert("nome utente errato");
        }
    })
        
}