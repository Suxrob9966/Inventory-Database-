<?php
session_start();
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            /* Add a gray background color and some padding to the footer */
            footer {
                background-color: #f2f2f2;
                padding: 25px;
            }
        </style>
        <link rel="stylesheet" href="style.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> <!--used for adding social media icons-->
    </head>
    <ul class="log nav navbar-nav navbar-right"> <!--this is added for login purposes-->
        <?php                           /*chernovoy dlya sign in page*/
        if(!isset($_SESSION["username"])){
            echo  "<li><a href='login.php'><span class='glyphicon glyphicon-user'></span> Login</a></li>";
        }
        else{
            echo  "<li><a href='logout.php'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
        }
        ?>  
    </ul>
    <body>
        <div class="container">
            <div class="row text-center navBar">
                <ul class="nav nav-pills nav-justified">
                    <li role="presentation" class="active"><a href="home.php">Home</a></li>
                    <li role="presentation"><a href="DB2project.php">Customers</a></li>
                    <li role="presentation"><a href="orders.php">Orders</a></li>
                    <li role="presentation"><a href="products.php">Products</a></li>
                    <li role="presentation"><a href="profit.php">Profit</a></li>
                </ul>
            </div>

            <div class="desc jumbotron">
                <div class="container text-center">
                    <h1>ALLIGATOR<br>INVENTORY COMPANY</h1>
                    <p>Quality Products all over the world</p>
                </div>
            </div>

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="RAM.jpg" alt="video card">
                        <div class="carousel-caption">
                            <h3>Video Cards</h3>
                        </div>
                    </div>

                    <div class="item">
                        <img src="Motherboard.jpg" alt="motherboard">
                        <div class="carousel-caption">
                            <h3>Mother Boards</h3>
                        </div>
                    </div>

                    <div class="item">
                        <img src="cpu.jpg" alt="cpu">
                        <div class="carousel-caption">
                            <h3>Last Generation CPUs</h3>
                        </div>
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="footer_back container-fluid text-center">
                <div class="row" id="bottomSection">
                    <div class="col-xs-4 text-center">
                        <a href="https://www.twitter.com"><i class="fa fa-twitter fa-3x" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="https://www.facebook.com"><i class="fa fa-facebook-official fa-3x" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="https://www.instagram.com"><i class="fa fa-instagram fa-3x" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
