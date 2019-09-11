<?php
include "DB.php";
require_once ("Sessions.php");
?>

<?php
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}

function Login_attempt($Username,$Password){

    global $Connection;
    $Query = "SELECT * FROM admin_registration WHERE username = '$Username' AND password = '$Password'";
        $Execute = mysqli_query($Connection,$Query);
    if ($admin = mysqli_fetch_assoc($Execute)){
        return $admin;

    }
    else{
        return null;
    }

}

function Login(){
    if (isset($_SESSION["User_id"])){
        return true;

    }
}

function Confirm_Login(){
    if (!Login()){
        $_SESSION["ErrorMessage"]= "Login Required";
        Redirect_to("Login.php");
    }
}
?>