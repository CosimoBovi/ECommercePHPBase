let user=[];

document.addEventListener("DOMContentLoaded", function() {
    
    visualizzaNavbar();
    
});


async function visualizzaNavbar(){

    user = await testLogin();

    if(user.username!=undefined){
        generaLogout(user.username);
        // aggiunta di una funzione per generare la navbar in base al tipo di utente.
        generaNavbar(user.usertypeID)
    }else{
        generaLogin();
    }
}


async function testLogin(){

    let dati={};
    let ritorno=null;
    dati.action="userInfo";
    url="./Control/userControl.php";

    let obj = await fetch(url,
    {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati)
    }).then((response) => response.json())
    .then((data) => {
        
        ritorno= data;
        
    })

    return ritorno;

}


function generaLogout(username){

    let newWelcomeLi = document.createElement("li");
    newWelcomeLi.classList.add("nav-item");
    let newSpan = document.createElement("span");
    newSpan.classList.add("nav-link");
    newSpan.innerText="Benvenuto " + username;

    newWelcomeLi.appendChild(newSpan);

    document.getElementById("RightNavList").appendChild(newWelcomeLi);

    let newLogoutLi = document.createElement("li");
    newLogoutLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href="./Control/userControl.php?logout=logout";
    newA.innerText="Logout";

    newLogoutLi.appendChild(newA);
    document.getElementById("RightNavList").appendChild(newLogoutLi);
}


function generaLogin(){

    let newLoginLi = document.createElement("li");
    newLoginLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href="./login.php";
    newA.innerText="Entra";

    newLoginLi.appendChild(newA);
    document.getElementById("RightNavList").appendChild(newLoginLi);
}


// Scrivo una funzione per distinguere il tipo di utente
function generaNavbar(usertypeID){

    if(usertypeID==2){
        generaNavbarSeller();
    }else if(usertypeID==3){
        generaNavbarBuyer();
    }

}

// Per evitare di riscrivere sempre lo stesso codice scrivo 
// una funzione per generare un campo della navbar
function generaNavLink(Pagina, Testo){

    let newLi = document.createElement("li");
    newLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href=Pagina;
    newA.innerText=Testo;
    newLi.appendChild(newA);

    return newLi;

}

function generaNavbarSeller(){

    // Uso la funzione creata per generare un link all'inserimento prodotto
    
    let linkProdotto = generaNavLink("./insertProduct.php","Inserisci Prodotto");

    document.getElementById("LeftNavList").appendChild(linkProdotto);

}