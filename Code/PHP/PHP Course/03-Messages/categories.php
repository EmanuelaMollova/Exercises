<?php
$title = 'Списък на всички категории';
include 'includes/header.php';

checkLoggedAdmin($connection, $_SESSION['username']);

if($_GET) {
    // If $_GET, we should edit the selected category.
    $legend = 'Редактирайте категория';
    $submit = 'Редактирайте';

    $id = normalize($connection, 'id', 'GET');

    // Select the category we want to edit, in order to fill in the form for edition.
    $q = mysqli_query($connection, 'SELECT name, picture from categories WHERE category_id='.$id);
    $rowsNumber = mysqli_num_rows($q);

    if($rowsNumber != 1) {
	// Error.
        header('Location: categories.php');
	exit();
    } else {
        $result = $q->fetch_assoc();

        $name = $result['name'];
        $picture = $result['picture'];
    }
} else {
    // If !$_GET, we add new category.
    $legend = 'Добавете нова категория';
    $submit = 'Добавете';
    $name = '';
    $picture = '';
}

if($_POST) {
    $nameFromPost = normalize($connection, 'name');
    $pictureFromPost = normalize($connection, 'picture');

    if(isset($id)) {
        // If the $id is set, this means we edit category.
        $q = mysqli_query($connection, 'UPDATE categories SET name="'.$nameFromPost.'", picture="'.$pictureFromPost.'" WHERE category_id='.$id );
        
	if($q) {
            header('Location: categories.php');
	    exit();
        } else {
            printError();
        }
    } else {
	// If the $id is not set, we add new category.
        $q = mysqli_query($connection, 'INSERT INTO categories (name, picture) VALUES ("'.$nameFromPost.'", "'.$pictureFromPost.'")');

        if(!$q) {
            printError();
        }
    }
}

$q = mysqli_query($connection, 'SELECT * from categories');
$rowsNumber = mysqli_num_rows($q);

if($rowsNumber > 0) {
    echo '<h1>Категории</h1>';

    echo 
    '<table>
        <tr>
            <th></th>
            <th>Име</th>
            <th>Редактирайте</th>';

            while($result = $q->fetch_assoc()) {
                echo '<tr>';

                echo '<td>';
                if($result['picture']) {
                    echo '<img src="resources/img/'.$result['picture'].'">';       
                }
                echo '</td>';

                echo '<td>'.$result['name'].'</td>';

                echo '<td>
                        <a href="categories.php?id='.$result['category_id'].'">
                            <img class="icon" src="resources/img/glyphicons_150_edit.png">
                        </a>
                      </td>';

                echo '</tr>';
            }
    echo '</table>';
} else {
    printMessage('Все още няма добавени категории.');
}
?>

<form method="POST">
    <fieldset>
        <legend class="bold"><img src="resources/img/glyphicons_065_tag.png"> <?php echo $legend; ?></legend>

        <label for="name"><img src="resources/img/glyphicons_030_pencil.png"> Име</label><br>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>"/><br>

        <label for="picture"><img src="resources/img/glyphicons_138_picture.png"> Изображение (име)</label><br>
        <input type="text" name="picture" id="picture" value="<?php echo $picture; ?>"/><br>

        <input type="submit" value="<?php echo $submit; ?>" />
    </fieldset>
</form>

<?php

if(isset($id)) {
    echo '<img class="icon" src="resources/img/glyphicons_435_undo.png"> <a href="categories.php">Отмени</a>';
}

printLink('glyphicons_330_blog', 'messages', 'Списък на всички съобщения');
printLink('glyphicons_124_message_plus', 'new_message', 'Добавете ново съобщение');
printLink('glyphicons_003_user', 'users', 'Потребители');

printLogout();

include 'includes/footer.php';
?>
