   <?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>

    <script src="./js/login.js"></script>

    <div class="row w-100">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <form>
                <label class="w-25">username: </label> <input type="text" id="user" class="form-control w-100 my-2"> 
                <label class="w-25">password: </label> <input type="password" id="pass" class="form-control w-100 my-2"> 
                <input type="button" class="btn btn-success w-100 mt-5" onclick="login()" value="Entra">  
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>

    <?php include_once 'footer.php' ?>