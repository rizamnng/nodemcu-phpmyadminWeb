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
            
            $users=explode("@",$user);
            $date= date('Y/m/d');

            $date= date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
            $d_user=explode("-",$users[0]);
            if($d_user[1]=="s"){
                $type="student";
            }
            elseif($d_user[1]=="fs"){
                $type="facuty/staff";
            }
            elseif($d_user[1]=="v"){
                $type="visitor";
            }

            $query = "insert into interactions (from_user, with_user, date,type) values ('$users[0]','$users[1]','$date',' $type')";
            
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