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

    $tasks = "SELECT * FROM tasks WHERE task_sender=:sby";
    $stmt=$conn->prepare($tasks);
    $stmt->execute(array(
            ':sby' => $name
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
                'task_id'=> $row["task_id"],
                'title' => $row["task_title"],
                'sdate' => $row["task_sdate"],
                'edate' => $row["task_edate"],
                'task_project_id' => $row["task_project_id"],
                'task_project_title' => $row["task_project_title"],
                'task_receiver' =>$row["task_receiver"],
                'task_status' =>$row["task_status"],
                'task_adate' =>$row["task_adate"],
                'task_sender' =>$row["task_sender"],
                'description' => $row["task_description"]
            );
        }
        echo json_encode($data);
    }
    //print_r($data);
?>