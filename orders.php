<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Orders</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="style.css">
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


            if(isset($_POST['clean'])) {
                ob_end_flush();
            }

            if(isset($_POST['submit'])) { //show all info button
                if(!isset($_SESSION["username"])){
                    header("Location: login.php");
                    exit(); 
                }
                else{
                    ob_start();
                    $status = $_POST['optradio'];

                    $sql = "select o.status, count(unit_price) as 'Total Orders', sum(unit_price) as 'Total Sum'
	from orders o, order_items oi, products p
	where o.ORDER_ID=oi.ORDER_ID and oi.PRODUCT_ID=p.PRODUCT_ID and o.STATUS = '$status'
    group by o.status"; 

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        echo "<table class='table table-hover table-bordered table-striped'><tr><th>Status</th><th>Total Orders</th><th>Total Sum</th></tr>";
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row["status"]."</td><td>".$row["Total Orders"]."</td><td>".$row["Total Sum"]."</td></tr>";
                        }
                    } else {
                        echo "0 records";
                    }
                } 
            }
            //  if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ?> 
            <div class="row text-center navBar">
                <ul class="nav nav-pills nav-justified">
                    <li role="presentation"><a href="home.php">Home</a></li>
                    <li role="presentation"><a href="DB2project.php">Customers</a></li>
                    <li role="presentation" class="active"><a href="orders.php">Orders</a></li>
                    <li role="presentation"><a href="products.php">Products</a></li>
                    <li role="presentation"><a href="profit.php">Profit</a></li>
                </ul>
            </div>
            <div class="row desc">
                <form class="form" action="" method="POST">
                    <h3><b>Total quantity and total sum of orders by status</b></h3>
                    <br>
                    <div class="radio">
                        <label><input type="radio" name="optradio" value="Shipped" checked>Shipped</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio" <?php if(isset($status) && $status=="Pending") echo "checked";?> value="Pending">Pending</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio" <?php if(isset($status) && $status=="Canceled") echo "checked";?> value="Canceled">Canceled</label>
                    </div>

                    <div class="form-inline">
                        <div class="form-group">
                            <input type="submit" name="submit" value="Submit" class="info_buttons btn btn-primary">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="clean" value="Clean" class="info_buttons btn btn-danger">
                        </div>
                    </div>
                </form>
            </div>


            <div class="row">

                <br><br>
                <h3><i>Output:</i></h3>
            </div>

            <?php



            ?>


        </div> <!--end container-->
    </body>
</html>