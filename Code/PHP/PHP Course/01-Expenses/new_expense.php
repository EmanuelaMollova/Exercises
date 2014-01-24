<?php
mb_internal_encoding('UTF-8');

$title = 'Добави разход';
include 'includes/header.php';

if($_POST) {
    validateExpense($record, $error, $categories);

    if(!$error){
        if(file_put_contents('expenses.txt', $record, FILE_APPEND)) {
            printSuccess('Разходът е добавен успешно.');
        }
    }
}

printForm('Добави', $categories);
printLink();
include 'includes/footer.php';
?>
