<?php
$title = 'Редактирай разход';
include 'includes/header.php';

// If the expense is still not edited, show the form.
// After edition, do not show it anymore.
$showContent = true;

if($_GET){
    validateLine($line, $record, $fields, $errorLine);

    if (!$errorLine) {
        // Write the day, month and year of the edited expense as elements in the array $dateOfExpense,
        // in order to populate the form for edition with them later.
        $dateOfExpense = explode('-', $fields[0]);
    }
}

if($_POST) {
    validateExpense($recordToEdit, $error, $categories);

    if(!$error) {
        // Update the line in which is written the expense we edited.
        $record[$line] = $recordToEdit;

        if(file_put_contents('expenses.txt', $record)) {
            printSuccess('Разходът е редактиран успешно.');
            // Do not show the form after successful edition.
            $showContent = false;
        }
    }
}

if($showContent) {
    printForm('Редактирай', $categories, $dateOfExpense, $fields);
}

printLink();
include 'includes/footer.php';
?>
