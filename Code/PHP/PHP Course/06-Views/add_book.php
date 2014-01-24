<?php

include './inc/functions.php';

$data = array();

$authors = getAuthors($db);
if ($authors === false) {
    $data['errors']['db'] = 'Грешка.';
}

foreach ($authors as $row) {
    $data['authors'][$row['author_id']] = $row['author_name'];
}

if ($_POST) {

    $book_name = trim($_POST['book_name']);

    if (!isset($_POST['authors'])) {
        $_POST['authors'] = '';
    }
    $authors = $_POST['authors'];

    if (mb_strlen($book_name) < 2) {
        $data['errors']['post'][] = 'Невалидно име.';
    }

    if (!is_array($authors) || count($authors) == 0) {
        $data['errors']['post'][] = 'Грешка.';
    }

    if (!isAuthorIdExists($db, $authors)) {
        $data['errors']['post'][] = 'Невалиден автор.';
    }

    if (!isset($data['errors']['post'])) {
        mysqli_query($db,
            'INSERT INTO books (book_title) VALUES("'.mysqli_real_escape_string($db, $book_name).'")'
        );

        if (mysqli_error($db)) {
            $data['errors']['db'] = 'Error';
            exit;
        }

        $id = mysqli_insert_id($db);
        foreach ($authors as $authorId) {
            mysqli_query($db,
                'INSERT INTO books_authors (book_id,author_id) VALUES ('. $id.','.$authorId .')'
            );

            if (mysqli_error($db)) {
                $data['errors']['db'] = 'Error';
                exit;
            }
        }
        $data['success'] = 'Книгата е добавена.';
    }
}

$data['title'] = 'Нова книга';
$data['content'] = 'templates/add_book_template.php';

render($data, 'templates/layouts/normal_layout.php');
