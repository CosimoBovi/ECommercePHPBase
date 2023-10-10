async function register(){

    let dati={};
    dati.user=document.getElementById("user").value;
    dati.pass=document.getElementById("pass").value;
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
    }).then((response) => response.text())
    .then((data) => {
      
        location.href="index.php";
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
    }).then((response) => response.text())
    .then((data) => {
      
        alert(data);
    })
        
}