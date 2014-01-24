<?php
function printLink($img = 'doc_lines', $link = 'index', $message = 'Списък на разходите')
{
    echo '<img src="resources/img/'.$img.'_icon&16.png"> <a class="bold" href="'.$link.'.php">'.$message.'</a>';
}

function printError($message)
{
    echo '<div class="note error">'.$message.'</div>';
}

function printSuccess($message)
{
    echo '<div class="note success">'.$message.'</div>';
}

// Prints the html for the day, month and year fields of the form.
// $dateOfExpense is null by default, and if this value is not overriden, the value of the fields  is the current date.
// It is used in this way in index.php and new_expense.php.
// If $dateOfExpense has another value, this value should be an array with 3 elements - day, month and year.
// It is used in this way in edit_expense.php to fill in the form fields with the date of the edited expense.
// Used in index.php and printForm().
function printDates($dateOfExpense = null)
{
    echo
    '<label for="day">Ден:</label>
    <input type="text" name="day" id="day" value="';

    if(!$dateOfExpense) {
        echo date('d');
    } else {
        echo $dateOfExpense[0];
    }

    echo '" />

    <label for="month">Месец:</label>
    <input type="text" name="month" id="month" value="';

    if(!$dateOfExpense) {
        echo date('m');
    } else {
        echo $dateOfExpense[1];
    }

    echo '" />

    <label for="year">Година:</label>
    <input type="text" name="year" id="year" value="';

    if(!$dateOfExpense) {
        echo date('Y');
    } else {
        echo $dateOfExpense[2];
    }

    echo '" />';
}

// Prints the html for the form for adding new expenses and editing expenses.
// It takes 4 parameters:
// * $submit holds the text for the page heading and the value for the submit button.
// * $categories is neeed in the function, but the function can't see it, bacause of the scope,
//   so $categories should be given as parameter in order to be visible inside the function body.
// * $dateOfExpense is needed only for the form for editing expense for the function printDates().
// * $fields is needed only for the form for editing expense in order to fill in the fields of the form
//   with information for the edited expense.
// Used in new_expense.php and edit_epxense.php.

function printForm($submit, $categories, $dateOfExpense = null, $fields = null)
{
    echo
    '<h1>'.$submit.' разход</h1>
    <form method="POST">

        <fieldset class="date">
            <legend class="bold"><img src="resources/img/calendar_1_icon&16.png"> Дата</legend>';
            printDates($dateOfExpense);
        echo
        '</fieldset>

        <fieldset>
            <legend class="bold"><img src="resources/img/doc_empty_icon&16.png"> Информация</legend>

            <label for="expense">Име:</label>
            <input type="text" name="expense" id="expense"';

            if($fields) {
                echo 'value="'.$fields[1].'"';
            }

            echo '/><br>

            <label for="sum">Сума:</label>
            <input type="text" name="sum" id="sum"';

            if($fields) {
                echo 'value="'.number_format($fields[2], 2).'"';
            }

            echo '/><br>

            <label for="category">Вид:</label>
            <select name="category" id="category">';
                foreach($categories as $key => $category){
                    echo '<option value="'.$key.'"';
                    if($key == (int)trim($fields[3])) {
                        echo 'selected';
                    }
                    echo '>'.$category.'</category>';
                }
            echo
            '</select>
        </fieldset>

        <input class="bold" type="submit" value="'.$submit.'" />
    </form>';
}

// Validates the selected date and displays errors, if any.
// If the selected date is not valid, returns false.
// If the selected date is valid, returns it, formated in an appropriate way.
// Used in index.php, new_expense.php and edit_expense.php.
function isDateValid()
{
    $day = (int)trim($_POST['day']);
    $month = (int)trim($_POST['month']);
    $year = (int)trim($_POST['year']);

    if(mb_strlen($day) == 1){
       $day = '0'.$day;
    }

    if(mb_strlen($month) == 1){
       $month = '0'.$month;
    }

    if(!checkdate ($month , $day , $year)) {
        printError('Датата не е валидна!');
        return false;
    } else {
        return $day.'-'.$month.'-'.$year;
    }
}

// Validates an expense, displays errors, if any and populates the given parameters $record and $error.
// Expects 2 parameters, passed by reference - $record and $error, which are changed after execution of the function.
// Expects 1 parameter, passed by value - $categories (because the function needs it, but it can't see it, because of the scope).
// Doesn't return anything.
// Used in new_expense.php and edit_expense.php.
function validateExpense(&$record, &$error, $categories)
{
    //Normalization
    $expense = trim($_POST['expense']);
    $expense = str_replace('<EOF>', '', $expense);

    $sum = trim($_POST['sum']);
    $sum = (float)($sum);
    $sum = str_replace('<EOF>', '', $sum);

    $category = (int)$_POST['category'];

    //Validation
    $error = false;

    if(!isDateValid()) {
        $error = true;
    } else {
        $date = isDateValid();
    }

    if(mb_strlen($expense) < 4) {
        printError('Името на разхода е твърде късо!');
        $error = true;
    }

    if($sum <= 0) {
        printError('Невалидна сума!');
        $error = true;
    }

    if(!array_key_exists($category, $categories)){
        printError('Не съществъва такъв вид разходи.');
        $error = true;
    }

    if(!$error) {
        //'<EOF>' is the separator between the fields of a expense (from 'End of Field').
        $record = $date.'<EOF>'.$expense.'<EOF>'.$sum.'<EOF>'.$category."\n";
    }
}

// Validates the line, passed by GET in the url, displays error, if any and populates the given parameters $line, $record and $fields.
// Expects 3 parameters, passed by reference - $line, $record and $fields, which are changed after execution of the function.
// Doesn't return anything.
// Used in edit_expense.php and delete_expense.php.
function validateLine(&$line, &$record, &$fields, &$error)
{
    $error = false;
    if((!preg_match ('/[^0-9]/i', $_GET['line']))) {
        // $line is the line in the file expenses.txt, on which is written the expense we want to edit/delete.
        $line = (int)trim(($_GET['line']));

        if(file_exists('expenses.txt')){
            // $record is an array, containing all expenses, each line is one expense and one element in the $record array.
            $record =  file('expenses.txt');
            if(isset($record[$line])) {
                // $fileds is an array, containing all fields of the expense we want to edit/delete.
                $fields =  explode('<EOF>', $record[$line]);
            } else {
                // If there is no such line (no such expense) in the file.
                printError('Няма такъв разход.');
                $error = true;
            }
        }
    } else {
        // If the given line is not an integer.
        printError('Няма такъв разход.');
        $error = true;
    }
}
?>
