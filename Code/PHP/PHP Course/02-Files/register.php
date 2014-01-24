<?php
$title = 'Регистрация';
include 'includes/header.php';

// If the user is still not registered, show the form.
// Else show only the message for successful registration.
$showContent = true;

if($_POST) {
    // Normalization.
    $username = normalize('username');
    $email = normalize('email');
    $password = normalize('password', false);
    $confirm_password = normalize('confirm_password', false);

    // Validation.
    $error = false;

    if(mb_strlen($username) < 3) {
        printMessage('Потребителското име е твърде кратко.');
        $error = true;
    }
	
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        printMessage('Невалиден e-mail.');
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

    // Ensure unique username and email.
    if($items = getExplodedFileLines('users')) {
        $uniqueUsername = true;
        $uniqueEmail = true;

        foreach($items as $itemData) {
            if($username == $itemData[0]) {
                $uniqueUsername = false;
                break;
            }
            if($email == $itemData[1]) {
                $uniqueEmail = false;
                break;
            }
        }

        if(!$uniqueUsername) {
            printMessage('Потребителското име вече е заето.');
            $error = true;
        }
        if(!$uniqueEmail) {
            printMessage('Този e-mail е вече зает.');
            $error = true;
        }
    }

	if(!$error){
        $password = md5($password);
        $record = $username.'<EOF>'.$email.'<EOF>'.$password."\n";

		if(file_put_contents('database_files/users.txt', $record, FILE_APPEND)) {
			printMessage('Регистрацията е успешна.', 'success');
            $showContent = false;
		}
	}
}

if($showContent) {
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
                <label for="email">E-mail:</label><br>
                <input type="email" name="email" id="email" />
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
}
printLink('glyphicons_020_home', 'index', 'Начало'); 

include 'includes/footer.php';
?>