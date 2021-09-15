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

    $deals = "SELECT * FROM deals WHERE dresponsible=:res AND dtype=:tp";
    $stmt=$conn->prepare($deals);
    $stmt->execute(array(
            ':res' => $name,
            ':tp' => "InProgress"
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
                'did' =>$row["did"],
                'dclient' =>$row["dclient"],
                'dname' => $row["dname"],
                'dcompany' => $row["dcompany"],
                'damount' => $row["damount"],
                'dresponsible' => $row["dresponsible"],
                'dsdate' => $row["dsdate"]
            );
        }
        echo json_encode($data);
    }
    //print_r($data);
?>