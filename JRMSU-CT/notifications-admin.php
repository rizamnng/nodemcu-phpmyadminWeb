<?php
session_start();

	include("connection.php");
  include("functions.php");
  date_default_timezone_set('Asia/Hong_Kong');

  $user_data = check_login($con);

	 if($_SERVER['REQUEST_METHOD'] == "POST"){
        $action= $_POST['ac'];
        $id_=$_POST['action'];
        if($action=="ACCEPT"){

        	
	        $query = "update viraltest_result set status='1' where id_index= $id_ ";
	        mysqli_query($con, $query);
	       

        }
				else{
					
	        $query = "update viraltest_result set status='-1' where id_index= $id_ ";
	        mysqli_query($con, $query);
	        
				}
				 header("Location: notifications-admin.php");
	       die;

    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
		<link rel="stylesheet" href="css/admin_resetrequest_style.css">
    <title> Requests</title>
  </head>
  <body>
		<br>
    <a class='home' href="home.php">HOME</a> <br><br>


      <?php
        $sql = "SELECT * FROM viraltest_result";
        $data = mysqli_query($con, $sql) or die(mysqli_error($con));

        echo "<div class = 'flex-parent-element'>";
        echo "<div class ='flex-child-element magenta'>";


        echo '<table>';
				echo "<tr>";
				echo "<th colspan='3'>NEW REQUEST</th>";
				echo "<br><br>";
				echo "</tr>";

				$id=array();
				$photo1 = array();
        $device1= array();
        $name1 = array();
        $date1= array();
        $symptoms1= array();

        while($row = mysqli_fetch_array($data)){
        		$photo = $row['photo'];
            $device= $row['user'];
            $user = explode("-",$device);
            $date= $row['date_time'];
            $id_index=$row['id_index'];
            $symptoms= $row['symptoms'];
            if($user[1]=="s"){
                $type="student";
            }
            elseif($user[1]=="fs"){
                $type="facuty/staff";
            }
            else{
                $type="visitor";
            }

            if($type=="student"){
               $query = "select * from users_student where device_id = '$device' limit 1";
               $result = mysqli_query($con, $query);   
            }
            else if($type=="facuty/staff"){
              $query = "select * from users_faculty_staff where device_id = '$device' limit 1";
              $result = mysqli_query($con, $query);
            }
            else{
              $query = "select * from users_visitor where device_id = '$device' limit 1";
              $result = mysqli_query($con, $query);
            }

            if($result && mysqli_num_rows($result) > 0){
              $fromuser_data = mysqli_fetch_assoc($result);
            }

            $name=$fromuser_data['firstname']." ".$fromuser_data['middlename']." ".$fromuser_data['lastname'];

          if($row['status'] == 0){
            

            $device_=$fromuser_data['device_id'];
            
            $phot=base64_encode($photo);

            
            echo "<tr>";
            echo "<td id='date'> $date </td>";
            echo "<td> $name </td>";

            echo '<td><a href="getImage.php?id='.$id_index.'"><img src="data:image/jpg;base64,'.base64_encode($row['photo']).'" width="400" height="400" /> </a> </td>';

            echo "<td> <form method='post'>
            <input type='submit' name='ac' value='ACCEPT' >
						<input type='hidden' name='action' value='$id_index' >
            <br><br>
            </form> </td>";
						echo "<td>
						<form method='post'>
            <input type='submit' name='ac' value='DECLINE' >
						<input type='hidden' name='action' value='$id_index' >
            <br><br>
            </form> </td>";
            echo "</tr>";

          }

          else{
          	array_push($id, $id_index);
          	array_push($photo1, $photo);
						array_push($device1, $device);
						array_push($date1, $date);
						array_push($symptoms1, $symptoms);
						array_push($name1,$name);
          }
        }
				echo "</table>";
				echo "</div>";

			
				echo "<div class ='flex-child-element green'>";
				echo "<br> <br>";
				echo '<table>';
				echo "<tr>";
				echo "<th colspan='3'>PREVIOUS REQUESTS</th>";
				echo "<tr>";
				echo "<td>Date</td>";
				echo "<td id='result'>Result</td>";
				echo "<td>Name</td>";
				echo "<td>Date Symptoms</td>";
				echo "</tr>";
				echo "</tr>";
				$reverse_id= array_reverse($id);
				$reverse_date = array_reverse($date1);
				$reverse_photo = array_reverse($photo1);
				$reverse_name = array_reverse($name1);
				$reverse_symptoms = array_reverse($symptoms1);
				for($i=0; $i<count($reverse_date) ; $i++){
					echo "<tr>";
					echo "<td class='date'>";
					echo $reverse_date[$i];
					echo "</td>";
					
					 echo '<td><a href="getImage.php?id='.$reverse_id[$i].'"><img src="data:image/jpg;base64,'.base64_encode($reverse_photo[$i]).'" width="400" height="400" /> </a> </td>';
					
					echo "<td>";
					echo $reverse_name[$i];
					echo "</td>";
					echo "<td>";
					echo $reverse_symptoms[$i];
					echo "</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</div>";
				echo "</div>";
      ?>




  </body>
</html>
