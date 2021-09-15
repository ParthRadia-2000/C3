<?php
    require("../connection/connect.php");
    session_start();
    
    if(isset($_POST['rData']))
    {
        $uname=$_POST['rData']['email'];
        $pass=$_POST['rData']['pass'];

        $uname = filter_var($uname, FILTER_SANITIZE_EMAIL);

        $found = "SELECT email FROM userlogin WHERE email=:email";
        $letfound = $conn->prepare($found);
        $letfound->execute(
            array(
                ':email' => $uname
            )
        );
        $count=$letfound->rowCount();
        
        if (filter_var($uname, FILTER_VALIDATE_EMAIL) == false) {
            echo("email");
        }

        else if($count == 0)
        {
            echo "emailinvalid";
        }

        else
        {
            $code=password_hash($pass,PASSWORD_DEFAULT);

            $verify="UPDATE userlogin SET password=:ps where email='$uname'";
            $stmt=$conn->prepare($verify);
            $stmt->execute(
                array(
                    ':ps' => $code
                )
            );
            if($stmt)
            {
                echo "reset";
            }
            else
            {
                echo 'notreset';
            }
        }
    }
?>