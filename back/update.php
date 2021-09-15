<?php
require_once("../connection/connect.php");
if(isset($_POST["cData"])){
    if($_POST["cData"]["event-delete"] == 0)
    {
        $query="UPDATE events SET title=:title,color=:color WHERE id = :id";
        $stmt=$conn->prepare($query);
        $stmt->execute(array(
            ':title' => $_POST["cData"]["event-name"],
            ':color' => $_POST["cData"]["event-color"],
            ':id' => $_POST["cData"]["event-id"]
            )
        );
        if($stmt)
        {
            echo "1";
        }
    }
    else
    {
        $query="DELETE from events WHERE id = :id";
        $stmt=$conn->prepare($query);
        $stmt->execute(array(
            ':id' => $_POST["cData"]["event-id"]
            )
        );
    }
}
?>