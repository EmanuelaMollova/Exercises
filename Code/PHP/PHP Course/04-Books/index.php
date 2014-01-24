<?php
$title = 'Книги';
include 'includes/header.php';

// If a concrete author is selected, set the needed variables.
if(isset($_GET['id'])) {
    $id = normalize($connection, 'id', 'GET'); 

    if(!$id || !is_numeric($id)) {
        header('Location: index.php');
    }
}

// If sorting criteria is given, set the needed variables.
if(isset($_GET['field']) && isset($_GET['method'])) {
    $field = normalize($connection, 'field', 'GET');
    $method = normalize($connection, 'method', 'GET');

    if(($field != 'book_title' && $field != 'author_name') || ($method != 'ASC' && $method != 'DESC')) {
        printMessage('Невалидни критерии за сортиране');
    }
}

// Start building the sql for the query.
$sql = 'SELECT * FROM books LEFT JOIN books_authors ON books.book_id = books_authors.book_id 
        LEFT JOIN authors ON books_authors.author_id = authors.author_id'; 

// If search criteria is given, set the needed variables and start adding clauses to the sql.
if(isset($_POST['search'])) {
    $searchTitle = normalize($connection, 'search');
    $sql .= ' WHERE books.book_title LIKE "%'.$searchTitle.'%"';
}

// If concrete author is selected, alter the sql.
if(isset($id)) {
    if(isset($_POST['search'])) {
        $sql .= 'AND authors.author_id='.$id;
    } else {
        $sql .= ' WHERE authors.author_id='.$id;
    }
}

// If sorting criteria is given, alter the sql.
if(isset($field)) {
    $sql .= ' ORDER BY '.$field.' '.$method;
}

$qAll = mysqli_query($connection, $sql);
$rowsNumberAll = mysqli_num_rows($qAll);

if($rowsNumberAll == 0) {
   printMessage('Няма книги, отговарящи на зададените критерии.'); 
} else {
?>

    <h1>Книги

    <?php
    // Change page's title if a concrete author is selected.
    if (isset($id)) {
        $sqlName = 'SELECT author_name FROM authors WHERE author_id='.$id;
        $qName = mysqli_query($connection, $sqlName);

        $rowNumberName = mysqli_num_rows($qName);
        if($rowNumberName == 1) {
            $resultName = $qName->fetch_assoc();
        } else {
            printError();
        }

        echo 'на '.$resultName['author_name'];
    }
    
    echo '</h1>';

    if(isset($id) || isset($_POST['search'])) {
        printLink('glyphicons_435_undo', 'index', 'Обратно към всички книги');
    }
    ?>

    <table>
        <tr>
            <th>Книга</th>
            <th>Автор(и)</th>
        </tr>

        <?php
        // Print the books, which meet all criterias.
        while($result = $qAll->fetch_assoc()) {
            if(isset($id)) {
                // If a concrete author is selected, find in which books this author participated.
                $books[] = $result['book_id'];
            } else {
                $arr[$result['book_id']]['book_title'] = $result['book_title'];
                $arr[$result['book_id']]['authors'][] = $result['author_name'];
                $ids[$result['author_name']] = $result['author_id'];
            }
        }

        if(isset($id)) {
            // Create a new query for taking all the authors of the books, 
            // in which the concrete author participated.
            $sql = 'SELECT * FROM books LEFT JOIN books_authors ON books.book_id = books_authors.book_id 
                    LEFT JOIN authors ON books_authors.author_id = authors.author_id WHERE';

            foreach($books as $bookId) {
                $sql .= ' books.book_id = '.$bookId.' OR';
            }
            $sql = rtrim($sql, ' OR');

            $qNew = mysqli_query($connection, $sql);
            $rowsNumberNew = mysqli_num_rows($qNew);
            if($rowsNumberNew > 0) {
                while($result = $qNew->fetch_assoc()) {
                    $arr[$result['book_id']]['book_title'] = $result['book_title'];
                    $arr[$result['book_id']]['authors'][] = $result['author_name'];
                    $ids[$result['author_name']] = $result['author_id'];
                }
            } else {
                printError();
            }
        }

        foreach ($arr as $book) {
            echo '<tr><td>'.$book['book_title'].'</td><td>';
            foreach ($book['authors'] as $author) {
                echo '<a href="index.php?id='.$ids[$author].'">'.$author.'</a> ';
            }
            echo '</td></tr>';
        }

        echo '<tr>';
        if(!isset($_POST['search'])) {
            if(isset($id)) {
                printSorting('book_title', $id);
                printSorting('author_name', $id);
            } else {
                printSorting('book_title');
                printSorting('author_name');
            }
        }
        echo '</tr>';
        ?>
    </table>

    <form method=POST>
        <fieldset>
            <legend><img src="resources/img/glyphicons_027_search.png"> Търсене на книга</legend>
            <input type="text" name="search" id="title"><br>
            <input type="submit" value="Търсене">

        </fieldset>
    </form>

<?php
}		

printHome();
printLink('glyphicons_034_old_man', 'new_author', 'Добавете нов автор'); 
printLink('glyphicons_351_book_open', 'new_book', 'Добавете нова книга'); 

include 'includes/footer.php';
?>
