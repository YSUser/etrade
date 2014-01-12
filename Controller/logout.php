<?php
session_start();
//unset($_SESSION['auth']); Old version
session_destroy();
header("location:http://192.168.1.120/etrade/root/index");
?>