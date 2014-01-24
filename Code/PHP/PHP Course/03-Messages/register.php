<?php
$title = 'Регистрация';
include 'includes/header.php';

if($_POST) {
    // Normalization.
    $username = normalize($connection, 'username');
    $password = normalize($connection, 'password');
    $confirm_password = normalize($connection, 'confirm_password');
    $email = normalize($connection, 'email');
    $gender = normalize($connection, 'gender');

    // Validation.
    $error = false;

    if(mb_strlen($username) < 5) {
        printMessage('Потребителското име е твърде кратко.');
        $error = true;
    }
	
    if(mb_strlen($password) < 5) {
        printMessage('Паролата трябва да е от поне 5 символа.');
        $error = true;
    }

    if($password != $confirm_password) {
        printMessage('Двете пароли не съвпадат!');
        $error = true;
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        printMessage('Невалиден e-mail.');
        $error = true;
    }

    if($gender != 0 && $gender != 1) {
        printMessage('Невалиден пол.');
        $erorr = true;
    }

    // Ensure unique username.
    $q = mysqli_query($connection, 'SELECT user_id FROM users WHERE username = "'.$username.'"');
    $rowsNumber = mysqli_num_rows($q);

    if($rowsNumber > 0) {
        printMessage('Потребителското име вече е заето.');
        $error = true;
    }

    if(!$error) {
        $sql = 'INSERT INTO users (username, password, gender, email) VALUES ("'.$username.'", "'.$password.'", '.$gender.', "'.$email.'")';
        $q = mysqli_query($connection, $sql);

	if($q) {
            header('Location: index.php');
	    exit();
	} else {
            printError();
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
            <label for="email">E-mail:</label><br>
            <input type="email" name="email" id="email" />
        </div>

        <div>
            <label for="gender">Пол:</label><br>
            <select name="gender" id="gender">
                <option value="0">Мъж</option>
                <option value="1">Жена</option>
            </select>
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
printLink('glyphicons_020_home', 'index', 'Начало'); 

include 'includes/footer.php';
?>
