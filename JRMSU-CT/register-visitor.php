<?php
session_start();
	date_default_timezone_set('Asia/Hong_Kong');
	include("connection.php");
	$message= '';
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{

    
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $currentDate= date('Y-m-d H:i:s');
    $deviceId = "JRMSUMCsocial-v-";
    $deviceId .=  $_POST['deviceid'];
		$address = $_POST['address'];
	
 
		$fname= strtoupper($fname);
		$mname= strtoupper($mname);
		$lname= strtoupper($lname);
		
		$address = strtoupper($address);

		if(!empty($deviceId) && !empty($fname) && !empty($lname) && !empty($gender) && !empty($email) && !empty($address))
		{

			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

				$api_key = "b821b3edb1524020afbbad79ca9e7fc0";
				$ch = curl_init();
				curl_setopt_array($ch, [
						CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1?api_key=$api_key&email=$email",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_FOLLOWLOCATION => true
				]);
				$response = curl_exec($ch);
				curl_close($ch);
				$data = json_decode($response, true);

				if ($data['deliverability'] === "DELIVERABLE" ) {
					
						$query = "insert into users_visitor (datetime, firstname, middlename, lastname, address, gender, contactnum, email, device_id)
						values ('$currentDate','$fname', '$mname' , '$lname' ,'$address','$gender' ,'$number','$email', '$deviceId')";
					
					
					mysqli_query($con, $query);
					mysqli_close($con);
					 header("Location: home.php");
  						die;
						

				
				}
				else{
					$message= "<p>Email is Undeliverable</p>" ;
				}

			}
			else{
				$message= "<p>Invalid email format</p>" ;
			}

		}
  }
	
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/register_style.css">
    <title>REGISTER</title>
  </head>
  <body>
   	
		<form class="box" method="post">
			<a href="home.php">HOME</a>	
			<div class="row">
      		<div class="column right">
        <h2>REGISTER VISITOR</h2> 
        <p><?php
          echo $message;
         ?></p>
         
	      <input class="form-control" type="text" name="fname" required placeholder="First Name">
	      <input class="form-control" type="text" name="mname" required placeholder="Middle Name" >
	      <input class="form-control" type="text" name="lname" required placeholder="Last Name">
	      <input type="radio" id="genderChoice1" name="gender" value="Male" required>
	      <label class="genderlabel" for="genderChoice1">Male </label>
	      <input  type="radio" id="genderChoice2" name="gender" value="Female" required>
	      <label class="genderlabel" for="genderChoice2">Female </label> 
	      <input class="form-control" type="text" name="address" required placeholder="Address">
	      <input class="form-control" type="text" name="number" required placeholder="Contact Number">
	      <input class="form-control" type="email" name="email" required placeholder="Email">
	      <input class="form-control" type="text" name="deviceid" required placeholder="Device ID Number ">

	      
        
        <input class="button"  type="submit" name="submit" value="SUBMIT">
        </div>
  			</div>
	    </form>
	
			<br><br><br><br>
  </body>
</html>
