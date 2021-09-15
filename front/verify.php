<?php
require("../connection/connect.php");
if (isset($_GET['vkey'])) {
    $select = "SELECT verified, vkey FROM userlogin WHERE verified=:verified AND vkey=:vkey LIMIT 1";
    $stmt = $conn->prepare($select);
    $stmt->execute(
        array(
            ':verified' => 0,
            'vkey' => $_GET['vkey']
        )
    );
    $count = $stmt->rowCount();
    if ($count == 1) {
        $update = "UPDATE userlogin SET verified=:verified WHERE vkey=:vkey";
        $stmt1 = $conn->prepare($update);
        $stmt1->execute(
            array(
                ':verified' => 1,
                'vkey' => $_GET['vkey']
            )
        );
        if ($stmt) {
            echo "Account verified successfully";
        }
    } else {
        echo ("This account is invalid or already verified");
    }
}