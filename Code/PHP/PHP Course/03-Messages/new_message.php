<?php
$title = 'Добавете ново съобщение';
include 'includes/header.php';

checkLogged();

$q = mysqli_query($connection, 'SELECT category_id, name from categories');

$rowsNumber = mysqli_num_rows($q);
if($rowsNumber > 0) {

    if($_POST) {
        $title = normalize($connection, 'title'); 
        $body = normalize($connection, 'body'); 
        $category = normalize($connection, 'category');

	$error = false;

        if(mb_strlen($title) < 1 || mb_strlen($title) > 50) {
            $error = true;
            printMessage('Заглавието трябва да е с дължина между 1 и 50 символа.');
        }

        if(mb_strlen($body) < 1 || mb_strlen($body) > 250) {
            $error = true;
            printMessage('Съобщението трябва да е с дължина между 1 и 250 символа.');
        }

        if(!$error) {
            $time = time();
            $user = mysqli_real_escape_string($connection, $_SESSION['username']);

            $qInsert = mysqli_query($connection, 'INSERT INTO messages (date_when_added, title, body, user, category) VALUES ('.$time.', "'.$title.'", "'.$body.'", "'.$user.'", "'.$category.'")');

            if($qInsert) {
                header('Location: messages.php');
            } else {
                printError();
            }
        }
    }
?>

    <h1>Добавете ново съобщение</h1>

    <form method="POST">
        <fieldset>
            <legend class="bold"><img src="resources/img/glyphicons_030_pencil.png"> Заглавие</legend>
            <input type="text" name="title" id="title" />
        </fieldset>

        <fieldset>
            <legend class="bold"><img src="resources/img/glyphicons_039_notes.png"> Съобщение</legend>
            <input type="textarea" name="body" id="body" />
        </fieldset>

        <fieldset>
            <legend class="bold"><img src="resources/img/glyphicons_065_tag.png"> Категория</legend>
            <select name="category">
            <?php		
            while($result = $q->fetch_assoc()) {
                echo '<option value="'.$result['category_id'].'">'.$result['name'].'</option>';
            }
            ?>
            </select>
        </fieldset>

    	<input type="submit" value="Добавяне" />
    </form>

<?php
} else {
    printMessage('Трябва да има добавени категории, за да добавяте и съобщения.');
    
    if(isAdmin($connection, $_SESSION['username'])) {
        printMessage('Можете да добавите от <a href="categories.php">тук</a>.');
    } else {
        printMessage('Свържете се с някой администратор, за да добави.');
    }
}

printLink('glyphicons_330_blog', 'messages', 'Списък на всички съобщения');

if(isAdmin($connection, $_SESSION['username'])) {
    printLink('glyphicons_003_user', 'users', 'Потребители');
    printLink('glyphicons_065_tag', 'categories', 'Категории');
}

printLogout();

include 'includes/footer.php';
?>
