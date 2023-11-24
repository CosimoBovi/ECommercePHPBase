    <?php include_once 'header.php' ?>
    <?php include_once 'navbar.php' ?>

    <script src="./js/register.js"></script>

    <div class="row w-100">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <form id="registrationForm">
                <label class="w-25">Username: </label> <input type="text" id="username" class=" form-control w-100 my-2"> <br>
                <label class="w-25">email: </label> <input type="email" id="mail" class="form-control w-100 my-2"> <br>
                <label class="w-25">Password: </label> <input type="password" id="password" class=" form-control w-100 my-2"> <br>
                <label class="w-25">User Type: </label>
                <select id="userType" class="form-control w-100 my-2">
                    <!-- Opzioni per gli user types verranno caricate dinamicamente con JavaScript -->
                </select> <br>
                <input type="button" class="btn btn-success w-100 mt-3" onclick="registerUser()" value="Registrati">  
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>

    <?php include_once 'footer.php' ?>