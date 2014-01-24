<?php
$title = 'Разходи';
include 'includes/header.php';

// If $categoryToDisplay is -1, show expenses in all categories.
// If $dateToDisplay is -1, show expenses for all dates.
// Set both of them to -1, in order to display all expenses by default.
$categoryToDisplay = -1;
$dateToDisplay = -1;

if($_POST) {
    // The category selected for filtering (or all categories when $_POST['category_filter'] == -1).
    $categoryToDisplay = (int)$_POST['category_filter'];
    //The date selected for filtering (or all dates when $_POST['all_dates'] == 1).
    if(isset($_POST['all_dates']) && $_POST['all_dates'] == 1) {
        $dateToDisplay = -1;
    } else if(isDateValid()) {
        $dateToDisplay = isDateValid();
    }
}

$tableHeader =
'<h1>Разходи</h1>
<table>
    <tr>
        <th>Дата</th>
        <th>Име</th>
        <th>Сума</th>
        <th>Вид</th>
        <th>Редактирай</th>
        <th>Изтрий</th>
    </tr>';

if(file_exists('expenses.txt')) {
    $totalSum = 0;
    $tableContent = '';
    $expenses = file('expenses.txt');

    foreach ($expenses as $key => $expense) {
        //'<EOF>' is the separator between the fields of a expense (from 'End of Field').
        $fields = explode('<EOF>', $expense);

        // If the expense matches all filters, display it and update $totalSum.
        if(($fields[3] == $categoryToDisplay || $categoryToDisplay == -1)
            &&
           ($fields[0] == $dateToDisplay || $dateToDisplay == -1)) {
                // Concatenate (add) the new row to the current content of $tableContent.
                $tableContent .=
                '<tr>
                    <td>'.$fields[0].'</td>
                    <td>'.$fields[1].'</td>
                    <td>'.number_format($fields[2], 2).'</td>
                    <td>'.$categories[trim($fields[3])].'</td>
                    <td><a href="edit_expense.php?line='.$key.'"><img src="Resources/img/doc_edit_icon&16.png"></a></td>
                    <td><a href="delete_expense.php?line='.$key.'"><img src="Resources/img/delete_icon&16.png"></a></td>
                </tr>';

                $totalSum += $fields[2];
        }
    }

    // If $tableContent is still empty, there are no expenses matching all filters.
    if($tableContent == '') {
        printError('Няма разходи, отговарящи на зададените критерии.');
    } else {
        echo $tableHeader;
        echo $tableContent;
        echo
            '<tr>
                <td></td>
                <td class="bold"><img src="resources/img/calc_icon&16.png"> Общо: </td>
                <td class="bold">'.number_format($totalSum, 2).'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>';
    }
    ?>

    <!-- Display this only if the file expenses.txt exists; if it doesn't, there is no need of filter. -->
    <h3>Филтрирай разходите</h3>

    <form method ="POST">
        <fieldset>
            <legend class="bold"><img src="resources/img/zoom_icon&16.png"> Категория</legend>

            <select name="category_filter">
                <option value="-1">Всички</option>
                <?php
                foreach($categories as $key => $category) {
                    echo '<option value="'.$key.'">'.$category.'</category>';
                }
                ?>
            </select>
        </fieldset>

        <fieldset class="date">
            <legend class="bold"><img src="resources/img/calendar_1_icon&16.png"> Дата</legend>

            <input type="radio" name="all_dates" value="1" id="all_dates" checked> Всички дати<br>
            <input type="radio" name="all_dates" value="0" id="fixed_date"> Избрана дата<br>

            <div class="hidden" id="dmy">
                <?php printDates(); ?>
            </div>
        </fieldset>

        <input class="bold" type="submit" value="Филтрирай" />
    </form>

<?php
} else {
    // If the file expenses.txt doesn't exits, print error.
    printError('Все още няма добавени разходи.');
}

printLink('doc_plus', 'new_expense', 'Добави нов разход');
include 'includes/footer.php';
?>
