<?php 
session_start();

    include("connection.php");
    include("functions.php");
    date_default_timezone_set('Asia/Hong_Kong');

    $user_data = check_login($con);

    if(isset($_GET['id']))
    {
        $id=  $_GET['id'];

        $query="SELECT * FROM viraltest_result where id_index= '$id' limit 1";
        $result = mysqli_query($con, $query);
        mysqli_close($con);

        if($result && mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $imageData= $row['photo'];
        
            

        }

        
       echo '<img src="data:image/jpg;base64,'.base64_encode($imageData).'" width="1300" height="1000" />';

    }


 ?>