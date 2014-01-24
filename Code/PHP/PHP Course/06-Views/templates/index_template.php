<a href="authors.php">Автори</a>
<a href="add_book.php">Нова книга</a>

<table border="1"><tr><td>Книга</td><td>Автори</td></tr>

<?php
if(isset($data['books'])) {
    foreach ($data['books'] as $row) {
        echo '<tr><td>' . $row['book_title'] . '</td> <td>';

        // This is here, because it's logic, connected to displaying the authors,
        // is is not business logic
        $ar = array();
        foreach ($row['authors'] as $k => $va) {
            $ar[] = '<a href="index.php?author_id=' . $k . '">' . $va . '</a>';
        }
        echo implode(', ', $ar) . '</td></tr>';
    }
}
?>

</table>
