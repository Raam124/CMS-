<?php
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
include "Include/DB.php";
Confirm_Login();
?>
<html>

<head>
    <title>Comments</title>
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
                <a class="flex-sm-fill nav-link" href="Categories.php">Categories  </a>
                <a class="flex-sm-fill nav-link active" href="Comments.php">Comments </a>
                <a class="flex-sm-fill nav-link" href="#">Manage Admins  </a>
                <a class="flex-sm-fill nav-link" href="#">Live Blog  </a>
                <a class="flex-sm-fill nav-link" href="LogOut.php">Log Out  </a>

            </nav>
        </div> <!--ending of side area-->
        <div class="col-sm-10">

            <div> <?php
                echo ErrorMessage();
                echo  SuccessMessage();
                ?>
            </div>



            <h4>All Comments</h4>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Comment</th>
                        <th>Delete Comment</th>
                        <th>Details</th>
                    </tr>

                    <?php
                    global $Connection;
                    $Query = "SELECT * FROM comments ORDER BY datetime desc";
                    $Execute = mysqli_query($Connection,$Query);
                    $SrNo=0;
                    while ($DataRows = mysqli_fetch_array($Execute)){

                        $CommentID = $DataRows['ID'];
                        $CommentDateTime = $DataRows['datetime'];
                        $PersonName = $DataRows['name'];
                        $Comment = $DataRows['comment'];
                        $CommentedPostID = $DataRows['admin_panel_id'];
                        $SrNo++;

                    if (strlen($PersonName)>10) {
                        $PersonName = substr($PersonName, 0, 10) . '.. ';
                    }
                        if (strlen($Comment)>18) {
                            $Comment = substr($Comment, 0, 18) . '.. ';
                        }
                        ?>
                        <tr>
                            <td><?php echo htmlentities($SrNo) ?></td>
                            <td><?php echo htmlentities($PersonName )?></td>
                            <td><?php echo htmlentities($CommentDateTime) ?></td>
                            <td><?php echo htmlentities($Comment) ?></td>

                            <td> <a href="DeleteComments.php?id=<?php echo $CommentID; ?>"><span class="btn btn-danger">Delete</span></a></td>
                            <td> <a href="FullPost.php?id=<?php echo $CommentedPostID; ?>"><span class="btn btn-primary">Live Preview</span></a></td>
                        </tr>
                    <?php  } ?>
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