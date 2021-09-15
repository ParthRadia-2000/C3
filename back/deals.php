<?php
    session_start();
    require("../connection/connect.php");
    if(!isset($_SESSION["email"]))
    {
        header("Location:../front/userlogin.php");
    }
    else
    {
        if(isset($_POST['nData']))
        {
            $insert = "INSERT into deals(dclient,dname,dcompany,damount,dresponsible,dprobability,dsdate,dtype)
                        VALUES(:c,:name,:dc,:a,:r,:p,:sd,:t)";
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                        ':c' => $_POST["nData"]["client"],
                        ':name' => $_POST["nData"]["deal"],
                        ':dc' => $_POST["nData"]["com"],
                        ':a' => $_POST["nData"]["amount"],
                        ':r' => $_POST["nData"]["res"],
                        ':p' => $_POST["nData"]["prob"],
                        ':sd' => $_POST["nData"]["sdate"],
                        ':t' => $_POST["nData"]["dtype"]
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
        else if(isset($_POST['pData']))
        {
            $insert = "INSERT into deals(dclient,dname,dcompany,damount,dresponsible,dprobability,dsdate,dtype)
                        VALUES(:c,:name,:dc,:a,:r,:p,:sd,:t)";
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                        ':c' => $_POST["pData"]["client"],
                        ':name' => $_POST["pData"]["deal"],
                        ':dc' => $_POST["pData"]["com"],
                        ':a' => $_POST["pData"]["amount"],
                        ':r' => $_POST["pData"]["res"],
                        ':p' => $_POST["pData"]["prob"],
                        ':sd' => $_POST["pData"]["sdate"],
                        ':t' => $_POST["pData"]["dtype"]
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

        else if(isset($_POST['wData']))
        {
            $insert = "INSERT into deals(dclient,dname,dcompany,damount,dresponsible,dprobability,dsdate,dtype)
                        VALUES(:c,:name,:dc,:a,:r,:p,:sd,:t)";
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                        ':c' => $_POST["wData"]["client"],
                        ':name' => $_POST["wData"]["deal"],
                        ':dc' => $_POST["wData"]["com"],
                        ':a' => $_POST["wData"]["amount"],
                        ':r' => $_POST["wData"]["res"],
                        ':p' => $_POST["wData"]["prob"],
                        ':sd' => $_POST["wData"]["sdate"],
                        ':t' => $_POST["wData"]["dtype"]
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

        else if(isset($_POST['lData']))
        {
            $insert = "INSERT into deals(dclient,dname,dcompany,damount,dresponsible,dprobability,dsdate,dtype)
                        VALUES(:c,:name,:dc,:a,:r,:p,:sd,:t)";
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                        ':c' => $_POST["lData"]["client"],
                        ':name' => $_POST["lData"]["deal"],
                        ':dc' => $_POST["lData"]["com"],
                        ':a' => $_POST["lData"]["amount"],
                        ':r' => $_POST["lData"]["res"],
                        ':p' => $_POST["lData"]["prob"],
                        ':sd' => $_POST["lData"]["sdate"],
                        ':t' => $_POST["lData"]["dtype"]
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
?>