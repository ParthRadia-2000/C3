<?php
try{
    $username = "root";
    $password = "";    
    $conn = new PDO("mysql:host=localhost;dbname=c3", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
?>