<?php
session_start();

	include("connection.php");
  include("functions.php");

	$user_data = check_login($con);
  $message= '';
	if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $id=$user_data['id_index'];
    $confirm_pass= $_POST['confirmpass'];

    if($username!="" && $password!="" && $name!=""){
    	if ($password == $confirm_pass && strlen($password)>=8 ){
    			$query = "update admin set
	       name= '$name',
	       username= '$username',
	       password= '$password'
	       where id_index= $id";
	       mysqli_query($con, $query);
	       header("Location: home.php");
	       die;
			 	mysqli_close($link);
    	}
    	else{
    		$message= "<p>Password not match / Password must contain atleast 8 characters</p>" ;
    	}
       
		 }
		 else{
		 		$message= "<p>Please enter some valid information!</p>";
		 
		 }
   }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/officeprofile_style.css">
    <title>Edit Information</title>
  </head>
  <body>
		<br><br>
		<div class="information">
			
			<span>
				<?php
					echo $message;
				 ?>
			</span>

			<form method="post">
				<input class="form-control" type="text" name="name"  required value= "<?php echo$user_data['name']; ?>" placeholder="NAME"><br>
        <input class="form-control " type="text" name="username" required value= "<?php echo$user_data['username']; ?>" placeholder="USERNAME"><br>
	      <input class="form-control" type="password" name="password" required value= "<?php echo $user_data['password']; ?>" placeholder="PASSWORD"><br>
	      <input class="form-control" type="password" name="confirmpass"  placeholder="CONFIRM PASSWORD"><br>

	      <input  class="btn btn-primary edit" type="submit" name="submit" value="SUBMIT">
	    </form>
		</div>


  </body>
</html>
