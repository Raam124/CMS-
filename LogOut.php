<?php
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
?>

<?php
$_SESSION["User_id"] = null;
session_destroy();
Redirect_to("Login.php")
?>
