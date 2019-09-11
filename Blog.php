<?php
require_once ("Include/DB.php");
require_once ("Include/Sessions.php");
require_once ("Include/Functions.php");
?>
<!DOCTYPE>

<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Blog Post</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/blog.css">

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
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-item">
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



    <div class="row">
        <div  class="col-sm-7">
            <?php

            global $Connection;
                //Search Button
            if (isset($_GET["SearchButton"])){
                // search post code
                $Search = $_GET["Search"];
                $ViewQuery = "SELECT * FROM adminpanel 
                WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE  '%$Search%' OR post LIKE '%$Search%'";


            }
            // Category wise active
            elseif (isset($_GET["Category"])){
                $Category = $_GET["Category"];
              $ViewQuery = "SELECT * FROM adminpanel WHERE category = '$Category' ORDER BY datetime desc";
            }

            //Pagination
            elseif (isset($_GET["Page"])){

                $Page = $_GET["Page"];
                if ($Page==0 || $Page <1){
                    $ShowPostFrom = 0;
                }

                $ShowPostFrom = ($Page*5)-5;


                $ViewQuery = "SELECT * FROM adminpanel ORDER BY datetime desc LIMIT $ShowPostFrom,5";

            }
            //Default
            else {
                $ViewQuery = "SELECT * FROM adminpanel ORDER BY datetime desc LIMIT 0,5";
            }


            $Execute=mysqli_query($Connection,$ViewQuery) or die( mysqli_error($Connection));

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
                        Catergory: <?php echo htmlentities($Category);?>
                        <br>
                        Published On: <?php echo htmlentities($DateTime);?>
                    </p>

                    <p>
                    <?php
                    global $Connection;
                    $QueryComment = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$PostID'";
                    $ExecuteComments = mysqli_query($Connection,$QueryComment);
                    $RowsComment = mysqli_fetch_array($ExecuteComments);
                    $TotalComments=array_shift($RowsComment);
                    if ($TotalComments>0)
                    {

                        ?>
                        <div>
                                <span class="badge badge-primary">
                                    Comments :
                                <?php
                                echo $TotalComments;
                                ?>
                                </span>
                        </div>
                    <?php } ?>

                    </p>

                    <p class="post">

                       <?php
                       if (strlen($Post)>150){
                           $Post=substr($Post,0,150).'....... ';
                       }
                       echo htmlentities($Post);?>

                    </p>


                </div>
                <a href="FullPost.php?id=<?php echo $PostID; ?>"><span class="btn btn-info">Read Full Article &rsaquo;&rsaquo; </span></a>


            </div>
            <?php } ?>
            <nav >

            <ul class="pagination">

                <?php
                if (isset($_GET["Page"])) {
                    if ($Page > 1) {
                        ?>
                        <li class="page-item page-link"><a href="Blog.php?Page=<?php echo $Page-1; ?>">&laquo;</a></li>
                    <?php }
                }?>


            <?php
            global $Connection;

            $QueryPagination = "SELECT COUNT(*) FROM adminpanel";
            $ExecutePagination = mysqli_query($Connection,$QueryPagination);
            $RowPagination = mysqli_fetch_array($ExecutePagination);
            $TotalPosts = array_shift($RowPagination);


            $PostPerPage = $TotalPosts/5;
            $PostPerPage = ceil($PostPerPage);

            for ($i=1;$i<=$PostPerPage;$i++){
                if (isset($Page)) {
                    if ($i == $Page) {
                        ?>
                        <li class="page-item active"><a class="page-link"
                                                        href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php
                    } else { ?>
                        <li class="page-item"><a class="page-link"
                                                 href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php
                    }
                }
            } ?>

                    <?php
                    if (isset($_GET["Page"])) {
                        if ($Page+1<=$PostPerPage) {
                            ?>
                            <li class="page-item page-link"><a href="Blog.php?Page=<?php echo $Page+1; ?>">&raquo;</a></li>
                        <?php }
                    }?>

                </ul>
            </nav>

        </div>

        <div  style="margin: fill" class="col-sm-3">


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
                            <img class="embed-responsive" src="Upload/<?php echo $Image; ?>" width="300px;" height="170px;">
                            <a style="text-decoration: none" href="FullPost.php?id=<?php echo $ID; ?>">
                                <h6 class="TrendingHead"><?php echo htmlentities($Title); ?></h6>
                            </a>
                            <p class="TrendingDate"><?php echo htmlentities($DateTime)?></p>
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


            <br><br>

            <div class="card">
                <div class="card-header">
                    Trending Topics
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
                            <img class="embed-responsive" src="Upload/<?php echo $Image; ?>" width="300px;" height="170px;">
                            <a style="text-decoration: none" href="FullPost.php?id=<?php echo $ID; ?>">
                                <h6 class="TrendingHead"><?php echo htmlentities($Title); ?></h6>
                            </a>
                            <p class="TrendingDate"><?php echo htmlentities($DateTime)?></p>
                            <hr>
                        </div>

                    <?php } ?>


                </div>
                <div class="card-footer">
                    Footer
                </div>
            </div>





        </div>

    </div>



</div>

<div class="Line" style="height: 25px; background: red"></div>
<div id="Footer">

    <p> Themy by | Raam | sdsdsddsgds | sdsdgsdgds | dfgdgd ----- Reseverd</p>

    <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold;" href="#">
        <p>
            asvjksbdjkdskgj ejnfkdsjnkjsdnkj kjenfjdsnfjksdn <br> erjibvsdkjnvdkjngv gdsbbkjsdbbkgjds sefsdfsdg
        </p>
    </a>

</div>
</body>






</body>

</html>