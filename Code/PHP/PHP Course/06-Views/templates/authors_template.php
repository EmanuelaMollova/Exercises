<a href="index.php">Списък</a>
<a href="add_book.php">Нова книга</a>

<form method="post" action="authors.php">
    Име: <input type="text" name="author_name" />
    <input type="submit" value="Добави" />
</form>

<table border='1'>
    <tr><th>Автор</th></tr>

    <?php
    if($data['authors']) {
        foreach ($data['authors'] as $author) {
            echo '<tr><td>' . $author['author_name'] . '</td></tr>';
        }
    }
    ?>
</table>

<?php
include 'print_messages.php';
?>
