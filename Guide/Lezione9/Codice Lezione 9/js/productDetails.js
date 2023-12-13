

document.addEventListener("DOMContentLoaded", async function() {
    // Ottieni l'URL della pagina corrente
    let urlParams = new URLSearchParams(window.location.search);

    // Ottieni il valore del parametro 'ProductID'
    let productID = urlParams.get('ProductID');

    let prodotto = await productView(productID);
    if (prodotto!=null){
        productGraph(prodotto.UnitPrice);
    }
});

async function productView(productID){
    
    let dati={};
    dati.action="getProductByID";
    dati.productID=productID;
    url="./Control/productControl.php";
    let prodotto=null;
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
        prodotto = data.product;
        if(prodotto!=null){
            createCard(prodotto.ProductID,prodotto.Name,prodotto.ImageLink,prodotto.Description,prodotto.UnitPrice);
        }
    });
    return prodotto;
}

function createCard(Id, Title,Image,Description,Price,isUser){
    

    let divContainer = document.createElement("div");
    divContainer.style.padding="10px";

    let divCard=document.createElement("div");
    divCard.classList.add("card");
    let imgCard= document.createElement("img");
    imgCard.classList.add("card-img-top");
    if(Image==null){
        imgCard.src="./img/placeholder.png";
    }else{
        imgCard.src=Image;
    }
    divCard.appendChild(imgCard);

    let divBody=document.createElement("div");
    divCard.classList.add("card-body");

    let hCard=document.createElement("h5");
    hCard.classList.add("card-title");
    hCard.innerText=Title;
    divBody.appendChild(hCard);

    let pCard=document.createElement("p");
    pCard.classList.add("card-text");
    pCard.innerHTML=Description + "<br/>" + Price ;
    divBody.appendChild(pCard);

    divCard.appendChild(divBody);
    divContainer.appendChild(divCard);

    document.getElementById("ProductDetails").appendChild(divContainer);
}

async function productGraph(prezzo){

    let stats = await getStats();
    generatePieGraph(prezzo,stats.sum);
    generateBarGraph(prezzo,stats.avg);

}

async function getStats(){

    let dati={};
    dati.action="getPriceStats";
    url="./Control/productControl.php";
    let stats=[];
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
        stats.sum = parseFloat(data.total);
        stats.avg = parseFloat(data.average);
    });
    return stats;
}

function generatePieGraph(prezzo,sum){

    let proporzionePrezzo = (prezzo / sum) * 100; // Calcolo della proporzione

    // Creazione del grafico a torta
    const data = {
        labels: [`Prezzo Prodotto (${prezzo})`, `Altri Prezzi (${sum - prezzo})`],
        datasets: [{
        data: [proporzionePrezzo, 100 - proporzionePrezzo],
        backgroundColor: ['red', 'blue'], // Colore per il numero specifico e gli altri numeri
        // Altri attributi del dataset (se necessario)
        }]
    };

    const options = {
       
      
    };

    const ctx = document.getElementById('pieChart');

    // Crea il grafico a torta utilizzando Chart.js
    const myPieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: options
    });
  

}

function generateBarGraph(prezzo,avg){

   

    const data = {
        labels: ['Prezzo', 'Media Prezzi'],
        datasets: [{
          label: 'Confronto prezzo con la media',
          data: [prezzo, avg],
          backgroundColor: ['blue', 'green'], // Colore per la somma e la media
          // Altri attributi del dataset (se necessario)
        }]
      };
      
      const options = {
        
      };
      
      const ctx = document.getElementById('barChart');
      
      const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
      });

}