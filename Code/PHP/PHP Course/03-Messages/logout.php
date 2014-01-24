<?php
session_start();
 
// Empty the $_SESSION array.
$_SESSION = array();

session_destroy();

header('Location: index.php');
exit();
?>
