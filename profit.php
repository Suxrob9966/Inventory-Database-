<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profit</title>
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
            if(isset($_POST['clean'])) {
                ob_end_flush();
            }

            if(isset($_POST['submit3'])) { //show updated credit limit
                if(!isset($_SESSION["username"])){
                    header("Location: login.php");
                    exit(); 
                }
                else{
                    ob_start();
                    $percent = $_POST['percentage'];

                    $sql = "select c.customer_id, c.name, o.order_id, c.credit_limit, (c.credit_limit - c.credit_limit * '$percent'/100) as 'New Credit Limit'
	from customers c, orders o, order_items oi
	where c.customer_id = o.customer_id and o.order_id = oi.order_id 
	and oi.quantity in
			(select min(quantity) from order_items oi)
	order by c.customer_id;"; 

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        echo "<table class='table table-hover table-bordered table-striped'><tr><th>Customer_ID</th><th>Customer Name</th><th>Order_ID</th><th>Credit Limit</th><th>New Credit Limit</th></tr>";
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row["customer_id"]."</td><td>".$row["name"]."</td><td>".$row["order_id"]."</td><td>".$row["credit_limit"]."</td><td>".$row["New Credit Limit"]."</td></tr>";
                        }
                    } else {
                        echo "0 records";
                    }
                } 
            }

            if(isset($_POST['submit'])) { //show all info button
                if(!isset($_SESSION["username"])){
                    header("Location: login.php");
                    exit(); 
                }
                else{
                    ob_start();
                    $sql = "select w.WAREHOUSE_ID, w.WAREHOUSE_NAME, sum(STANDARD_COST) as 'TOTAL COST', 
            sum(list_price) as 'TOTAL SALE', sum(list_price)-sum(STANDARD_COST) as 'TOTAL PROFIT'  
                from products p, warehouses w, inventories i 
                where p.product_id=i.product_id and i.warehouse_id=w.warehouse_id
                group by w.WAREHOUSE_ID, w.WAREHOUSE_NAME
                order by sum(STANDARD_COST) DESC"; 

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        echo "<table class='table table-hover table-bordered table-striped'><tr><th>Warehouse_ID</th><th>Warehouse Name</th><th>Total Cost</th><th>Total Sale</th><th>Total Profit</th></tr>";
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row["WAREHOUSE_ID"]."</td><td>".$row["WAREHOUSE_NAME"]."</td><td>".$row["TOTAL COST"]."</td><td>".$row["TOTAL SALE"]."</td><td>".$row["TOTAL PROFIT"]."</td></tr>";
                        }
                    } else {
                        echo "0 records";
                    }
                } 
            }

            if(isset($_POST['submit2'])) { //show all info button
                if(!isset($_SESSION["username"])){
                    header("Location: login.php");
                    exit(); 
                }
                else{
                    ob_start();
                    $sql = "select w.WAREHOUSE_NAME, max(unit_price) AS 'MAX PRICE', min(unit_price) AS 'MIN PRICE', round(avg(unit_price)) as 'AVERAGE PRICE'
	from order_items oi, inventories i, warehouses w
	where oi.PRODUCT_ID=i.PRODUCT_ID and i.WAREHOUSE_ID=w.WAREHOUSE_ID
	group by w.WAREHOUSE_NAME"; 

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        echo "<table class='table table-hover table-bordered table-striped'><tr><th>Warehouse Name</th><th>MAX Price</th><th>MIN Price</th><th>AVG Price</th></tr>";
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row["WAREHOUSE_NAME"]."</td><td>".$row["MAX PRICE"]."</td><td>".$row["MIN PRICE"]."</td><td>".$row["AVERAGE PRICE"]."</td></tr>";
                        }
                    } else {
                        echo "0 records";
                    }
                } 
            }

            ?> 
            <div class="row text-center navBar">
                <ul class="nav nav-pills nav-justified">
                    <li role="presentation"><a href="home.php">Home</a></li>
                    <li role="presentation"><a href="DB2project.php">Customers</a></li>
                    <li role="presentation"><a href="orders.php">Orders</a></li>
                    <li role="presentation"><a href="products.php">Products</a></li>
                    <li role="presentation" class="active"><a href="profit.php">Profit</a></li>
                </ul>
            </div>
            <div class="row">
                <form class="form" action="" method="POST">
                    <h3 class="desc"><b>I. Show total profit of all warehouses sorted high to low</b></h3>
                    <br>

                    <div class="form-group">

                        <input type="submit" name="submit" value="Submit" class="info_buttons btn btn-success">

                        <input type="submit" name="clean" value="Clean" class="info_buttons btn btn-danger">

                    </div>
                </form>
            </div>

            <div class="row">
                <form class="form" action="" method="POST">
                    <h3 class="desc"><b>II. Show MAX, MIN, AVG Price in all warehouses</b></h3>
                    <br>

                    <div class="form-group">

                        <input type="submit" name="submit2" value="Submit" class="info_buttons btn btn-success">

                        <input type="submit" name="clean" value="Clean" class="info_buttons btn btn-danger">

                    </div>
                </form>
            </div>

            <div class="row desc">
                <form class="form" action="" method="POST">
                    <h3 class="desc"><b>III. Decreasing credit limit of customers who made the minimum quantity orders by select %</b></h3>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <select class="form-control" name="percentage" id="sel1">
                                <option selected>Select percentage</option>
                                <option <?php if (isset($percent) && $percent==5) echo "selected";?> value=5>5</option>
                                <option <?php if (isset($percent) && $percent==10) echo "selected";?> value=10>10</option>
                                <option <?php if (isset($percent) && $percent==15) echo "selected";?> value=15>15</option>
                                <option <?php if (isset($percent) && $percent==20) echo "selected";?> value=20>20</option>
                            </select>
                        </div> 

                        <input type="submit" name="submit3" value="Submit" class="info_buttons btn btn-success">

                        <input type="submit" name="clean" value="Clean" class="info_buttons btn btn-danger">

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