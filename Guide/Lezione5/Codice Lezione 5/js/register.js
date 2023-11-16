document.addEventListener("DOMContentLoaded", function() {
    
    userTypeGenerator();
    
});

async function userTypeGenerator(){

    let dati={};
    dati.action="getUserTypes";
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
        
        if (!('error' in data)) {

           data.forEach(element => {
                let newOption = document.createElement("option");
                newOption.value = element.Usertypeid;
                newOption.innerText = element.Type;
                document.getElementById("userType").appendChild(newOption);
           });
        }
        
    })
}


function registerUser(){

    let username = document.getElementById('username').value;
    let mail = document.getElementById('mail').value;
    let password = document.getElementById('password').value;
    let userType = document.getElementById('userType').value;

    let dati = {
        username: username,
        mail: mail,
        password: password,
        usertype: userType,
        action: "register"
    };

    let url = "./Control/userControl.php";

    
    let response =  fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dati)
    }).then((response) => response.json())
    .then((data) => {
        
        if(data.registrationStatus==0) {
            alert("registrazione avvenuta con successo");
            location.href="./index.php";
        }else if(data.registrationStatus==1){
            alert("errore");
        }else if(data.registrationStatus==2){
            alert("Username esistente");
        }else if(data.registrationStatus==3){
            alert("Mail esistente");
        }
    })
    
}
