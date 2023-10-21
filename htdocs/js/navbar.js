function init(){

    visualizzaNavbar();
}


async function visualizzaNavbar(){

        user = await testLogin();

        if(user!=null){
            generaInferfacciaUtente(user);
        }


}




async function testLogin(){
    let dati={};
    let ritorno=null;
    dati.action="controllaLogin";
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


function generaInferfacciaUtente(user){

    let newLi = document.createElement("li");
    newLi.classList.add("nav-item");
    let newA = document.createElement("a");
    newA.classList.add("nav-link");
    newA.href="./Control/userControl.php?logout=logout";
    newA.innerText="Logout";

    newLi.appendChild(newA);
    document.getElementById("listaNavbar").appendChild(newLi);
}