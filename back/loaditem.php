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

    $item = "SELECT * FROM items WHERE productmanager=:pmanager";
    $stmt=$conn->prepare($item);
    $stmt->execute(array(
            ':pmanager' => $name
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
                'id' => $row["itemid"],
                'itemname' => $row["itemname"],
                'price' => $row["price"],
                'pmanager' => $row["productmanager"],
                'cost' => $row["standardcost"],
                'taxcode' => $row["taxcode"],
                'size' => $row["size"],
                'color' => $row["color"],
                'billtype' => $row["billtype"],
                'condition' => $row["itemcondition"],
                'inventory' => $row["inventorytype"],
                'sale' => $row["sale"]
            );
        }
        echo json_encode($data);
    }
    //print_r($data);
?>