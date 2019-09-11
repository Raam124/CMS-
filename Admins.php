<?php
require_once ("Include/DB.php");
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
Confirm_Login();
?>
<?php
if (isset($_POST["Submit"])){
    $UserName=($_POST["Username"]);
    $Password=($_POST["Password"]);
    $ConfirmPassword=($_POST["ConfirmPassword"]);
    $CurrentTime = time();
    $DateTime=strftime("%B-%d-%Y %H: %M: %S",$CurrentTime);
    $DateTime;
    $Admin= $_SESSION["Username"];
    if (empty($UserName|| $Password || $ConfirmPassword)){
        $_SESSION["ErrorMessage"]= "All Fields Must Be Filled Out";
        Redirect_to("Admins.php");


    }
    elseif (strlen($Password)<4){
        $_SESSION["ErrorMessage"]="At least 4 characters Required";
        Redirect_to("Admins.php");

    }
    elseif ($Password!==$ConfirmPassword){
        $_SESSION["ErrorMessage"]="Passwords Not Match";
        Redirect_to("Admins.php");
    }
    else{
        global $Connection;
        $Query = "INSERT INTO admin_registration (datetime,username,password,addedby)
                VALUES ('$DateTime','$UserName','$Password','$Admin')";

        $Execute = mysqli_query($Connection,$Query);
        if ($Execute){
            $_SESSION["SuccessMessage"] = "Admin Added Successfully";
            Redirect_to("Admins.php");
        }
        else{
            $_SESSION["ErrorMessage"] = "Failed to Add";
            Redirect_to("Admins.php");
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
<div class="Line" style="height: 25px; background: white"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <h2> MyDrugUse </h2>
            <nav id="Side_Menu" class="nav nav-pills flex-column flex-sm-row">

                <a class="flex-sm-fill nav-link" href="Dashboard.php">Dashboard</a>
                <a class="flex-sm-fill nav-link" href="Addnewpost.php">Add New Post</a>
                <a class="flex-sm-fill nav-link " href="Categories.php">Categories  </a>
                <a class="flex-sm-fill nav-link" href="Comments.php">Comments </a>
                <a class="flex-sm-fill nav-link active" href="Admins.php">Manage Admins  </a>
                <a class="flex-sm-fill nav-link" href="#">Live Blog  </a>
                <a class="flex-sm-fill  nav-link" href="LogOut.php">Log Out  </a>




            </nav>

        </div> <!--ending of side area-->
        <div class="col-sm-10">

            <h4>Managing Admins</h4>
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <div>
                <form action="Admins.php" method="post">
                    <fieldset>
                        <div class="form-group">
                            <label for="Username"> </label>
                            <input class="form-control" type="text" name="Username" placeholder="User Name" id="Username">
                        </div>
                        <div class="form-group">
                            <label for="Password"> </label>
                            <input class="form-control" type="text" name="Password" placeholder="Password" id="Password">
                        </div>
                        <div class="form-group">
                            <label for="ConfirmPassword"> </label>
                            <input class="form-control" type="text" name="ConfirmPassword" placeholder="Confirm Password" id="ConfirmPassword">
                        </div>
                        <br>
                        <input class="btn btn-success btn-block " type="Submit" name="Submit" value="Add New Admin">
                        <br>
                    </fieldset>


                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table ">
                    <tr>
                        <th>SR NO.</th>
                        <th>Date & Time</th>
                        <th>Admin Name</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    global $Connection;
                    $ViewQuery = "SELECT * FROM admin_registration ORDER BY datetime desc ";
                    $Execute=mysqli_query($Connection,$ViewQuery);
                    $SrNo=0;
                    while ($DataRows=mysqli_fetch_array($Execute)){

                        $ID = $DataRows["ID"];
                        $UserName = $DataRows["username"];
                        $DateTime=$DataRows["datetime"];
                        $Addedby=$DataRows["addedby"];

                        $SrNo++ ;


                        ?>
                        <tr>
                            <td><?php echo $SrNo ?></td>
                            <td><?php echo $UserName ?></td>
                            <td><?php echo $DateTime ?></td>
                            <td><?php echo $Addedby ?></td>

                            <td>
                                <a href="DeleteAdmin.php?id=<?php echo $ID; ?>">
                                    <span class="btn btn-danger"> Delete </span>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div> <!-- ending of main area -->
    </div>
</div>
<div id="Footer">

    <p> THemy by | Raam | sdsdsddsgds | sdsdgsdgds | dfgdgd ----- Reseverd</p>

    <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold;" href="#">
        <p>
            asvjksbdjkdskgj ejnfkdsjnkjsdnkj kjenfjdsnfjksdn <br> erjibvsdkjnvdkjngv gdsbbkjsdbbkgjds sefsdfsdg
        </p>
    </a>

</div>
</body>




</html>