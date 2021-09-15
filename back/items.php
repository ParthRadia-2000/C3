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
            $item_name=$_POST['cData']['item_name'];
            $item_price=$_POST['cData']['item_price'];
            $item_stdcost=$_POST['cData']['item_stdcost'];
            $item_taxcode=$_POST['cData']['item_taxcode'];
            $item_manager=$_POST['cData']['item_manager'];
            $item_sale=$_POST['cData']['item_sale'];
            $item_billtype=$_POST['cData']['item_billtype'];
            $item_size=$_POST['cData']['item_size'];
            $item_color=$_POST['cData']['item_color'];
            $item_condition=$_POST['cData']['item_condition'];
            $item_inventorytype=$_POST['cData']['item_inventorytype'];
            

            if( $item_name == "" || $item_price == "" || $item_stdcost == "" || $item_taxcode == ""||
                $item_manager == "" || $item_sale == "" || $item_billtype == "" ||
                $item_size == "" || $item_color == "" || $item_condition == "" || $item_inventorytype == "")
                {
                    echo ("required");
                }
            else
            {
                $insert = "INSERT into items(itemname,price,standardcost,taxcode,productmanager,sale,billtype,size,color,itemcondition,inventorytype)
                        VALUES(:iname,:price,:stdcost,:tax,:manager,:sale,:bill,:size,:color,:condition,:inventory)";
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                        ':iname' => $item_name,
                        ':price' => $item_price,
                        ':stdcost' => $item_stdcost,
                        ':tax' => $item_taxcode,
                        ':manager' => $item_manager,
                        ':sale' => $item_sale,
                        ':bill' => $item_billtype,
                        ':size' => $item_size,
                        ':color' => $item_color,
                        ':condition' => $item_condition,
                        ':inventory' => $item_inventorytype
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
        if(isset($_POST["uData"]))
        {
            if($_POST["uData"]["delete"] == 0)
            {
                $id=$_POST['uData']['id'];
                $name=$_POST['uData']['name'];
                $price=$_POST['uData']['price'];
                $stdcost=$_POST['uData']['stdcost'];
                $taxcode=$_POST['uData']['taxcode'];
                $size=$_POST['uData']['size'];
                $color=$_POST['uData']['color'];
                $condition=$_POST['uData']['condition'];
                $inventory=$_POST['uData']['inventory'];

                if($id == "" || $name == "" || $price == "" || $stdcost == "" || $taxcode == "" || $size == ""|| $color == "" || $condition == "" || $inventory == "" )
                {
                    echo "required";
                }
                else
                {
                    $query="UPDATE items SET itemname=:iname,price=:iprice,standardcost=:istdcost,taxcode=:itax,size=:size,color=:color,itemcondition=:icondition,inventorytype=:iinventory WHERE itemid=:id";
                    $stmt=$conn->prepare($query);
                    $stmt->execute(array(
                        ':iname' => $_POST["uData"]["name"],
                        ':iprice' => $_POST["uData"]["price"],
                        ':istdcost' => $_POST["uData"]["stdcost"],
                        ':itax' => $_POST["uData"]["taxcode"],
                        ':size' => $_POST["uData"]["size"],
                        ':color' => $_POST["uData"]["color"],
                        ':icondition' => $_POST["uData"]["condition"],
                        ':iinventory' => $_POST["uData"]["inventory"],
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
                /*$query="DELETE from projects WHERE projectid = :id";
                $stmt=$conn->prepare($query);
                $stmt->execute(array(
                    ':id' => $_POST["uData"]["id"]
                    )
                );
                if($stmt)
                {
                    echo "0";
                }*/
            }
        }
    }
?>