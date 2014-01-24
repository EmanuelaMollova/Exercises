<?php

session_start();
mb_internal_encoding("UTF-8");
include 'functions.php';

$connection = mysqli_connect('localhost', 'user', 'qwerty', 'messages');
if(!$connection) {
    printError();
}
mysqli_set_charset ($connection, 'utf8');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8 />
	<title><?php echo $title; ?></title>
	
	<link href='http://fonts.googleapis.com/css?family=Underdog&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" media="screen" href="resources/css/style.css" />
</head>
<body>
