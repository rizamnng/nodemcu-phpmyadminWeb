<?php
  session_start();
    include('connection.php');
    include("functions.php");


    $message='';
    if($_SERVER['REQUEST_METHOD'] == "POST"){

      $school_id = $_POST['schoolID'];
		  $password = $_POST['password'];
      $type=$_POST['type'];
      if(!empty($school_id) && !empty($password)){
        if($type=="student"){
          $query = "select * from users_student where school_id = '$school_id' limit 1";
        }
        else{
          $query = "select * from users_faculty_staff where school_id = '$school_id' limit 1";
        }
  		
  			$result = mysqli_query($con, $query);
        mysqli_close($con);
  			if($result){
  				if($result && mysqli_num_rows($result) > 0){

  					$user_data = mysqli_fetch_assoc($result);

  					if($password == $user_data['password']) {

  						$_SESSION['user_id'] = $user_data['id_index'];
              $_SESSION['type'] = $user_data['type'];
              header("Location: user-home.php");
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
    <link rel="stylesheet" href="css/User_Login_style.css">
    <title>LOGIN</title>
  </head>
  <body>
     <img class="logo"src="photos/LOGO.png" alt="">
    <br>
    <form class="box" method="post">
        <h2>LOGIN</h2>
        <?php
            echo $message;
         ?>
         
          <select name="type" id="type">
            <option value="student">Student</option>
            <option value="faculty/staff">Faculty/Staff</option>
          </select>
          <br>
        <input class="form-control" id="_username" type="text" name="schoolID" placeholder="School ID" required >

        <input class="form-control" id="_password" type="password" name="password" placeholder="Password" required><br>

        <input class="btn btn-primary submit" type="submit" name="submit" value="LOGIN">


    </form>



  </body>
</html>
