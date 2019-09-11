<?php
include "Include/Sessions.php";
include "Include/Functions.php";
include "Include/DB.php";
Confirm_Login();
?>

<?php

if (isset($_GET['id'])){

    $IdFromURL = $_GET['id'];
    global $Connection;

    $Query = "DELETE FROM category WHERE ID = '$IdFromURL'";
    $Execute = mysqli_query($Connection,$Query);

    if ($Execute){
        $_SESSION["SuccessMessage"] = "Category Deleted";
        Redirect_to("Category.php");
    }
    else{
        $_SESSION["EroorMessage"] = "Category Not Deleted";
        Redirect_to("Category.php");
    }

}
?>
