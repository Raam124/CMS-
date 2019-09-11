<?php
require_once ("Include/DB.php");
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
?>
<?php
if (isset($_POST["Submit"])){
    $UserName=($_POST["Username"]);
    $Password=($_POST["Password"]);


    if (empty($UserName|| $Password)){
        $_SESSION["ErrorMessage"]= "All Fields Must Be Filled Out";
        Redirect_to("Login.php");
    }

    else{
        $FoundAccount = Login_attempt($UserName,$Password);
        if ($FoundAccount){
            $_SESSION["User_id"] =  $FoundAccount["ID"];
            $_SESSION["Username"] = $FoundAccount["username"];
            $_SESSION["SuccessMessage"]= "Welcome {$_SESSION["Username"]}";
            Redirect_to("Dashboard.php");
        }
        else{
            echo "Not Worked";
            $_SESSION["ErrorMessage"]= "Failed";
            Redirect_to("Login.php");
        }
    }
}

?>


<html>

<head>
    <title>Admins Manage</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js">  </script>
    <link rel="stylesheet" href="css/admin.css">


</head>

<body>

        <div class="offset-sm-4 col-sm-4">


            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>



            <h4>Log In</h4>

            <div>
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <form action="Login.php" method="post">
                    <fieldset>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="text" name="Username" id="Username" class="form-control" placeholder="Name">
                        </div>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="password" name="Password" id="Password" class="form-control" placeholder="Password">
                        </div>

                        <br>
                        <input class="btn btn-info btn-block " type="Submit" name="Submit" value="Log In">
                        <br>
                    </fieldset>


                </form>
            </div>

        </div> <!-- ending of main area -->
    </div>
</div>

</body>




</html>