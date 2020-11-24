<?php
// Enter your Host, username, password, database below.
// I left password empty because i do not set password on localhost.
$conn = mysqli_connect("127.0.0.1:3308","root","","inventory_db");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>