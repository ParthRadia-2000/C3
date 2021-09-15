<?php
    require_once("../connection/connect.php");
    session_start();

    $data = array();
    
    $query = "SELECT * from events  WHERE email=:email order by id";

    $stmt = $conn->prepare($query);

    $stmt->execute(array(
            ':email' => $_SESSION["email"]
        )
    );

    $result = $stmt->fetchAll();

    foreach($result as $row)
    {   
        $start = explode(" ", $row['start']);
        $end = explode(" ", $row['end']);
        if($start[1] == '00:00:00'){
            $start = $row[0];
        }else{
            $start = $row['start'];
        }
        if($end[1] == '00:00:00'){
            $end = $row[0];
        }else{
            $end = $row['end'];
        }
        $data[] = array(
            'id'          =>$row["id"],
            'title'       =>$row["title"],
            'color'       =>$row["color"],
            'start'       =>$row["start"],
            'end'         =>$row["end"],
        );
    }
    echo json_encode($data);
    //print_r($data);
?>