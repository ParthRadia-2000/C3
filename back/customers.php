<?php
    session_start();
    require("../connection/connect.php");
    if(!isset($_SESSION["email"]))
    {
        header("Location:../front/userlogin.php");
    }
    else
    {
        if(isset($_POST['cData']))
        {
            $customer_name=$_POST['cData']['customer_name'];
            $salesrep=$_POST['cData']['salesrep'];
            $status=$_POST['cData']['status'];
            $phone=$_POST['cData']['phone'];
            $email=$_POST['cData']['email'];
            $industry=$_POST['cData']['industry'];
            $address=$_POST['cData']['address'];    

            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            //pattern for mobile number
            $mob="/^[1-9][0-9]*$/";

            if( $customer_name == "" || $salesrep == "" || $status == "" || $phone == ""||
                $email == "" || $industry == "" || $address == "")
                {
                    echo ("required");
                }
            else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                echo("email");
            }
            else if(!preg_match($mob, $phone))
            {
                echo("mobile");
            }
            else if(strlen($phone) < 10){
                echo("mobile");
            }
            else
            {
                $insert = "INSERT into customers(cname,csalesrep,cstatus,cphone,cemail,cindustry,caddress)
                        VALUES(:cname,:csalesrep,:cstatus,:cphone,:cemail,:cindustry,:caddress)";
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                        ':cname' => $customer_name,
                        ':csalesrep' => $salesrep,
                        ':cstatus' => $status,
                        ':cphone' => $phone,
                        ':cemail' => $email,
                        ':cindustry' => $industry,
                        ':caddress' => $address
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
    }
?>