<?php include_once 'header.php' ?>
<?php include_once 'navbar.php' ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script src="./js/productDetails.js"></script>

<div class="mx-4 " style="flex: 1" id="productSection">

    <div id="ProductDetails" class="w-50 mx-auto"></div>
   
    <div id="ProductGraph" class="w-50 mx-auto py-5">

        <h3 class="text-center">Confronto del prezzo del prodotto rispetto alla somma dei prodotti</h3>

        <canvas id="pieChart"></canvas>

        <h3 class="text-center"> Confronto del prezzo del prodotto rispetto al prezzo medio </h3>

        <canvas id="barChart"></canvas>

    </div>

    
</div>

<?php include_once 'footer.php' ?>