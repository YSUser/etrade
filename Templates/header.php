<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="CSS/styles.css" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="wrapper">
<h1><a href="../root/index">E-trade</a></h1>
<?php if (isset($_SESSION['userid'])) render('toolbar'); ?>
<div id="background">
