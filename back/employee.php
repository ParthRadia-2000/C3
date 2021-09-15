<?php
    session_start();
    require("../connection/connect.php");
    if(isset($_POST['cData']))
    {
        $firstname=$_POST['cData']['firstname'];
        $lastname=$_POST['cData']['lastname'];
        $dob=$_POST['cData']['birth-date'];
        $email=$_POST['cData']['email'];
        $joindate=$_POST['cData']['join-date'];
        $dept=$_POST['cData']['department'];
        $mobile=$_POST['cData']['mobile'];
        $createdon=$_POST['cData']['creation-date'];
        $createdby=$_POST['cData']['created-by'];
        $address=$_POST['cData']['address'];

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        //pattern for mobile number
        $mob="/^[1-9][0-9]*$/";

        if( $firstname == "" || $lastname == "" || $dob == "" || $email == ""||
            $joindate == "" || $dept == "" || $mobile == "" ||
                $createdon == "" || $createdby == "" || $address == "" )
                {
                    echo ("required");
                }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            echo("email");
        }
        else if(!preg_match($mob, $mobile))
        {
            echo("mobile");
        }
        else if(strlen($mobile) < 10){
            echo("mobile");
        }
        else
        {
            $insert = "INSERT into employees(firstname,lastname,DOB,email,joindate,department,mobile,createdon,createdby,address)
                VALUES(:fname,:lname,:dob,:email,:jdate,:dept,:mob,:cdate,:cby,:add)";
            $stmt=$conn->prepare($insert);
            $stmt->execute(array(
                    ':fname' => $firstname,
                    ':lname' => $lastname,
                    ':dob' => $dob,
                    ':email' => $email,
                    ':jdate' => $joindate,
                    ':dept' => $dept,
                    ':mob' => $mobile,
                    ':cdate' => $createdon,
                    ':cby' => $createdby,
                    ':add' => $address
                )
            );
            if($stmt)
            {
                echo "inserted";
            }
            else
            {
                echo "notinserted";
            }
        }
    }
?>