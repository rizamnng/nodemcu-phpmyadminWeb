<?php
session_start();

	date_default_timezone_set('Asia/Hong_Kong');
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);
	$message= '';
	$done = '';
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{

    $type= $_POST['type'];
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $currentDate= date('Y/m/d');

    $deviceId1 =  $_POST['deviceid'];
		$address = $_POST['address'];
		$schoolid= $_POST['schoolid'];
 
		$fname= strtoupper($fname);
		$mname= strtoupper($mname);
		$lname= strtoupper($lname);
		$schoolid= strtoupper($schoolid);
		$address = strtoupper($address);
		$password=getPASS();
		
		

		if(!empty($deviceId1) && !empty($fname) && !empty($lname) && !empty($gender) && !empty($email) && !empty($address))
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
					if($type=="student"){
						$deviceId = "JRMSUMCsocial-s-";
						$deviceId .= $deviceId1;
						$query = "insert into users_student (school_id,date_registered, firstname, middlename, lastname, address, gender, contactnum, email, device_id, password)
						values ('$schoolid','$currentDate','$fname', '$mname' , '$lname' ,'$address','$gender' ,'$number','$email', '$deviceId', '$password')";
					}
					else{
						$deviceId = "JRMSUMCsocial-fs-";
						$deviceId .= $deviceId1;
						$query = "insert into users_faculty_staff (school_id,date_registered, firstname, middlename, lastname, address, gender, contactnum, email, device_id, password)
						values ('$schoolid','$currentDate','$fname', '$mname' , '$lname' ,'$address','$gender' ,'$number','$email', '$deviceId', '$password')";
					}
					mysqli_query($con, $query);
					mysqli_close($con);
					$msg="default password: ".$password;
					echo "<script>
									alert('$msg');
									window.location.href='register.php';
									</script>";
				
				}
				else{
					$message= "<p>Email is Undeliverable</p>" ;
				}

			}
			else{
				$message= "<p>Invalid email format</p>" ;
			}

		}
    else{
			$message= "<p>Please enter some valid information!</p>";
		}
	}
	else{
		$msg='<script type="text/javascript">alert("NOT BLANK");</script>';
	}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" href="css/register_style.css">
    <script src=“https://unpkg.com/sweetalert/dist/sweetalert.min.js“></script>
    <title>REGISTER</title>
  </head>
  <body>	
  	   
		<form class="box"  method="post">
			<a href="home.php">HOME</a>	 
			<div class="row">
      	<div class="column right">
        <br> <h2>REGISTER USER</h2> 
        <p><?php
          echo $message;
         ?></p>
         <label for="type">Type:</label>
					<select name="type" id="type">
					  <option value="student">Student</option>
					  <option value="faculty/staff">Faculty/Staff</option>
					</select>
         <input class="form-control" type="text" name="schoolid" required placeholder="School ID">
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
