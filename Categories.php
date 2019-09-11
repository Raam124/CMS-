<?php
require_once ("Include/DB.php");
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
Confirm_Login();
?>
<?php
if (isset($_POST["Submit"])){
    $Category=($_POST["Category"]);
    $CurrentTime = time();
    $DateTime=strftime("%B-%d-%Y %H: %M: %S",$CurrentTime);
    $DateTime;
    $Admin= $_SESSION["Username"];;
    if (empty($Category)){
        $_SESSION["ErrorMessage"]= "All Fields Must Be Filled Out";
        Redirect_to("Dashboard.php");


    }
    elseif (strlen($Category)>99){
        $_SESSION["ErrorMessage"]="Too Long Name";
        Redirect_to("Categories.php");

    }
    else{
        global $Connection;
        $Query = "INSERT INTO category (datetime,name,creatorname)
                VALUES ('$DateTime','$Category','$Admin')";

        $Execute = mysqli_query($Connection,$Query);
        if ($Execute){
            $_SESSION["SuccessMessage"] = "Category Added Successfully";
            Redirect_to("Categories.php");
        }
        else{
            $_SESSION["ErrorMessage"] = "Category Failed to Add";
            Redirect_to("Categories.php");
        }


    }
}

?>


<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js">  </script>
    <link rel="stylesheet" href="css/admin.css">


</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <h2> MyDrugUse </h2>
            <nav id="Side_Menu" class="nav nav-pills flex-column flex-sm-row">

                <a class="flex-sm-fill nav-link" href="Dashboard.php">Dashboard</a>
                <a class="flex-sm-fill nav-link" href="Addnewpost.php">Add New Post</a>
                <a class="flex-sm-fill nav-link active" href="Categories.php">Categories  </a>
                <a class="flex-sm-fill nav-link" href="Comments.php">Comments </a>
                <a class="flex-sm-fill nav-link" href="Admins.php">Manage Admins  </a>
                <a class="flex-sm-fill nav-link" href="#">Live Blog  </a>
                <a class="flex-sm-fill  nav-link" href="LogOut.php">Log Out  </a>




            </nav>
        </div> <!--ending of side area-->
        <div class="col-sm-10">
            <h4>Managing Category</h4>
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <div>
                <form action="Categories.php" method="post">
                    <fieldset>
                        <div class="form-group">
                        <label for="catergoryname"> </label>
                        <input class="form-control" type="text" name="Category" placeholder="Name" id="catergoryname">
                        </div>
                        <br>
                        <input class="btn btn-success btn-block " type="Submit" name="Submit" value="Add New Category">
                        <br>
                    </fieldset>


                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table ">
                    <tr>
                        <th>SR NO.</th>
                        <th>Date & Time</th>
                        <th>Category Name</th>
                        <th>Creator Name</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    global $Connection;
                    $ViewQuery = "SELECT * FROM category ORDER BY datetime desc ";
                    $Execute=mysqli_query($Connection,$ViewQuery);
                    $SrNo=0;
                    while ($DataRows=mysqli_fetch_array($Execute)){
                        $ID = $DataRows["ID"];
                        $DateTime=$DataRows["datetime"];
                        $CategoryName=$DataRows["name"];
                        $CreatorName=$DataRows["creatorname"];
                        $SrNo++ ;


                    ?>
                    <tr>
                        <td><?php echo $SrNo ?></td>
                        <td><?php echo $DateTime ?></td>
                        <td><?php echo $CategoryName ?></td>
                        <td><?php echo $CreatorName ?></td>
                        <td>
                            <a href="DeleteCategory.php?id=<?php echo $ID; ?>">
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