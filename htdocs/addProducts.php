    
    <?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>

    <script src="./js/addProduct.js"></script>

    <div class="row w-100">
    <div class="col-md-3"></div>
    <div class="col-md-6 justify-content-center">
        <form>
            <label class="w-25">Nome del Prodotto: </label>
            <input type="text" id="productName" class="w-100 my-2">

            <label class="w-25">Descrizione: </label>
            <textarea id="productDescription" class="w-100 my-2" rows="4"></textarea>

            <label class="w-25">Prezzo: </label>
            <input type="number" id="productPrice" class="w-100 my-2">

            <label class="w-25">ID del Venditore: </label>
            <input type="text" id="sellerID" class="w-100 my-2">

            <label class="w-25">Allega Immagini: </label>
            <input type="file" id="productImages" class="w-100 my-2" accept="image/*" multiple>

            <input type="button" class="btn btn-success w-100 mt-5" onclick="addProduct()" value="Aggiungi Prodotto">
        </form>
    </div>
    <div class="col-md-3"></div>
</div>



    <?php include_once 'footer.php' ?>