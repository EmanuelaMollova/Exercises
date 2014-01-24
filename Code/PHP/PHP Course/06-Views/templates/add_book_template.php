<a href="index.php">Списък</a>

<form method="post" action="add_book.php">
    Име:
    <input type="text" name="book_name" />

    <div>
        Автори:
        <select name="authors[]" multiple style="width: 200px">
            <?php
            foreach ($data['authors'] as $id => $author) {
                echo '<option value="' . $id . '">' . $author . '</option>';
            }
            ?>
        </select>
    </div>

    <input type="submit" value="Добави" />
</form>

<?php
include 'print_messages.php';
?>
