function insertProduct() {
    let productName = document.getElementById('productName').value;
    let productDescription = document.getElementById('productDescription').value;
    let productPrice = document.getElementById('productPrice').value;

    let productData = {
        name: productName,
        description: productDescription,
        unitPrice: productPrice,
        action: "insertProduct"
    };

    let productUrl = "./Control/productControl.php";

    fetch(productUrl, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(productData)
    })
    .then((response) => response.json())
    .then((data) => {
        if(data.insertionStatus === 0) {
            alert("Prodotto inserito con successo");
            location.href = "index.php"; // Reindirizziamo l'utente a "index.php".
        } else if(data.insertionStatus === 1) {
            alert("Errore");
        } else if(data.insertionStatus === 9) {
            alert("Per inserire un prodotto fai l'accesso come venditore");
        }
       
    })
    .catch((error) => {
        console.error('Errore durante l\'inserimento del prodotto:', error);
    });
}