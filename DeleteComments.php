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

    $Query = "DELETE FROM comments WHERE ID = '$IdFromURL'";
    $Execute = mysqli_query($Connection,$Query);

    if ($Execute){
        $_SESSION["SuccessMessage"] = "Commment Deleted";
        Redirect_to("Comments.php");
    }
    else{
        $_SESSION["EroorMessage"] = "Commment Not Deleted";
        Redirect_to("Comments.php");
    }

}
?>
