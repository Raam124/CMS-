<?php
require_once ("Include/DB.php");
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
?>

<?php
if (isset($_POST["Submit"])){
    $Name=($_POST["Name"]);
    $Email=($_POST["Email"]);
    $Comment=($_POST["Comment"]);
    $CurrentTime = time();
    $DateTime=strftime("%B-%d-%Y %H: %M: %S",$CurrentTime);
    $DateTime;
    $PostID = $_GET['id'];

    if (empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"]= "can't be empty";



    }
    elseif (strlen($Comment)>500){
        $_SESSION["ErrorMessage"]="Too long Comment";


    }
    else{
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


        global $Connection;
        $PostIDFromURLComment = $_GET['id'];

        $Query = "INSERT INTO comments (datetime,name,email,comment,status,admin_panel_id) 
                  VALUES ('$DateTime','$Name','$Email','$Comment','ON','$PostIDFromURLComment')";


        $Execute = mysqli_query($Connection,$Query);



        if ($Execute){
            $_SESSION["SuccessMessage"] = "Comment Submitted Successfully";
            Redirect_to("FullPost.php?id={$PostID}");
        }
        else{
            $_SESSION["ErrorMessage"] = "Comment Failed to Add";
            Redirect_to("FullPost.php?id={$PostID}");
        }


    }
}

?>





<!DOCTYPE>

<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Full Blog Post</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/blog.css">
    <link rel="stylesheet" href="css/Comment.css">

</head>
<body>

<div style="height: 10px; background: red;"></div>





<nav style="margin: fill" class="navbar navbar-expand-xl navbar-light bg-light">

    <a class="navbar-brand" href="#">TeenPeople</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Blog.php">Blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    More Here
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">AboutUs</a>
                    <a class="dropdown-item" href="#">Contact Us</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Features</a>
                </div>
            </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" name="SearchButton">Search</button>
        </form>

    </div>
</nav>

<div class="Line" style="height: 25px; background: white"></div>

<div class="container-fluid">
    <div class="blog-header">
        <h1>The complete Responsive CMS Blog</h1>
        <p class="lead">the complete responsive cms for my dream product</p>
    </div>

    <div  class="row">
        <div class="col-sm-8">
            <?php

            global $Connection;

            if (isset($_GET["SearchButton"])){
                $Search = $_GET["Search"];
                $ViewQuery = "SELECT * FROM adminpanel 
                WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE  '%$Search%' OR post LIKE '%$Search%'";
            }
            else {

                $PostIDFromURL = $_GET["id"];

                $ViewQuery = "SELECT * FROM adminpanel WHERE ID = '$PostIDFromURL'
                ORDER BY datetime desc";
            }

            $Execute=mysqli_query($Connection,$ViewQuery);
            while ($DataRows=mysqli_fetch_array ($Execute)){

                $PostID = $DataRows["ID"];
                $DateTime = $DataRows["datetime"];
                $Title = $DataRows["title"];
                $Category = $DataRows["category"];
                $Author = $DataRows["author"];
                $Image = $DataRows["image"];
                $Post = $DataRows["post"];




                ?>
                <div class=" blogpost img-thumbnail">

                    <img src="Upload/<?php echo $Image ?>" class="img-fluid">
                    <div class="figure-caption">
                        <h3 id="heading"> <?php echo htmlentities($Title); ?></h3>
                        <p class="description">
                            Category: <?php echo htmlentities($Category);?>
                            <br>
                            Published On: <?php echo htmlentities($DateTime);?>
                        </p>
                        <p class="post">

                            <?php

                            echo nl2br($Post);?>

                        </p>


                    </div>



                </div>
            <?php } ?>

            <div>
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>

                <?php
                global $Connection;
                $PostIDForComments = $_GET['id'];

                $ExtractingCommentsQuery = "SELECT * FROM comments WHERE admin_panel_id = '$PostIDForComments' AND status = 'ON'";
                $Execute = mysqli_query($Connection,$ExtractingCommentsQuery);
                while($DataRows = mysqli_fetch_array($Execute)){
                    $CommentDate = $DataRows['datetime'];
                    $CommenterName = $DataRows['name'];
                    $Comments = $DataRows['comment'];


                ?>
                   <div class="CommentBlock">
                       <img class="imagecl float-left" src="Images/comment.jpg" width="90px;" height="110px;">
                       <p class="CommentName"> <?php echo $CommenterName; ?> </p>
                       <p class="CommentDate"> <?php echo $CommentDate; ?> </p>
                       <p class="Comments"> <?php echo$Comments; ?> </p>
                   </div> 
                    <br>
                    <hr>

                <?php }?>

                <form action="FullPost.php?id=<?php echo $PostID; ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input style="width: fit-content;" class="form-control" type="text" name="Name" placeholder="Name" id="Name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="text" name="Email" placeholder="Email" id="Email">
                        </div>


                        <div class="form-group">
                            <label for="commentarea">Comment</label>
                            <textarea class="form-control" name="Comment" id="Commentarea" ></textarea>
                        </div>
                        <br>
                        <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
                        <br>
                    </fieldset>


                </form>
            </div>


        </div>

        <div class="col-sm-4 mx-auto">

            <div class="card">
                <div class="card-header">
                    Recent Posts
                </div>
                <div class="card-body">
                    <?php
                    global $Connection;
                    $ViewQuery = "SELECT * FROM adminpanel ORDER BY datetime LIMIT 0,5";
                    $Execute = mysqli_query($Connection,$ViewQuery);
                    while ($DataRows=mysqli_fetch_array($Execute)){
                        $ID = $DataRows["ID"];
                        $Title = $DataRows["title"];
                        $Datetime = $DataRows["datetime"];
                        $Image = $DataRows["image"];
                        if (strlen($DateTime)>15) {
                            $DateTime = substr($DateTime, 0, 15);
                        }
                        ?>

                        <div>
                            <img class="float-left" src="Upload/<?php echo $Image; ?>" width="85px;" height="70px;">
                            <a style="text-decoration: none" href="FullPost.php?id=<?php echo $ID; ?>">
                                <h6 class="RecentHeading"><?php echo htmlentities($Title); ?></h6>
                            </a>
                            <p class="RecentDate"><?php echo htmlentities($DateTime)?></p>
                            <hr>
                        </div>

                    <?php } ?>

                </div>
                <div class="card-footer">
                    Footer
                </div>

            </div>


            <br><br>
            <div class="card">
                <div class="card-header">
                    Surf Categories
                </div>
                <div class="card-body">

                    <?php
                    global $Connection;
                    $ViewQuery = "SELECT * FROM category";
                    $Execute = mysqli_query($Connection,$ViewQuery);
                    while ($DataRows = mysqli_fetch_array($Execute)){
                        $ID = $DataRows["ID"];
                        $Category = $DataRows["name"];
                        ?>
                        <a style="text-decoration: none" href="Blog.php?Category=<?php echo $Category; ?>">
                            <span id="headingCategory"><?php echo $Category."<br>"; ?></span>
                        </a>
                    <?php } ?>
                </div>
                <div class="card-footer">
                    Footer
                </div>
            </div>





    </div>



</div>

    <div class="container-fluid"
<div class="Line" style="height: 25px; background: red"></div>
    <div id="Footer">

        <p> Themy by | Raam | sdsdsddsgds | sdsdgsdgds | dfgdgd ----- Reseverd</p>

        <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold;" href="#">
            <p>
                asvjksbdjkdskgj ejnfkdsjnkjsdnkj kjenfjdsnfjksdn <br> erjibvsdkjnvdkjngv gdsbbkjsdbbkgjds sefsdfsdg
            </p>
        </a>

    </div>
</div>
</body>






</body>

</html>