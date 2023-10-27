

async function addProduct(){

    userinfo=await getUserInfo();

    let dati={};
    dati.productName=productForm.productName.value;
    dati.productDescription=productForm.productDescription.value;
    dati.productPrice=productForm.productPrice.value;
    dati.userSellerID=userinfo.userID;	

    result= await insertProduct(dati);

    if(result>0){
        
        inviaImmagini(productForm.productImages);

    }


}


async function inviaImmagini(immagini){
    let formData = new FormData();
    for (let i = 0; i < immagini.files.length; i++) {
        formData.append('productImages[]', immagini.files[i]);
    }

    url="./Control/productControl.php";
    formData.append('productName', 'Nome del prodotto');


    let obj = await fetch(url,
    {
        method: "POST",
        body: formData
    }).then((response) => response.json())
    .then((data) => {
        
        ritorno= data;
        
    })
    
    return ritorno;

}

async function getUserInfo(){

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


async function insertProduct(dati){

    dati.action="insertProduct";
    url="./Control/productControl.php";

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
        
        ritorno=data.errore;
    })

    return ritorno;
}