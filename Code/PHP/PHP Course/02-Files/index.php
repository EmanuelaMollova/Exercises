<?php
$title = 'Добре дошли!';
include 'includes/header.php';

if($_POST) {
    $username = normalize('username', false);
    $password = normalize('password', false);

    if($items = getExplodedFileLines('users')) {
        foreach($items as $itemData) {
            // If there is such username or email with this password, set isLogged = true.
            if(($username == $itemData[0] || $username == $itemData[1]) && md5($password) == trim($itemData[2])) {
                $_SESSION['isLogged'] = true;
                
                if($username == $itemData[1]) {
                    $_SESSION['username'] = $itemData[0];
                } else {
                    $_SESSION['username'] = $username;
                }
            } 
        }
    }

    if(!isset($_SESSION['isLogged'])) {
        printMessage('Невалидно потребителско име или парола.');
    } elseif($_SESSION['isLogged'] == true) {
        header('Location: files.php');
        exit();
    }
} 
?>

<h1>Добре дошли!</h1>

<form method ="POST">	
    <fieldset>
        <legend class="bold"><img src="resources/img/glyphicons_003_user.png"> Вход</legend>
        
        <div>
            <label for="username">Потребителско име / e-mail:</label><br>
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