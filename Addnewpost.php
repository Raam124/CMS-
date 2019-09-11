<?php
include "Include/DB.php";
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
Confirm_Login();
?>
<?php
if (isset($_POST["Submit"])){
    $Title=($_POST["Title"]);
    $Category=($_POST["Category"]);
    $Post = ($_POST["Post"]);
    $CurrentTime = time();
    $DateTime=strftime("%B-%d-%Y %H: %M: %S",$CurrentTime);
    $DateTime;
    $Admin= $_SESSION["Username"];
    $image = $_FILES["image"]["name"];
    $Target="Upload/".basename($_FILES["image"]["name"]);

    if (empty($Title)){
        $_SESSION["ErrorMessage"]= "Title can't be empty";
        Redirect_to("Addnewpost.php");


    }
    elseif (strlen($Title)<5){
        $_SESSION["ErrorMessage"]="Title Too Short";
        Redirect_to("Addnewpost.php");

    }
    else{
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


        global $Connection;


        $Query = "INSERT INTO adminpanel(datetime,title,category,author,image,post)
VALUES ('$DateTime','$Title','$Category','$Admin','$image','$Post')";

        $Execute = mysqli_query($Connection,$Query);

        move_uploaded_file($_FILES["image"]["tmp_name"],$Target);

        if ($Execute){
            $_SESSION["SuccessMessage"] = "Post Added Successfully";
            Redirect_to("Addnewpost.php");
        }
        else{
            $_SESSION["ErrorMessage"] = "Post Failed to Add";
            Redirect_to("Addnewpost.php");
        }


    }
}

?>


<html>

<head>
    <title>Add New Post</title>
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
                <a class="flex-sm-fill nav-link active" href="Addnewpost.php">Add New Post</a>
                <a class="flex-sm-fill nav-link " href="Categories.php">Categories  </a>
                <a class="flex-sm-fill nav-link" href="Comments.php">Comments </a>
                <a class="flex-sm-fill nav-link" href="Admins.php">Manage Admins  </a>
                <a class="flex-sm-fill nav-link" href="#">Live Blog  </a>
                <a class="flex-sm-fill  nav-link" href="LogOut.php">Log Out  </a>




            </nav>
        </div> <!--ending of side area-->
        <div class="col-sm-10">
            <h4>Add New Post</h4>
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <div>
                <form action="Addnewpost.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="title"> </label>
                            <input class="form-control" type="text" name="Title" placeholder="Title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="categoryselect">Catergory Select: </label>
                            <select class="form-control" id="categoryselect" name="Category">

                                <?php

                               global $Connection;
                                $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
                                $Execute = mysqli_query($Connection,$ViewQuery);

                                while ($DataRows = mysqli_fetch_array($Execute)){
                                    $ID = $DataRows["ID"];
                                    $Categoryname = $DataRows["name"];

                                ?>
                                <option> <?php echo $Categoryname ?></option>
                                <?php }?>







                            </select>
                        </div>

                        <div class="form-group">
                            <label for="imageselect">Select Image: </label>
                            <input type="file" class="form-control" name="image" id="imageselect">
                        </div>
                        <div class="form-group">
                            <label for="postarea">Post: </label>
                            <textarea class="form-control" name="Post" id="postarea" ></textarea>
                        </div>
                        <br>
                        <input class="btn btn-success btn-block " type="Submit" name="Submit" value="Add New Post">
                        <br>
                    </fieldset>


                </form>
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