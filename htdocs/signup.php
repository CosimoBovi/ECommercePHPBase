
    
    <?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>

    <script src="./js/signup.js"></script>

    <div class="row w-100">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <form>
                <label class="w-25">username: </label> <input type="text" id="user" class="w-100 my-2"> 
                <label class="w-25">password: </label> <input type="password" id="pass" class="w-100 my-2"> 
                <label class="w-25">Tipo utente: </label> <select id="userTypeId" class="w-100 my-2"></select>
                <input type="button" class="btn btn-success w-100 mt-5" onclick="register()" value="Registrati">  
                <a href="./login.php"><input type="button" class="btn btn-success w-100 mt-5" value="Entra">  </a>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>

    <?php include_once 'footer.php' ?>
