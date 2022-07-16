<?php
session_start();

    include("connection.php");
    include("functions.php");
    date_default_timezone_set('Asia/Hong_Kong');


    $api_key_value = "gasd8TS12qd";

    $api_key= $user=$type =$status= "";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $api_key = test_input($_POST["api_key"]);
        if($api_key == $api_key_value) {
            $user = test_input($_POST["data"]);
            $date= date('Y-m-d H:i:s',(time() - 60 * 15));
            $d_user=explode("-",$user);
            if($d_user[1]=="s"){
                $type="student";
            }
            elseif($d_user[1]=="fs"){
                $type="facuty/staff";
            }
            elseif($d_user[1]=="v"){
                $type="visitor";
            }

            $query = "insert into log_entrance (user, type, date_time) values ('$user','$type','$date')";
            
            mysqli_query($con, $query);
            echo "successfully saved to database.";

        }
        else {
            echo "Wrong API Key provided.";
        }

    }
    else {
        echo "No data posted with HTTP POST.";
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }