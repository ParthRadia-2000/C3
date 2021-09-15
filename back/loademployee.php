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

    $employee = "SELECT * FROM employees WHERE createdby=:cby";
    $stmt=$conn->prepare($employee);
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
                'id' =>$row["id"],
                'firstname' => $row["firstname"],
                'lastname' => $row["lastname"],
                'dob' => $row["DOB"],
                'email' => $row["email"],
                'joindate' => $row["joindate"],
                'dept' => $row["department"],
                'mob' => $row["mobile"],
                'con' => $row["createdon"],
                'cby' => $row["createdby"],
                'add' => $row["address"]
            );
        }
        echo json_encode($data);
    }
    //print_r($data);
?>