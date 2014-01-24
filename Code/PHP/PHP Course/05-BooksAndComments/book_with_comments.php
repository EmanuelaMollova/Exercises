<?php
$title = 'Коментари за книга';
include 'includes/header.php';

// The id of the book for which we want to see comments.
if(isset($_GET['id'])) {
    $id = normalize($connection, 'id', 'GET');
}

if(isset($_POST['comment'])) {
    $comment = normalize($connection, 'comment');
    
    if(mb_strlen($comment) < 4) {
        printMessage('Коментарът е твърде кратък.');
    } else {
        $sqlComment = 'INSERT INTO comments (book_id, user_id, comment, datetime) 
                       VALUES ('.$id.', '.$_SESSION['id'].', "'.$comment.'", '.time().')';

        if(!$qComment = mysqli_query($connection, $sqlComment)) {
            printError();
        }
    }
}

// Select the book.
$sqlBook = 'SELECT * FROM books LEFT JOIN books_authors ON books.book_id = books_authors.book_id 
            LEFT JOIN authors ON books_authors.author_id = authors.author_id 
            WHERE books.book_id = '.$id; 

$qBook = mysqli_query($connection, $sqlBook);
$rowsNumberBook = mysqli_num_rows($qBook);

if($rowsNumberBook < 1) {
   printMessage('Няма такава книга.'); 
} else {
    while($result = $qBook->fetch_assoc()) {
        $title = $result['book_title'];
        $authors[] = $result['author_name'];
        $ids[$result['author_name']] = $result['author_id'];
    }

    echo '<h1>'.$title.'</h1>';

    // Find all authors of the book.
    $allAuthors = '';

    foreach($authors as $author) { 
        $allAuthors .= '<a href="books.php?id='.$ids[$author].'">'.$author.'</a>, '; 
    }
    $allAuthors = rtrim($allAuthors, ', ');

    echo '<h3>(от '.$allAuthors.')</h3>';

    // Select all comments for the book.
    $sqlAllComments = 'SELECT * FROM comments LEFT JOIN users ON comments.user_id = users.user_id
                       WHERE comments.book_id ='.$id.' ORDER BY comments.datetime DESC';
                   
    $qAllComments = mysqli_query($connection, $sqlAllComments);
    $rowsNumberComments = mysqli_num_rows($qAllComments);

    if($rowsNumberComments > 0) {
        echo '<table>
                  <tr>
                      <td>Дата и час</td>
                      <td>Коментар</td>
                      <td>Добавен от</td>';

        while($result = $qAllComments->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.date('d-m-Y H:i', $result['datetime']).'</td>';
            echo '<td>'.$result['comment'].'</td>';
            echo '<td><a href="user_comments.php?id='.$result['user_id'].'">'.$result['username'].'</a></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        printMessage('Все още няма добавени коментари.');
    }

    // If the user is logged, show the form for adding comments.
    if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
?>

        <form method=POST>
            <fieldset>
                <legend><img src="resources/img/glyphicons_029_notes_2.png"> Добавете коментар</legend>
                <textarea name="comment" cols="40" rows="7"></textarea><br>

                <input type="submit" value="Добавте">
            </fieldset>
        </form>

<?php
    } else {
        echo 'За да можете да добавите коментар, моля <a href="index.php">влезте</a> в системата.<br>
              Ако нямате регистрация, можете да си направите <a href="register.php">оттук</a>.';
    }
}		

include 'includes/footer.php';
?>
