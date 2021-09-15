<?php
require("../connection/connect.php");

if(isset($_POST['email']))
{
    $email = $_POST['email'];

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
        echo "1";
    }
}
?>
