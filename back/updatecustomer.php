<?php
    require("../connection/connect.php");
    session_start();
    if(!isset($_SESSION["email"]))
    {
        header("Location:../front/userlogin.php");
    }
    if(isset($_POST["uData"])){

        if($_POST["uData"]["delete"] == 0)
        {
            $email = $_POST["uData"]["email"];
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            //pattern for mobile number
            $mob="/^[1-9][0-9]*$/";

            $phone = $_POST["uData"]["phone"];

            if( $_POST["uData"]["name"] == "" || $_POST["uData"]["email"] == "" || $_POST["uData"]["phone"] == "" || $_POST["uData"]["address"] == "")
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
                $query="UPDATE customers SET cname=:name,cemail=:email,cstatus=:status,cphone=:phone,cindustry=:industry,caddress=:add WHERE cemail=:ref";
                $stmt=$conn->prepare($query);
                $stmt->execute(array(
                    ':name' => $_POST["uData"]["name"],
                    ':email' => $_POST["uData"]["email"],
                    ':phone' => $_POST["uData"]["phone"],
                    ':status' => $_POST["uData"]["status"],
                    ':industry' => $_POST["uData"]["industry"],
                    ':add' => $_POST["uData"]["address"],
                    ':ref' => $_POST["uData"]["ref-name"]
                    )
                );
                if($stmt)
                {
                    echo "1";
                }
            }
        }
        else
        {
            $query="DELETE from customers WHERE cemail = :ref";
            $stmt=$conn->prepare($query);
            $stmt->execute(array(
                ':ref' => $_POST["uData"]["ref-name"]
                )
            );
            if($stmt)
            {
                echo "0";
            }
        }
    }    
?>