<?php
session_start();
mb_internal_encoding("UTF-8");
include 'functions.php';
include 'menu.php';

$errorMessage =  
'<h3>
    За съжаление възникна грешка при опит за свързване с базата данни. <br>
    Използвани са потребител <u>user</u> и парола <u>qwerty</u>, <br>
    можете да ги смените във файла <u>includes/header.php</u>.
 </h3>';

$connection = mysqli_connect('localhost', 'user', 'qwerty', 'books_comments') 
or die($errorMessage);

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
