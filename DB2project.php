<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>DB2 Project</title>
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
            $output="";
            if(isset($_POST['clean'])) {
                ob_end_flush();
            }

            ?>  

            <div class="row text-center navBar">
                <ul class="nav nav-pills nav-justified">
                    <li role="presentation"><a href="home.php">Home</a></li>
                    <li role="presentation" class="active"><a href="DB2project.php">Customers</a></li>
                    <li role="presentation"><a href="orders.php">Orders</a></li>
                    <li role="presentation"><a href="products.php">Products</a></li>
                    <li role="presentation"><a href="profit.php">Profit</a></li>
                </ul>
            </div>
            <div class="row desc">
                <form class="form" action="" method="POST">
                    <h3><b>I. Customer Information</b></h3>
                    <br>
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="id">ID:</label>
                            <input type="text" name="id" class="form-control" placeholder="Enter Customer ID">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit1" value="Submit" class="info_buttons btn btn-primary">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="button1" value="Show all" class="info_buttons btn btn-success">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="clean" value="Clean" class="info_buttons btn btn-danger">
                        </div>
                    </div>
                </form>
            </div>


            <div class="row desc">
                <form class="form" action="" method="POST">
                    <h3><b>II. Total spending of Customers</b></h3>
                    <br>
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="id">ID:</label>
                            <input type="number" name="id" class="form-control" placeholder="Enter Customer ID">
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Customer Name">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit2" value="Submit" class="form-control info_buttons btn-primary">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="button2" value="Show all" class="form-control info_buttons btn-success">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="clean" value="Clean" class="form-control info_buttons btn-danger">
                        </div>
                    </div>
                </form>
            </div>




            <div class="row desc">
                <form class="form" action="" method="POST">
                    <h3><b>III. Customers and their Contacts</b></h3>
                    <br>
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="id">ID:</label>
                            <input type="number" name="id" class="form-control" placeholder="Enter Customer ID">
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Customer Name">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit3" value="Submit" class="form-control info_buttons btn-primary">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="button3" value="Show all" class="form-control info_buttons btn-success">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="clean" value="Clean" class="form-control info_buttons btn-danger">
                        </div>
                    </div>
                </form>
            </div>


            <div class="row scrollable_class">

                <br><br>
                <h3><i>Output:</i></h3>
                <?php
                if(isset($_POST['button1'])) { //show all info button
                    if(!isset($_SESSION["username"])){
                        header("Location: login.php");
                        exit(); 
                    }
                    else{
                        ob_start();
                        $sql = "SELECT customer_id, name, address, website, credit_limit FROM customers order by customer_id";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            echo "<div class='table-wrapper-scroll-y my-custom-scrollbar'>"; //last added
                            echo "<table class='table table-bordered table-hover table-striped'><tr><th>ID</th><th>Name</th><th>Address</th><th>WebSite</th><th>Credit Limit</th></tr>";
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr><td>".$row["customer_id"]."</td><td>".$row["name"]."</td><td>".$row["address"]."</td><td>".$row["website"]."</td><td>".$row["credit_limit"]."</td></tr>";
                            }
                            echo "</table></div>"; //last added
                        } else {
                            $output = "0 records";
                        }
                    }
                }


                if(isset($_POST['submit1'])){ //show info individually button
                    if(!isset($_SESSION["username"])){
                        header("Location: login.php");
                        exit(); 
                    }
                    else{
                        ob_start();
                        if($_REQUEST['id']<0)
                        {   
                            echo "Incorrect input";
                        }
                        else{
                            $id = $_REQUEST['id'];

                            $sql = "SELECT customer_id, name, address, website, credit_limit FROM customers WHERE customer_id = '$id'";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                echo "<div class='table-wrapper-scroll-y my-custom-scrollbar'>"; //last added
                                echo "<table class='table table-hover table-bordered table-striped'><tr><th>ID</th><th>Name</th><th>Address</th><th>WebSite</th><th>Credit Limit</th></tr>";
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>".$row["customer_id"]."</td><td>".$row["name"]."</td><td>".$row["address"]."</td><td>".$row["website"]."</td><td>".$row["credit_limit"]."</td></tr>";
                                }
                                echo "</table></div>"; //last added
                            } else {
                                $output = "0 records";
                            }
                        }
                    }
                }

                if(isset($_POST['button2'])) { //show all total spending button
                    if(!isset($_SESSION["username"])){
                        header("Location: login.php");
                        exit(); 
                    }
                    else{
                        ob_start();
                        $sql1 = "select c.CUSTOMER_ID, c.NAME, sum(oi.QUANTITY * oi.UNIT_PRICE) as 'TOTAL SPENDING'
        from customers c, order_items oi, orders o
        where oi.ORDER_ID=o.ORDER_ID and c.customer_id=o.CUSTOMER_ID
        group by c.CUSTOMER_ID, c.NAME
        order by sum(oi.QUANTITY * oi.UNIT_PRICE) desc";

                        $result = mysqli_query($conn, $sql1);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            echo "<div class='table-wrapper-scroll-y my-custom-scrollbar'>"; //last added
                            echo "<table class='table table-hover table-bordered table-striped'><tr><th>Customer_ID</th><th>Name</th><th>Total Spending</th></tr>";
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr><td>".$row["CUSTOMER_ID"]."</td><td>".$row["NAME"]."</td><td>".$row["TOTAL SPENDING"]."</td></tr>";
                            }
                            echo "</table></div>"; //last added
                        } else {
                            $output = "0 records";
                        } 
                    }
                }


                if(isset($_POST['submit2'])) { //show individually total spending button
                    if(!isset($_SESSION["username"])){
                        header("Location: login.php");
                        exit(); 
                    }
                    else{
                        ob_start();
                        if($_REQUEST['id']<0)
                        {   
                            echo "Incorrect input";
                        }
                        else{
                            $id = $_REQUEST['id'];
                            $name = $_REQUEST['name'];

                            $sql1 = "select c.CUSTOMER_ID, c.NAME, sum(oi.QUANTITY * oi.UNIT_PRICE) as 'TOTAL SPENDING'
            from customers c, order_items oi, orders o
            where oi.ORDER_ID=o.ORDER_ID and c.customer_id=o.CUSTOMER_ID and
            (c.CUSTOMER_ID = '$id' OR c.NAME='$name') 
            group by c.CUSTOMER_ID, c.NAME";

                            $result = mysqli_query($conn, $sql1);

                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                echo "<div class='table-wrapper-scroll-y my-custom-scrollbar'>"; //last added
                                echo "<table class='table table-hover table-bordered table-striped'><tr><th>Customer_ID</th><th>Name</th><th>Total Spending</th></tr>";
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>".$row["CUSTOMER_ID"]."</td><td>".$row["NAME"]."</td><td>".$row["TOTAL SPENDING"]."</td></tr>";
                                }
                                echo "</table></div>"; //last added
                            } else {
                                $output = "0 records";
                            } 
                        } 
                    }
                }

                if(isset($_POST['button3'])) { //show all contacts button
                    if(!isset($_SESSION["username"])){
                        header("Location: login.php");
                        exit(); 
                    }
                    else{
                        ob_start();
                        $sql1 = "SELECT c.customer_id, c.name, cs.first_name, cs.last_name 
        FROM customers c, contacts cs 
        WHERE c.customer_id = cs.customer_id
        order by c.customer_id";

                        $result = mysqli_query($conn, $sql1);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            echo "<div class='table-wrapper-scroll-y my-custom-scrollbar'>"; //last added
                            echo "<table class='table table-hover table-bordered table-striped'><tr><th>Customer_ID</th><th>Customer Name</th><th>Contact Name</th><th>Contact Last Name</th></tr>";
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr><td>".$row["customer_id"]."</td><td>".$row["name"]."</td><td>".$row["first_name"]."</td><td>".$row["last_name"]."</td></tr>";
                            }
                            echo "</table></div>"; //last added
                        } else {
                            $output = "0 records";
                        } 
                    } 
                }

                if(isset($_POST['submit3'])) { //show individually contacts button
                    if(!isset($_SESSION["username"])){
                        header("Location: login.php");
                        exit(); 
                    }
                    else{
                        ob_start();
                        if($_REQUEST['id']<0)
                        {   
                            echo "Incorrect input";
                        }
                        else{
                            $id = $_REQUEST['id'];
                            $name = $_REQUEST['name'];

                            $sql1 = "SELECT c.customer_id, c.name, cs.first_name, cs.last_name 
            FROM customers c, contacts cs 
            WHERE c.customer_id = cs.customer_id and (c.name = '$name' OR c.customer_id = '$id')
            order by c.name";

                            $result = mysqli_query($conn, $sql1);

                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                echo "<div class='table-wrapper-scroll-y my-custom-scrollbar'>"; //last added
                                echo "<table class='table table-hover table-bordered table-striped'><tr><th>Customer_ID</th><th>Customer Name</th><th>Contact Name</th><th>Contact Last Name</th></tr>";
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>".$row["customer_id"]."</td><td>".$row["name"]."</td><td>".$row["first_name"]."</td><td>".$row["last_name"]."</td></tr>";
                                }
                                echo "</table></div>"; //last added
                            } else {
                                $output = "0 records";
                            } 
                        } 
                    } 
                }



                echo $output;

                ?>
            </div>

        </div>
    </body>
</html>