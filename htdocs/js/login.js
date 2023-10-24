document.addEventListener("DOMContentLoaded", function() {
    caricaUserTypes();
    
});

function caricaUserTypes() {
    let selectUserType = document.getElementById("userTypeId");
    selectUserType.innerHTML = "";

    let url = "./Control/usertypeControl.php?action=getUsertypes";

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            data.forEach((usertype) => {
                let option = document.createElement("option");
                option.value = usertype.UserType_ID;
                option.text = usertype.Type;
                selectUserType.appendChild(option);
            });
        })
        .catch((error) => {
            console.error("Errore durante il recupero dei tipi di utenti:", error);
        });
}


async function register(){

    let dati={};
    dati.user=document.getElementById("user").value;
    dati.pass=document.getElementById("pass").value;
    dati.userTypeId=document.getElementById("userTypeId").value;
    dati.action="register";
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
            alert("successo");
            location.href="index.php";
        }else if(data.errore==1){
            alert("nome utente esistente");
        }else{
            alert("errore sconosciuto");
        }
        
    })
        
}

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