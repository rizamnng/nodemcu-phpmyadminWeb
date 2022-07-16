<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <title></title>
  </head>
  <body>
    <img id="background"src="photos/LOGO.png" alt="">

    <ul>
  <li><a href="#home">Home</a></li>
  <li><a href="#news">Profile</a></li>
  <li><a href="#news">Upload File</a></li>


  </ul>

    <div id="box" class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    This is an alert box.
  </div>


  </body>
</html>
