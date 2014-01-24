<?php
$title = 'Добавете нова книга';
include 'includes/header.php';

// Insert new book to the database.
if($_POST) {
    if(isset($_POST['title']) && !isset($_POST['authors'])) {
        printMessage('Моля изберете автор(и) от списъка.');
    } else {
        
        $title = normalize($connection, 'title'); 
        $error = false;

        if(mb_strlen($title) < 3) {
            printMessage('Заглавието е твърде късо.');
            $error = true;
        }

        $qSameBook = mysqli_query($connection, 'SELECT book_id FROM books WHERE book_title = "'.$title.'"');
        $rowsNumberSame = mysqli_num_rows($qSameBook);

        if($rowsNumberSame != 0) {
            printMessage('Вече има книга с това заглавие.');
            $error = true;
        }

        if(!$error) {
            $q = mysqli_query($connection, 'INSERT INTO books (book_title) VALUES ("'.$title.'")');
            $bookId = mysqli_insert_id($connection);
            if($bookId == 0) {
                printError();
            } else {
                foreach ($_POST['authors'] as $author) {
                    $author_id = mysqli_real_escape_string($connection, trim($author)); 
                    if(!$author_id || !is_numeric($author_id)) {
                        printError();
                    } else {
                        $qq = mysqli_query($connection, 'INSERT INTO books_authors (book_id, author_id) VALUES ('.$bookId.', '.$author.')');
                    }
                }

                if(!$q || !$qq) {
                    printError();
                } else {
                    printMessage('Книгата е добавена успешно.', 'success');
                }
            }
        }
    }
}

// Show all authors
$qAllAuthors = mysqli_query($connection, 'SELECT * from authors');
$rowsNumberAll = mysqli_num_rows($qAllAuthors);

if($rowsNumberAll > 0) {
?>

    <h1>Добавете нова книга</h1>

    <form method="POST">
        <fieldset>
            <legend class="bold"><img src="resources/img/glyphicons_351_book_open.png"> Добавяне</legend>
            <label for="title">Заглавие:</label><br>
            <input type="text" name="title" id="title" /><br>

            <label for="authors">Автор(и):</label><br>
            <select name="authors[]" multiple>
                <?php
                while($result = $qAllAuthors->fetch_assoc()) {
                    echo '<option value="'.$result['author_id'].'">'.$result['author_name'].'</option>';
                }
                ?>
            </select><br>

            <input type="submit" value="Добавяне" />
        </fieldset>
    </form>

<?php
} else {
    printMessage('Все още няма добавени автори, за които да добаяте книги.');
}

include 'includes/footer.php';
?>
