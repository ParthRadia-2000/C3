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

    $project = "SELECT * FROM projects WHERE project_created_by=:cby";
    $stmt=$conn->prepare($project);
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
                'id' =>$row["projectid"],
                'title' => $row["project_title"],
                'sdate' => $row["project_start_date"],
                'edate' => $row["project_end_date"],
                'createdon' => $row["project_created_on"],
                'createdby' => $row["project_created_by"],
                'description' => $row["project_description"]
            );
        }
        echo json_encode($data);
    }
    //print_r($data);
?>