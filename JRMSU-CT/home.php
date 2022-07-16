<?php 
session_start();

  include("connection.php");
  include("functions.php");
  date_default_timezone_set('Asia/Hong_Kong');

  $user_data = check_login($con);
  $now= date('Y-m-d');
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $now= $_POST['myDate'];

  }


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>CONTACT TRACING</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/home.css">
  </head>
  <body>
      
    <nav role="navigation" class="primary-navigation">
      <ul>
        <li><a href="#">HOME</a></li>
        <li><a href="notifications-admin.php">NOTIFICATIONS</a></li>
        <li><a href="interactions.php">INTERACTIONS</a></li>
        <li><a href="register.php">REGISTER STUDENT,FACULTY, STAFF USER</a></li>
        <li><a href="register-visitor.php">REGISTER VISITOR</a><br></li>
      
        <li><a href="#">PROFILE &dtrif;</a>
          <ul class="dropdown">
            <li><a href="editInformation.php">Edit Profile</a></li>
            <li><a href="logout.php">logout</a></li>
          </ul>
        </li>
       
      </ul>
    </nav>
    

    <button class="print-button" id="PrintButton" onclick="PrintPage()"><span class="print-icon"></span></button>

    <h2>LOGS</h2>
    <form method="post">
        <input class="date" type="date" name="myDate" data-date-format="YYYY MM DD" value= <?php $now ?>>
        <input class="form-submit-button" type="submit" name="submit" value="SEARCH">
      </form>
    <table>
      <tr>
        <th &nbsp;>TIME</th>
        <th>INDIVIDUAL</th>
        <th>Type</th>
        

      </tr>

      <?php
        $sql = "SELECT * FROM log_entrance";
        $data = mysqli_query($con, $sql) or die(mysqli_error($con));
        
        while($row = mysqli_fetch_array($data)){
          $date = $row['date_time'];
          $dt= new DateTime($date);
          $det=$dt->format('Y-m-d');
          if($det == $now){
            $user = $row['user'];
            
            $type= $row['type'];
            if($type=="student"){
               $query = "select * from users_student where device_id = '$user' limit 1";
               $result = mysqli_query($con, $query);   
            }
            else if($type=="facuty/staff"){
              $query = "select * from users_faculty_staff where device_id = '$user' limit 1";
              $result = mysqli_query($con, $query);
            }
            else{
              $query = "select * from users_visitor where device_id = '$user' limit 1";
              $result = mysqli_query($con, $query);
            }

            if($result && mysqli_num_rows($result) > 0){
              $log_data = mysqli_fetch_assoc($result);
            }
            $name=$log_data['firstname']." ".$log_data['middlename']." ".$log_data['lastname'];

           
           
            echo "<tr>";
            echo "<td class='top'> $date";
            echo "<td class='top'> $name </td>";
            echo "<td class='top'>  $type</td>";
            
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
