<?php
    require("../connection/connect.php");
    session_start();
    if(!isset($_SESSION["emp_email"]))
    {
        header("Location:../front/userlogin.php");
    }
    $data =array();

    $email=$_SESSION['emp_email'];  
    $employee = "SELECT id,firstname,lastname FROM employees where email = '$email'";
    $stmt=$conn->prepare($employee);
    $stmt->execute();
    foreach($stmt as $val){
        $emp_name= $val['firstname']. ' ' .$val['lastname'];
    }

    $tasks = "SELECT * FROM tasks WHERE task_receiver= '$emp_name' AND task_status='Assigned'";
    $stmt=$conn->prepare($tasks);
    $stmt->execute();
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
                'task_project_title' => $row["task_project_title"],
                'task_adate' =>$row["task_adate"],
                'description' => $row["task_description"]
            );
        }
        echo json_encode($data);
    }
    //print_r($data);
?>