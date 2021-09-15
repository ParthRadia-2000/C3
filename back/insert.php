<?php
require_once("../connection/connect.php");
if(isset($_POST["cData"])){
    $title = $_POST['cData']['event-name'];
    $color = $_POST['cData']['event-color'];
    $start = $_POST['cData']['event-start'];
    $end = $_POST['cData']['event-end'];
    $creator = $_POST['cData']['event-creator'];

    $query="insert into  events (title,email,color,start,end) values(:title,:email,:color,:start,:end)";
    $stmt=$conn->prepare($query);
    $stmt->execute(array(
        ':title' => $title,
        ':email' => $creator,
        ':color' => $color,
        ':start' => $start,
        ':end' => $end
        )
    );
    if($stmt)
    {
        echo "1";
    }
    else
    {
        echo "0";
    }
}
?>