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
        
        




    });

}


function createCard(Title,Image,Description,Price,isUser){
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
    let divCard=document.createElement("div");
    divCard.classList.add("card");
    let imgCard= document.createElement("img");
    imgCard.classList.add("card-img-top");
    if(Image==null){
        imgCard.src="./img/placeholder.jpg";
    }else{
        imgCard.src=Image;
    }
    divCard.appendChild(imgCard);

    let divBody=document.createElement("div");
    divCard.classList.add("card-body");

    let hCard=document.createElement("h5");
    divCard.classList.add("card-title");
    divCard.innerText=Title;

    let pCard=document.createElement("p");
    pCard.classList.add("card-text");
    pCard.innerHTML=Description + "<br/>" + Price ;


}