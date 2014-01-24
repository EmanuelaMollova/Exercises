<?php

include './inc/functions.php';

$data = array();

if ($_POST) {
    $author_name = trim($_POST['author_name']);

    if (mb_strlen($author_name) < 2) {
        $data['errors']['post'][] = 'Невалидно име.';
    } else {
        $author_esc = mysqli_real_escape_string($db, $author_name);

        $q = mysqli_query($db, 'SELECT * FROM authors WHERE author_name="'.$author_esc.'"');

        if (mysqli_error($db)) {
            $data['errors']['db'] = 'Грешка.';
        }

        if (mysqli_num_rows($q) > 0) {
            $data['errors']['post'][] = 'Има такъв автор.';
        } else {
            mysqli_query($db, 'INSERT INTO authors (author_name) VALUES("'.$author_esc.'")');

            if (mysqli_error($db)) {
                $data['errors']['db'] = 'Грешка.';
            } else {
                $data['success'] = 'Успешен запис.';
            }
        }
    }
}

$data['authors'] = getAuthors($db);
if ($data['authors'] === false) {
    $data['errors']['db'] = 'Грешка.';
}

$data['title'] = 'Автори';
$data['content'] = 'templates/authors_template.php';

render($data, 'templates/layouts/normal_layout.php');
