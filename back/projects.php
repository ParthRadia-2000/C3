<?php
    session_start();
    require("../connection/connect.php");
    if(!isset($_SESSION["email"]))
    {
        header("Location:../front/userlogin.php");
    }
    else
    {
        if(isset($_POST['pData']))
        {
            $title=$_POST['pData']['title'];
            $description=$_POST['pData']['description'];
            $sdate=$_POST['pData']['sdate'];
            $edate=$_POST['pData']['edate'];
            $createdon=$_POST['pData']['createdon'];
            $createdby=$_POST['pData']['createdby'];
            

            if( $title == "" || $description == "" || $sdate == "" || $edate == ""||
                $createdon == "" || $createdby == "")
                {
                    echo ("required");
                }
            else
            {
                $insert = "INSERT into projects(project_title,project_description,project_start_date,project_end_date,project_created_on,project_created_by)
                        VALUES(:ptitle,:pdescription,:psdate,:pedate,:pon,:pby)";
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                        ':ptitle' => $title,
                        ':pdescription' => $description,
                        ':psdate' => $sdate,
                        ':pedate' => $edate,
                        ':pon' => $createdon,
                        ':pby' => $createdby
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
                $id=$_POST['uData']['id'];
                $title=$_POST['uData']['title'];
                $sdate=$_POST['uData']['sdate'];
                $edate=$_POST['uData']['edate'];
                $des=$_POST['uData']['description'];
                $delete=$_POST['uData']['delete'];

                if($title == "" || $des == "")
                {
                    echo "required";
                }
                else
                {
                    $query="UPDATE projects SET project_title=:title,project_description=:des,project_start_date=:sdate,project_end_date=:edate WHERE projectid=:id";
                    $stmt=$conn->prepare($query);
                    $stmt->execute(array(
                        ':title' => $_POST["uData"]["title"],
                        ':sdate' => $_POST["uData"]["sdate"],
                        ':edate' => $_POST["uData"]["edate"],
                        ':des' => $_POST["uData"]["description"],
                        ':id' => $_POST["uData"]["id"]
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
                $query="DELETE from projects WHERE projectid = :id";
                $stmt=$conn->prepare($query);
                $stmt->execute(array(
                    ':id' => $_POST["uData"]["id"]
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