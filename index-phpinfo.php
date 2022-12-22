<?php
$servername = "vmmysqlone-lan";
$username = "wabotdb";
$password = "ADDBwhatsPIK@638";

// Create connection
$conn = new mysqli($servername, $username, $password,"wa_bot");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error.PHP_EOL);
}
echo "Connected successfully".PHP_EOL;
?>
