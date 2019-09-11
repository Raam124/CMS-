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

    $Query = "DELETE FROM admin_registration WHERE ID = '$IdFromURL'";
    $Execute = mysqli_query($Connection,$Query);

    if ($Execute){
        $_SESSION["SuccessMessage"] = "Deleted";
        Redirect_to("Admins.php");
    }
    else{
        $_SESSION["EroorMessage"] = "Deleted";
        Redirect_to("Admins.php");
    }

}
?>
