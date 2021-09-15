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
            $verify="SELECT verified,password FROM userlogin WHERE email=:email";
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
                    $password = $row['password'];
                    $verified = $row['verified'];
                }
                if(password_verify($pass,$password) == 1)
                {
                    if($verified == 1)
                    {
                        $_SESSION["email"] = $uname;
                        echo "matched";
                    }
                    else
                    {
                        echo "vkey";
                    }
                }
                else
                {
                    echo "notmatched";
                }
            }
        }
    }
?>