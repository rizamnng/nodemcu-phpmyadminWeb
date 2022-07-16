<?php 
session_start();

  include("connection.php");
  include("functions.php");
  date_default_timezone_set('Asia/Hong_Kong');
  $msg= '';
  $datesymp= date('Y/m/d');
  $datesymp1= date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $datesymp) ) ));
  $datesymp2= date('Y-m-d',(strtotime ( '-2 day' , strtotime ( $datesymp) ) ));
  $datesymp14= date('Y-m-d',(strtotime ( '-14 day' , strtotime ( $datesymp) ) ));

  $user_data = check_user_login($con);
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    $user= $user_data['device_id'];
    $date= date('Y-m-d H:i:s');
    $symptoms= $_POST['symptoms'];
    $imageName = mysqli_real_escape_string($con,$_FILES["image"]["name"]);
    $imageData = mysqli_real_escape_string($con,file_get_contents($_FILES["image"]["tmp_name"]));
    $imageType = mysqli_real_escape_string($con,$_FILES["image"]["type"]);

   


    if(!empty($imageName) && !empty($symptoms) && substr($imageType, 0,5)=="image" ){
      $user=$user_data['device_id'];
      $date= date('Y-m-d H:i:s');
      $query = "insert into viraltest_result (photo, photo_name, symptoms, user, date_time)
              values ('$imageData', '$imageName','$symptoms','$user','$date')";
      mysqli_query($con, $query);
      $msg="VIRAL TEST RESULT ARE NOW UP FOR EVALUATION";
          echo "<script>
                  alert('$msg');
                  window.location.href='user-home.php';
                  </script>";
    }
    else{
      $msg= "Invalid file!";
    }
  }
  
 
?>


<!DOCTYPE html>
<html lang="en" dir="ltr"> 
  <head>
    <title> 
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/user-home.css">
    <script src=“https://unpkg.com/sweetalert/dist/sweetalert.min.js“></script>
  </head>
  <body>
    <div>
      <header class="upper">
      <span>
        <a href="user-logout.php">LOGOUT</a> <br>
        <?php echo $user_data['firstname']." ".$user_data["middlename"]." 
      ".$user_data["lastname"] ?>
      </span>
    </header>
    </div>
    
      
      <br><br><br> <br><br><br>

      <p><?php echo $msg; ?></p>

      <form  method="post" enctype="multipart/form-data">
        <label for="photo"> UPLOAD LABORATORY RESULT:</label> <br>
        <input type="file" name="image" required> <br> 
        <label for="symptoms">SYMPTOMS BEGUN/THE DATE YOU TESTS POSITIVE:</label><br>
        <input type="date" name="symptoms" data-date-format="YYYY MM DD" required>
        <input type="submit" name="submit" value="SUBMIT">
      </form>

    <br>
    <h2>NOTIFICATIONS</h2>
    <?php 
       $sql = "SELECT * FROM viraltest_result";
      $data = mysqli_query($con, $sql) or die(mysqli_error($con));
      echo '<table>';

      while($row = mysqli_fetch_array($data))
      {
        if($row['status']==1)   
        {
          $query= "SELECT * FROM interactions";
          $data1 = mysqli_query($con, $query) or die(mysqli_error($con));
          while($row1= mysqli_fetch_array($data1))
          {
            $date1 = $row['symptoms'];
            $date2 = $row1['date'];

            $diff = abs(strtotime($date1) - strtotime($date2));

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            if($row1['with_user']==$user_data['device_id'] && $row['user']==$row1['from_user'] && $years==0 && $months==0 && $days<=2)
            {
              $notifdate=$row['date_time'];
              echo "<tr>";
              echo "<td> $notifdate </td>";
              echo "<td> You're advised to undergo self-quarantine as you've been exposed to a covid positive individual </td>";
              echo "</tr>";
            }
            else if( $row1['from_user']==$user_data['device_id'] && $row['user']==$row1['with_user'] && $years==0 && $months==0 && $days<=2)
            {
              $notifdate=$row['date_time'];
              echo "<tr>";
              echo "<td> $notifdate </td>";
              echo "<td> You're advised to undergo self-quarantine as you've been exposed to a covid positive individual </td>";
              echo "</tr>";

            }
          }

        
        }

        
      }
      echo '</table>';
     ?>
  </body>
</html>
