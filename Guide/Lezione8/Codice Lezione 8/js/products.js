document.addEventListener("DOMContentLoaded", function() {
    
    pageGeneration();
    productView(0);
    
});

async function pageGeneration(){

    let dati={};
    dati.action="getProductsCount";
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
        
        numberOfPages=Math.floor(data.productsCount/9)+1;
        let productPagination = document.getElementById("Pages");

        for(let i=0;i<numberOfPages;i++){

            //<li class="page-item"><a class="page-link">1</a></li>
            let newLi = document.createElement("li");
            newLi.classList.add("page-item");
            let newA = document.createElement("a");
            newA.classList.add("page-link");
            newA.href="#";
            newA.addEventListener("click", function() {
                productView(i);
              } );
            newA.innerText=(i+1);

            newLi.appendChild(newA);

            productPagination.appendChild(newLi);
        }
        

    });

}

function productView(pageNumber){

    let dati={};
    dati.action="getProducts";
    dati.pageNumber=pageNumber;
    url="./Control/productControl.php";

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
        
        document.getElementById("productsList").innerHTML="";
        data.products.forEach(prodotto => {
            createCard(prodotto.ProductID,prodotto.Name,prodotto.ImageLink,prodotto.Description,prodotto.UnitPrice,user.length !== 0);
        });



    });

}


function createCard(Id, Title,Image,Description,Price,isUser){
    /*
        <div class="card">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
        </div>
    */

    let divContainer = document.createElement("div");
    divContainer.classList.add("col-md-4");
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

    if(isUser){
        let newLi = document.createElement("a");
        newLi.classList.add("btn");
        newLi.classList.add("btn-primary");
        newLi.href="./productDetails?ProductID="+Id;
        newLi.innerText="Dettagli Prodotto";
        divBody.appendChild(newLi);
    }

    divCard.appendChild(divBody);
    divContainer.appendChild(divCard);

    document.getElementById("productsList").appendChild(divContainer);
}