<?php
    session_start();
    require("../connection/connect.php");
    if(!isset($_SESSION["email"]))
    {
        header("Location:../front/userlogin.php");
    }
    else
    {
        if(isset($_POST['cData']))
        {
            $title=$_POST['cData']['title'];
            $description=$_POST['cData']['description'];
            $sdate=$_POST['cData']['sdate'];
            $edate=$_POST['cData']['edate'];
            $t_project_id=$_POST['cData']['t_project_id'];
            $t_project_title=$_POST['cData']['t_project_title'];
            $receiver=$_POST['cData']['receiver'];
            $status=$_POST['cData']['status'];
            $adate=$_POST['cData']['adate'];
            $sender=$_POST['cData']['sender'];
            

            if( $title == "" || $description == "" || $sdate == "" || $edate == ""||
                $receiver == "")
                {
                    echo ("required");
                }
            else
            {
                $insert = "INSERT into tasks(task_title,task_description,task_sdate,task_edate,task_project_id,task_project_title,task_receiver,task_status,task_adate,task_sender)
                        VALUES(:ttitle,:tdescription,:tsdate,:tedate,:tpid,:tptitle,:treceiver,:tstatus,:tadate,:tsender)";
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                        ':ttitle' => $title,
                        ':tdescription' => $description,
                        ':tsdate' => $sdate,
                        ':tedate' => $edate,
                        ':tpid' => $t_project_id,
                        ':tptitle' => $t_project_title,
                        ':treceiver' => $receiver,
                        ':tstatus' => $status,
                        ':tadate' => $adate,
                        ':tsender' => $sender
                    )
                );
                if($stmt)
                {
                    echo "inserted";
                }
                else
                {
                    echo "notinserted";
                }
            }
        }
        if(isset($_POST["uData"])){
            if($_POST["uData"]["delete"] == 0)
            {
                $task_id=$_POST['uData']['task_id'];
                $project_id=$_POST['uData']['project_id'];
                $title=$_POST['uData']['task_title'];
                $des=$_POST['uData']['description'];
                $sdate=$_POST['uData']['sdate'];
                $edate=$_POST['uData']['edate'];
                $receiver=$_POST['uData']['receiver'];
                $delete=$_POST['uData']['delete'];

                if($title == "" || $des == "")
                {
                    echo "required";
                }
                else
                {
                    $update="UPDATE tasks SET task_title=:title,task_description=:desc,task_sdate=:sdate,task_edate=:edate,task_receiver=:receiver WHERE task_id=:tid";
                    $stmt=$conn->prepare($update);
                    $stmt->execute(array(
                        ':title' => $_POST['uData']['task_title'],
                        ':desc' => $_POST['uData']['description'],
                        ':sdate' => $_POST['uData']['sdate'],
                        ':edate' => $edate=$_POST['uData']['edate'],
                        ':receiver' => $_POST['uData']['receiver'],
                        ':tid' => $_POST["uData"]["task_id"]
                        )
                    );
                    if($stmt)
                    {
                        echo "1";
                    }
                }
            }
            else
            {
                $query="DELETE from tasks WHERE task_id = :id";
                $stmt=$conn->prepare($query);
                $stmt->execute(array(
                    ':id' => $_POST["uData"]["task_id"]
                    )
                );
                if($stmt)
                {
                    echo "0";
                }
            }
        }
    }
?>