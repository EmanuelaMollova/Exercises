<?php
$title = 'Изтрий разход';
include 'includes/header.php';

// If the expense is still not deleted, show the content.
// If the expense is already deleted, do not show content.
$showContent = true;

if($_GET) {
    validateLine($line, $record, $fields, $error);
}

if($_POST) {
    // If $_POST['delete'] == 1, the user confirms that he/she wants to delete the expense.
    if($_POST['delete'] == 1) {
        // $record[$line] is the element of the $record array, which contains the expense we want to delete, so we unset it.
        unset($record[$line]);
        // If we unset the last one line in the file, file_put_contents will return false, but in fact
        // the deletion is successful, so it is necessary to check if the file is empty after deletion.
        if(file_put_contents('expenses.txt', $record) || filesize('expenses.txt') == 0 ) {
            printSuccess ('Разходът е изтрит успешно.');
            // Do not show the content after successful deletion.
            $showContent = false;
        }
    }
}

if($showContent && !$error) {
?>

    <h1>Изтрий разход</h1>

    <h3>Сигурни ли сте, че искате да изтриете следния разход:</h3>

    <table>
        <tr>
            <th>Дата</th>
            <th>Име</th>
            <th>Сума</th>
            <th>Вид</th>
        </tr>

        <tr>
            <td><?php echo $fields[0]; ?></td>
            <td><?php echo $fields[1]; ?></td>
            <td><?php echo number_format($fields[2], 2); ?></td>
            <td><?php echo $categories[trim($fields[3])]; ?></td>
        </tr>
    </table>

    <form method="POST">
        <input type="hidden" value="1" name="delete">
        <input class="bold" type="submit" value="Изтрий">
    </form>

<?php
}
printLink();
include 'includes/footer.php';
?>
