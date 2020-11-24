<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Registration</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <?php
        require('db_reg.php');

        // define variables and set to empty values
        $nameErr = $lastNameErr = $usernameErr = $emailErr = $passErr = "";
        $username = ""; $email = ""; $pass = ""; $firstName = ""; $lastName ="";
        if (isset($_REQUEST['username'])){
            $username = test_input($_POST["username"]);
            // check if name only contains letters and whitespace */
            if (!preg_match("/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/",$username)) {
                $usernameErr = "Only letters and numbers and underscore allowed";
            }
            else{
                $firstName = test_input($_POST["fName"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
                    $nameErr = "Only letters and white space allowed";
                }
                else{
                    $lastName = test_input($_POST["lName"]);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
                        $lastNameErr = "Only letters and white space allowed";
                    }
                    else{
                        $email = test_input($_POST["email"]);
                        // check if e-mail address is well-formed
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $emailErr = "Invalid email format";
                        }
                        else{
                            $pass = test_input($_POST["password"]);
                            if (strlen($pass)>=4) {
                                if (!preg_match("/^\S*$/",$pass)) {
                                    $passErr = "White spaces not allowed";
                                }
                                else{
                                    $query = "SELECT * FROM `user_info` WHERE user_name='$username' OR email= '$email'";
                                    $result = mysqli_query($con,$query) or die(mysql_error());
                                    $rows = mysqli_num_rows($result);

                                    if($rows==1){
                                        echo "Username already exists!";
                                    }
                                    else{

                                        $query1 = "INSERT into user_info (user_name, firstname, lastname, email, pass)
                                VALUES ('$username', '$firstName', '$lastName', '$email', '".md5($pass)."')";
                                        $result1 = mysqli_query($con,$query1);
                                        if($result1){
                                            echo "<div class='form'>
                                    <h3>You are registered successfully.</h3>
                                    <br/>Click here to <a href='login.php'>Login</a>
                                    </div>";
                                        } 
                       /*         if ($con->query($query1) === TRUE) {   //this statement needed to find out if query completed successfully or not
                                    echo "Query done successfully";
                                } else {
                                    echo "Error on query completion: " . $con->error;
                                } */
        
                                    }
                                }
                            }
                            else{
                                $passErr = "Not less than 4 characters"; 
                            }
                        }   
                    }
                }
            }
        }
               
else{ ?>
        <div class="form">
            <h1>Sign Up</h1>
            <form name="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="text" name="fName" placeholder="First Name" required><br><small style="color: red;"><?php echo $nameErr;?></small>
                <input type="text" name="lName" placeholder="Last Name" required><br><small style="color: red;"><?php echo $lastNameErr;?></small>
                <input type="email" name="email" placeholder="Email" required /><br><small style="color: red;"><?php echo $emailErr;?></small>
                <input type="text" name="username" placeholder="Username" required /><br><small style="color: red;"><?php echo $usernameErr;?></small>               
                <input type="password" name="password" placeholder="Password" required /><br><small style="color: red;"><?php echo $passErr;?></small>
                <br>
                <input type="submit" name="submit" value="Sign Up" />
            </form>
        </div>
<?php } 
         function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>


    </body>
</html>