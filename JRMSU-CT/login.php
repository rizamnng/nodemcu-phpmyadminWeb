<?php
  session_start();
    include('connection.php');
    include("functions.php");

    $message='';
    if($_SERVER['REQUEST_METHOD'] == "POST"){

      $username = $_POST['username'];
		  $password = $_POST['password'];
      if(!empty($username) && !empty($password) && !is_numeric($username)){
  			$query = "select * from admin where username = '$username' limit 1";
  			$result = mysqli_query($con, $query);
        mysqli_close($con);
  			if($result){
  				if($result && mysqli_num_rows($result) > 0){

  					$user_data = mysqli_fetch_assoc($result);

  					if($password == $user_data['password']) {

  						$_SESSION['admin_id'] = $user_data['id_index'];
              header("Location: home.php");
  						die;
  					}
  				}
  			}

  			$message =  " <p>Incorrect username/password!</p> ";
  		}
    }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/Admins_Login_style.css">
    <title>LOGIN</title>
  </head>
  <body>
    <br>
    <form class="box" method="post">
          <img src="image/clientprofile.png" alt="">
        <h2>ADMIN LOGIN</h2>
        &nbsp;&nbsp;&nbsp;
        <?php
            echo $message;
         ?>
        <input class="form-control" id="_username" type="text" name="username" placeholder="Username" required ><br>

        <input class="form-control" id="_password" type="password" name="password" placeholder="Password" required><br>

        <input class="btn btn-primary submit" type="submit" name="submit" value="LOGIN">


    </form>



  </body>
</html>
