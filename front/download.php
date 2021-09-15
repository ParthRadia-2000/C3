<?php
require_once("../connection/connect.php");
session_start();
if (!isset($_SESSION["email"])) {
    header("Location:../front/userlogin.php");
} else {
    if (isset($_GET['file_id'])) {
        $id = $_GET['file_id'];
        $stmt = $conn->prepare("select * from files where file_id=?");
        $stmt->bindparam(1, $id);
        $stmt->execute();
        $data = $stmt->fetch();
        print_r($data);
        $file = 'F:\xamppinstall\htdocs\C3\front\uploads/' . $data['file_name'];
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize('F:\xamppinstall\htdocs\C3\front\uploads/' . $data['f_name']));
            readfile('F:\xamppinstall\htdocs\C3\front\uploads/' . $data['file_name']);
            exit;
        }
    }
}