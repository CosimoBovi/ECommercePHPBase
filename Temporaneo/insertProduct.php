<?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>
    
    <script src="./js/insertProduct.js"></script>
    
    <div class="row w-100">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <form id="productForm">
                <label class="w-25">Nome: </label>
                <input type="text" id="productName" class="form-control w-100 my-2">
                
                <label class="w-25">Descrizione: </label>
                <textarea id="productDescription" class="form-control w-100 my-2"></textarea>
                
                <label class="w-25">Prezzo Unitario: </label>
                <input type="number" id="productPrice" class="form-control w-100 my-2">
                
                <input type="button" class="btn btn-success w-100 mt-3" onclick="insertProduct()" value="Inserisci Prodotto">
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
    
    <?php include_once 'footer.php' ?>