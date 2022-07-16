<?php 
session_start();

  include("connection.php");
  include("functions.php");
  date_default_timezone_set('Asia/Hong_Kong');

  $user_data = check_login($con);
  $date= date('Y/m/d');
  $date= date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $date= $_POST['myDate'];

  }


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>JRMSU CONTACT TRACING</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/interactions.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
  </head>
  <body>
    <header><a href="home.php">HOME</a> 
    </header>
    <button class="print-button" id="PrintButton" onclick="PrintPage()"><span class="print-icon"></span></button>
    <h2>INTERACTIONS</h2>
      <form method="post">
        <input class="date" type="date" name="myDate" data-date-format="YYYY MM DD" value= <?php $date ?>>
        <input class="form-submit-button" type="submit" name="submit" value="SEARCH">
      </form>
    
    <br>
    
    <table>
      <tr>
        <th &nbsp;>User</th>
        <th>Type</th>
        <th>Interacted to</th>
        <th>Type</th>
        <th>Date</th>
        

      </tr>

      <?php
        $sql = "SELECT * FROM interactions";
        $data = mysqli_query($con, $sql) or die(mysqli_error($con));
        
        while($row = mysqli_fetch_array($data)){
          if($row['date'] == $date){
            $from_user = $row['from_user'];
            $with_user = $row['with_user'];
            $deyt = $row['date'];
            $type= $row['type'];
            if($type=="student"){
               $query = "select * from users_student where device_id = '$from_user' limit 1";
               $result = mysqli_query($con, $query);   
            }
            else if($type=="facuty/staff"){
              $query = "select * from users_faculty_staff where device_id = '$from_user' limit 1";
              $result = mysqli_query($con, $query);
            }
            else{
              $query = "select * from users_visitor where device_id = '$from_user' limit 1";
              $result = mysqli_query($con, $query);
            }

            if($result && mysqli_num_rows($result) > 0){
              $fromuser_data = mysqli_fetch_assoc($result);
            }
            
            $d_user=explode("-",$with_user);
            if($d_user[1]=="s"){
                $with_type="student";
            }
            elseif($d_user[1]=="fs"){
                $with_type="facuty/staff";
            }
            elseif($d_user[1]=="v"){
                $with_type="visitor";
            }

            if($with_type=="student"){
               $query = "select * from users_student where device_id = '$with_user' limit 1";
               $withresult = mysqli_query($con, $query);
            }
            else if($with_type=="facuty/staff"){
              $query = "select * from users_faculty_staff where device_id = '$with_user' limit 1";
              $withresult = mysqli_query($con, $query);
            }
            else{
              $query = "select * from users_visitor where device_id = '$with_user' limit 1";
              $withresult = mysqli_query($con, $query);
            }
             if($withresult && mysqli_num_rows($withresult) > 0){
              $withuser_data = mysqli_fetch_assoc($withresult);
            }
            $fname= $fromuser_data['firstname'];
            $mname= $fromuser_data['middlename']; 
            $lname= $fromuser_data['lastname'];

            $wfname=$withuser_data['firstname'];
            $wmname=$withuser_data['middlename']; 
            $wlname=$withuser_data['lastname'];
           
            echo "<tr>";
            echo "<td class='top'> $fname $mname $lname</td>";
            echo "<td class='top'> $type </td>";
            echo "<td class='top'>  $wfname $wmname $wlname</td>";
            echo "<td class='top'> $with_type </td>";
            echo "<td class='top'> $deyt </td>";
            
            echo "</tr>";
          }
        }
        
      ?>
    </table>
    
  </body>
  <script type="text/javascript">
  function PrintPage() {
    window.print();
  }
</script>
</html>
