<?php
$title = 'Регистрация';
include 'includes/header.php';

if($_POST) {

    // Normalization.
    $username = normalize($connection, 'username');
    $password = normalize($connection, 'password');
    $confirm_password = normalize($connection, 'confirm_password');

    // Validation.
    $error = false;

    if(mb_strlen($username) < 4) {
        printMessage('Потребителското име е твърде кратко.');
        $error = true;
    }
	
    if(mb_strlen($password) < 4) {
        printMessage('Паролата трябва да е от поне 4 символа.');
        $error = true;
    }

    if($password != $confirm_password) {
        printMessage('Двете пароли не съвпадат!');
        $error = true;
    }

    // Ensure unique username.
    $q = mysqli_query($connection, 'SELECT user_id FROM users WHERE username = "'.$username.'"');
    $result = mysqli_num_rows($q);

    if($result > 0) {
        printMessage('Потребителското име вече е заето.');
        $error = true;
    }

	if(!$error){
        $sql = 'INSERT INTO users (username, password) VALUES ("'.$username.'", "'.$password.'")';
        $q = mysqli_query($connection, $sql);

		if($q) {
			printMessage('Регистрацията е успешна.', 'success');
		} else {
            printMessage('Грешка при регистрацията.');
        }
	} 
}
?>

<h1>Регистрирайте се</h1>

<form method ="POST">	
    <fieldset>
        <legend class="bold"><img src="resources/img/glyphicons_006_user_add.png"> Регистрация</legend>
        
        <div>
            <label for="username">Потребителско име:</label><br>
            <input type="text" name="username" id="username" />
        </div>

        <div>
            <label for="password">Парола:</label><br>
            <input type="password" name="password" id="password" />
        </div>

        <div>
            <label for="confirm_password">Потвърдете паролата:</label><br>
            <input type="password" name="confirm_password" id="confirm_password" />
        </div>

        <input class="bold" type="submit" value="Потвърди" />
    </fieldset>
</form>

<?php
printLink('glyphicons_044_keys', 'index', 'Вход'); 

include 'includes/footer.php';
?>
