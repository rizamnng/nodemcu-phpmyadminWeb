<?php

function check_login($con)
{

	if(isset($_SESSION['admin_id']))
	{

		$id = $_SESSION['admin_id'];
		$query = "select * from admin where id_index = '$id' limit 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	header("Location: login.php");
	die;

}

function random_num($length)
{

	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4,$length);

	for ($i=0; $i < $len; $i++) { 
		# code...

		$text .= rand(0,9);
	}

	return $text;
}



function getPASS() {
	$n=10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}

function check_user_login($con)
  {

    if(isset($_SESSION['user_id']))
    {

      $id = $_SESSION['user_id'];
      if($_SESSION['type']="student"){
      	$query = "select * from users_student where id_index = '$id' limit 1";
      }
      else{
      	$query = "select * from users_faculty_staff where id_index = '$id' limit 1";
      }
      

      $result = mysqli_query($con,$query);

      if($result && mysqli_num_rows($result) > 0)
      {

        $user_data = mysqli_fetch_assoc($result);
        return $user_data;
       
      }
    }

    //redirect to login
    header("Location: user-login.php");
    die;

  }