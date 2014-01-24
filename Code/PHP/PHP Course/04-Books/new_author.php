<?php
$title = 'Добавете нов автор';
include 'includes/header.php';

// Insert new author to the database
if(isset($_POST['name'])) {
	$name = normalize($connection, 'name'); 
	$error = false;

	if(mb_strlen($name) < 3) {
		printMessage('Името е твърде късо.');
		$error = true;
	}

    $qSameAuthor = mysqli_query($connection, 'SELECT author_id FROM authors WHERE author_name = "'.$name.'"');
    $rowsNumberSame = mysqli_num_rows($qSameAuthor);

    if($rowsNumberSame != 0) {
        printMessage('Вече има добавен автор с това име');
        $error = true;
    }

	if(!$error) {
		$q = mysqli_query($connection, 'INSERT INTO authors (author_name) VALUES ("'.$name.'")');

		if(!$q) {
			printError();
		} 
	}
}
?>

<h1>Добавете нов автор</h1>

<form method="POST">
    <fieldset>
        <legend class="bold"><img src="resources/img/glyphicons_034_old_man.png"> Име:</legend>
        <input type="text" name="name" id="name" /><br>

        <input type="submit" value="Добавяне" />
    </fieldset>
</form>

<?php 
// Show all auhtors
$sql = 'SELECT * FROM authors';

// Sort the authors if sorting criteria is set
if(isset($_GET['field']) && isset($_GET['method'])) {
    $field = normalize($connection, 'field', 'GET');
    $method = normalize($connection, 'method', 'GET');

    if(($field != 'author_name') || ($method != 'ASC' && $method != 'DESC')) {
        printMessage('Невалидни критерии за сортиране');
    } else {
        $sql .= ' ORDER BY '.$field.' '.$method;
    }
}

$qAllAuthors = mysqli_query($connection, $sql);
$rowsNumberAll = mysqli_num_rows($qAllAuthors);

if($rowsNumberAll > 0) {
    echo 
    '<table>
        <tr>
            <th>Автори</th>
        </tr>';

    while($result = $qAllAuthors->fetch_assoc()) {
        echo '<tr><td><a href="index.php?id='.$result['author_id'].'">'.$result['author_name'].'</a></td></tr>';
    }

    echo '<tr>';
    printSorting('author_name', $id = false, 'new_author');
    echo '</tr>';

    echo '</table>';
}

printHome();
printLink('glyphicons_330_blog', 'index', 'Списък на всички книги');
printLink('glyphicons_351_book_open', 'new_book', 'Добавете нова книга'); 

include 'includes/footer.php';
?>
