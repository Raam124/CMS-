<?php
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
include "Include/DB.php";
Confirm_Login();
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

                <a class="flex-sm-fill nav-link active" href="Dashboard.php">Dashboard</a>
                <a class="flex-sm-fill nav-link" href="Addnewpost.php">Add New Post</a>
                <a class="flex-sm-fill nav-link" href="Categories.php">Categories  </a>
                <a class="flex-sm-fill nav-link" href="Comments.php">Comments </a>
                <a class="flex-sm-fill nav-link" href="Admins.php">Manage Admins  </a>
                <a class="flex-sm-fill nav-link" href="Blog.php?Page=1">Live Blog  </a>
                <a class="flex-sm-fill nav-link" href="LogOut.php">Log Out  </a>

            </nav>
        </div> <!--ending of side area-->
        <div class="col-sm-10">

            <div> <?php
                echo ErrorMessage();
                echo  SuccessMessage();
            ?> </div>
            <h4>Admin Dashboard </h4>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No</th>
                        <th>Post Title</th>
                        <th>Date Time</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                    </tr>

                    <?php
                    global $Connection;
                    $ViewQuery = "SELECT * FROM adminpanel ORDER BY datetime desc";
                    $Execute = mysqli_query($Connection,$ViewQuery);
                    $SrNo = 0;
                    while ($DataRows = mysqli_fetch_array($Execute)){

                        $PostID = $DataRows["ID"];
                        $DateTime = $DataRows["datetime"];
                        $Title = $DataRows["title"];
                        $Category = $DataRows["category"];
                        $Admin = $DataRows["author"];
                        $Image = $DataRows["image"];
                        $Post = $DataRows["post"];
                        $SrNo++;
                    ?>

                        <tr>
                            <td> <?php echo $SrNo; ?></td>
                            <td style="color: darkblue"> <?php
                                if (strlen($Title)>20){
                                    $Title = substr($Title,0,20).'..';
                                }
                                echo $Title;
                                ?></td>
                            <td> <?php
                                if (strlen($DateTime)>11){
                                    $DateTime = substr($DateTime,0,8).'..';
                                }
                                echo $DateTime;
                                ?></td>
                            <td> <?php echo $Admin; ?></td>
                            <td> <?php echo $Category; ?></td>
                            <td> <img src="Upload/<?php echo $Image; ?>" width="130px;" height="50px;" </td>
                            <td>

                                <?php
                                global $Connection;
                                $QueryComment = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$PostID'";
                                $ExecuteComments = mysqli_query($Connection,$QueryComment);
                                $RowsComment = mysqli_fetch_array($ExecuteComments);
                                $TotalComments=array_shift($RowsComment);
                                if ($TotalComments>0)
                                {

                                ?>
                                <div style="text-align: center">
                                <span class="badge badge-primary"  >
                                <?php
                                echo $TotalComments;
                                ?>
                                </span>
                                </div>
                                <?php } ?>


                            </td>
                            <td>
                                <a href="EditPost.php?id=<?php echo $PostID; ?>"><span class="btn btn-warning">Edit </span></a>
                                <a href="DeletePost.php?delete=<?php echo $PostID; ?>"><span class="btn btn-danger">Delete</span></a>
                            </td>
                            <td>
                                <a href="FullPost.php?id=<?php echo $PostID; ?>" target="_blank">
                                    <span class="btn btn-primary"> Live Preview</span> </a>
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