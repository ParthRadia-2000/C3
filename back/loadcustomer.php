<?php
    require("../connection/connect.php");
    session_start();
    if(!isset($_SESSION["email"]))
    {
        header("Location:../front/userlogin.php");
    }
    $data =array();

    $user = "SELECT firstname,lastname FROM userlogin WHERE email=:email";
    $stmt=$conn->prepare($user);
    $stmt->execute(array(
            ':email' => $_SESSION["email"]
        )
    );
    foreach($stmt as $row)
    {
        $name = $row["firstname"] . " " . $row["lastname"];
    }

    $customer = "SELECT * FROM customers WHERE csalesrep=:cby";
    $stmt=$conn->prepare($customer);
    $stmt->execute(array(
            ':cby' => $name
        )
    );
    $count=$stmt->rowCount();
    if($count == 0)
    {
        echo "0";
    }
    else
    {
        foreach($stmt as $row)
        {
            $data[] = array(
                'cid' =>$row["customerid"],
                'cname' => $row["cname"],
                'salesrep' => $row["csalesrep"],
                'status' => $row["cstatus"],
                'phone' => $row["cphone"],
                'email' => $row["cemail"],
                'industry' => $row["cindustry"],
                'address' => $row["caddress"]
            );
        }
        echo json_encode($data);
    }
    //print_r($data);
?>