<?php
session_start();
include('../Model/model.php');
$delete=delete_account($_SESSION['userid']);
session_destroy();
header("location:http://192.168.1.120/etrade/root/portfolio");
?>