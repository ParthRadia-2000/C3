<?php
require("../connection/connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

if(isset($_POST['cData']))
{
    $firstname=$_POST['cData']['firstname'];
    $lastname=$_POST['cData']['lastname'];
    $email=$_POST['cData']['email'];
    $cmp=$_POST['cData']['cmp'];
    $mobile=$_POST['cData']['mobile'];
    $code=$_POST['cData']['pass'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    //pattern for mobile number
    $mob="/^[1-9][0-9]*$/";

    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        echo("email");
    }
    else if(!preg_match($mob, $mobile))
    {
        echo("mobile");
    }
    else if(strlen($code) < 8){
        echo("pass");
    }
    else if(strlen($mobile) < 10){
        echo("mobile");
    }
    else
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $found = "SELECT email FROM userlogin WHERE email=:email";
        $letfound = $conn->prepare($found);
        $letfound->execute(
            array(
                ':email' => $email
            )
        );
        $count=$letfound->rowCount();
        if($count>0)
        {
            echo "emailtaken";
        }
        else
        {
            $pass=password_hash($code,PASSWORD_DEFAULT);

            //  GENERATE VERIFICATION KEY
            $vkey=md5(time().$firstname);

            $sql = "INSERT INTO userlogin (firstname,lastname,company,email,password,mobile,vkey,verified)
                VALUES (:fname, :lname, :cmp, :email, :pass, :mob, :vkey, :verified)";
                $stmt=$conn->prepare($sql);
                $stmt->execute(
                array(
                    ':fname'=> $firstname,
                    ':lname'=> $lastname,
                    ':cmp'=> $cmp,
                    ':email'=> $email,
                    ':pass' => $pass,
                    ':mob' => $mobile ,
                    ':vkey' => $vkey,
                    ':verified' => '0' )
            );
            if($stmt)
            {
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = '';                     //SMTP username
                $mail->Password   = '';                               //SMTP password
                $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                //Recipients
                $mail->setFrom('', 'C3');     //Add a recipient
                $mail->addAddress($email);               //Name is optional
                
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'WELCOME TO C3';
                
                $mail->Body ="<a href='http://localhost/C3/front/verify.php?vkey=$vkey'>CLICK HERE TO VERIFY YOUR EMAIL ADDRESS</a>";

                if($mail->send() == true)
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
}
?>
