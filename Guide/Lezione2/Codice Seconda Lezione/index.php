<?php include_once "header.html" ?>
<?php include_once "navbar.html" ?>

<p>Questa è la home page</p>

<?php 
    session_start();

    if(isset($_SESSION["username"])){

        echo "ciao " . $_SESSION["username"];
    }

?>

<?php include_once "footer.html" ?>
