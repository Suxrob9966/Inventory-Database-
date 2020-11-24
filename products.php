<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Products</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
    </head>
    <body>
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
        <div class="container">
            <?php
            require('db.php');
            $output="";
            if(isset($_POST['clean'])) {
                ob_end_flush();
            }



            ?> 
            <div class="row text-center navBar">
                <ul class="nav nav-pills nav-justified">
                    <li role="presentation"><a href="home.php">Home</a></li>
                    <li role="presentation"><a href="DB2project.php">Customers</a></li>
                    <li role="presentation"><a href="orders.php">Orders</a></li>
                    <li role="presentation" class="active"><a href="products.php">Products</a></li>
                    <li role="presentation"><a href="profit.php">Profit</a></li>
                </ul>
            </div>
            <div class="row">
                <form class="form" action="" method="POST">
                    <h3 class="desc"><b>I. Listing total quantity of products by product category</b></h3>
                    <br>
                    <h4 class="desc">Choose product category from dropdown button</h4>
                    <br>

                    <div class="form-group">
                        <div class="col-sm-3">
                            <select class="form-control" name="category" id="sel1">
                                <option selected>Select category</option>
                                <option <?php if (isset($category) && $category==1) echo "selected";?> value=1>CPU</option>
                                <option <?php if (isset($category) && $category==2) echo "selected";?> value=2> Video Card</option>
                                <option <?php if (isset($category) && $category==3) echo "selected";?> value="3">RAM</option>
                                <option <?php if (isset($category) && $category==4) echo "selected";?> value="4">Mother Board</option>
                                <option <?php if (isset($category) && $category==5) echo "selected";?> value="5" >Storage</option>
                            </select>
                        </div> 

                        <input type="submit" name="submit" value="Submit" class="info_buttons btn btn-success">

                        <input type="submit" name="clean" value="Clean" class="info_buttons btn btn-danger">

                    </div>

                </form>
            </div>


            <div class="row">

                <br><br>
                <h3><i>Output:</i></h3>
            </div>

            <?php

            if(isset($_POST['submit'])) { //show individually info button
                if(!isset($_SESSION["username"])){
                    header("Location: login.php");
                    exit(); 
                }
                else{
                    ob_start();
                    $category = $_POST['category'];

                    $sql = "select p.product_id, p.product_name, c.COUNTRY_NAME, sum(i.QUANTITY) as 'TOTAL QUANTITY'
	from products p, inventories i, warehouses w, locations l, countries c, product_categories pc
	where p.product_id = i.product_id and i.warehouse_id = w.warehouse_id and 
	pc.CATEGORY_ID = p.CATEGORY_ID and w.location_id = l.location_id and 
	pc.CATEGORY_ID = '$category' and l.country_id = c.country_id 
	group by p.PRODUCT_ID, p.PRODUCT_NAME,  c.COUNTRY_NAME
	order by p.PRODUCT_ID"; 

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        echo "<div class='table-wrapper-scroll-y my-custom-scrollbar'>"; //last added
                        echo "<table class='table table-hover table-bordered table-striped'><tr><th>Product ID</th><th>Product Name</th><th>Country</th><th>Total Quantity</th></tr>";
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row["product_id"]."</td><td>".$row["product_name"]."</td><td>".$row["COUNTRY_NAME"]."</td><td>".$row["TOTAL QUANTITY"]."</td></tr>";
                        }
                        echo "</table></div>"; //last added
                    } else {
                        $output = "0 records";
                    }
                } 
            }


            echo $output;


            ?>


        </div> <!--end container-->
    </body>
</html>