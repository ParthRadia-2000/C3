<?php
    require("../connection/connect.php");
    session_start();
    
    if(isset($_POST['cData']))
    {
        $uname=$_POST['cData']['email'];
        $pass=$_POST['cData']['pass'];

        $uname = filter_var($uname, FILTER_SANITIZE_EMAIL);

        if (filter_var($uname, FILTER_VALIDATE_EMAIL) == false) {
            echo("email");
        }
        else
        {
            $verify="SELECT email,emp_password FROM employees WHERE email=:email";
            $stmt=$conn->prepare($verify);
            $stmt->execute(
                array(
                    ':email' => $uname
                )
            );
            $count=$stmt->rowCount();
            if($count == 1)
            {
                foreach($stmt as $row)
                {
                    $password = $row['emp_password'];
                    $email = $row['email'];
                }
            }
            if($pass == $password)
            {
                $_SESSION["emp_email"] = $email;
                echo "matched";
            }
            else
            {
                echo "notmatched";
            }
        }
    }
?>