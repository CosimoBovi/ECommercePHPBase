document.addEventListener("DOMContentLoaded", function() {
    
    visualizzaNavbar();
    
});


async function visualizzaNavbar(){

    user = await testLogin();

    if(user.username!=''){
        generaLogout(user.username);
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