function init(){

    visualizzaNavbar();
}


async function visualizzaNavbar(){

        user = await testLogin();

        if(user!=''){
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
        
        ritorno= data.username;
        
    })

    return ritorno;

}


function generaInferfacciaUtente(user){

    let newWelcomeLi = document.createElement("li");
    newWelcomeLi.classList.add("nav-item");
    let newSpan = document.createElement("span");
    newSpan.classList.add("nav-link");
    newSpan.innerText="Benvenuto " + user;

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