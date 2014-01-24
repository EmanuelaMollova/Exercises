<?php
$title = 'Добре дошли!';
include 'includes/header.php';

if($_POST) {
    $username = normalize($connection, 'username');
    $password = normalize($connection, 'password');

    $q = mysqli_query($connection, 'SELECT user_id FROM users WHERE username = "'.$username.'" AND password = "'.$password.'"');
    $rowsNumber = mysqli_num_rows($q);

    if($rowsNumber == 1) {
        $_SESSION['isLogged'] = true;
        $_SESSION['username'] = $username;
    }

    if(!isset($_SESSION['isLogged'])) {
        printMessage('Невалидно потребителско име или парола.');
    } elseif($_SESSION['isLogged'] == true) {
        header('Location: messages.php');
        exit();
    }
} 
?>

<h1>Добре дошли!</h1>

<form method ="POST">	
    <fieldset>
        <legend class="bold"><img src="resources/img/glyphicons_003_user.png"> Вход</legend>
        
        <div>
            <label for="username">Потребителско име:</label><br>
            <input type="text" name="username" id="username" />
        </div>

        <div>
            <label for="password">Парола:</label><br>
            <input type="password" name="password" id="password" />
        </div>

        <input class="bold" type="submit" value="Влез" />
    </fieldset>
</form>

<?php		
printLink('glyphicons_006_user_add', 'register', 'Нямате регистрация?'); 

include 'includes/footer.php';
?>
