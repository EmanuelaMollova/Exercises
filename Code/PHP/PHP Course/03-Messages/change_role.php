<?php
$title = 'Администраторски права';
include 'includes/header.php';

checkLoggedAdmin($connection, $_SESSION['username']);

if($_GET) {
    $role = normalize($connection, 'role', 'GET');
    if($role == 2) {
	header('Location: change_role.php');
	exit();
    }
    $userId = normalize($connection, 'userId', 'GET');
}

$q = mysqli_query($connection, 'UPDATE users SET role ="'.$role.'" WHERE user_id = "'.$userId.'"');

if ($q) {
    header('Location: users.php');
    exit();
} else {
    printError();
}

include 'includes/footer.php';
?>
