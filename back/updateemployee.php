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

            $phone = $_POST["uData"]["mob"];

            if( $_POST["uData"]["fname"] == "" || $_POST["uData"]["lname"] == "" || $_POST["uData"]["email"] == "" || $_POST["uData"]["mob"] == "" || $_POST["uData"]["add"] == "")
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
                $query="UPDATE employees SET firstname=:fname,lastname=:lname,DOB=:dob,email=:email,joindate=:jdate,department=:dept,mobile=:mob,address=:add WHERE email=:ref";
                $stmt=$conn->prepare($query);
                $stmt->execute(array(
                    ':fname' => $_POST["uData"]["fname"],
                    ':lname' => $_POST["uData"]["lname"],
                    ':dob' => $_POST["uData"]["bdate"],
                    ':email' => $_POST["uData"]["email"],
                    ':jdate' => $_POST["uData"]["jdate"],
                    ':dept' => $_POST["uData"]["dept"],
                    ':mob' => $_POST["uData"]["mob"],
                    ':add' => $_POST["uData"]["add"],
                    ':ref' => $_POST["uData"]["ref"]
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
            $query="DELETE from employees WHERE email = :ref";
            $stmt=$conn->prepare($query);
            $stmt->execute(array(
                ':ref' => $_POST["uData"]["ref"]
                )
            );
            if($stmt)
            {
                echo "0";
            }
        }
    }    
?>