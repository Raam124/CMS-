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
    $Admin= "Raam";
    $image = $_FILES["image"]["name"];
    $Target="Upload/".basename($_FILES["image"]["name"]);



        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


        global $Connection;
        $DeleteFromURL = $_GET['delete'];


        $Query = "DELETE FROM adminpanel WHERE ID = '$DeleteFromURL'";

        $Execute = mysqli_query($Connection,$Query);

        move_uploaded_file($_FILES["image"]["tmp_name"],$Target);

        if ($Execute){
            $_SESSION["SuccessMessage"] = "Post Deleted Successfully";
            Redirect_to("Dashboard.php");
        }
        else{
            $_SESSION["ErrorMessage"] = "Post Failed to Delete";
            Redirect_to("Dashboard.php");
        }



}

?>


<html>

<head>
    <title>Delete Post</title>
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
            <h4>Delete Post</h4>
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <div>
                <?php
                $SearchQueryParameter = $_GET['delete'];
                global $Connection;

                $Query = "SELECT * FROM adminpanel WHERE ID = '$SearchQueryParameter'";
                $ExecuteQuery = mysqli_query($Connection,$Query);

                while ($DataRows = mysqli_fetch_array($ExecuteQuery)){

                    $TitleToBeUpdated = $DataRows['title'];
                    $CategoryToBeUpdated = $DataRows['category'];
                    $ImageToBeUpdated = $DataRows['image'];
                    $PostToBeUpdated = $DataRows['post'];
                }

                ?>
                <form action="DeletePost.php?delete=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="title"> </label>
                            <input disabled class="form-control" value="<?php echo $TitleToBeUpdated  ?>" type="text" name="Title" placeholder="Title" id="title">
                        </div>
                        <div class="form-group">
                            <span class="btn-warning"> Existing Category:</span>
                            <?php echo  $CategoryToBeUpdated ?>
                            <br>
                            <label for="categoryselect">Catergory Select: </label>
                            <select disabled class="form-control" id="categoryselect" name="Category">

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
                            <span class="btn-primary">Existing Image</span>
                            <img style="height: 150px; width: 200px;" src="Upload/<?php echo $ImageToBeUpdated ?>">
                            <br>
                            <label for="imageselect">Select Image: </label>
                            <input disabled type="file" class="form-control" name="image" id="imageselect">
                        </div>
                        <div class="form-group">
                            <label for="postarea">Post: </label>
                            <textarea  disabled class="form-control" name="Post" id="postarea" >
                                <?php echo $PostToBeUpdated ?>

                            </textarea>
                        </div>
                        <br>
                        <input class="btn btn-danger btn-block " type="Submit" name="Submit" value="Delete Post">
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