<?php
$title = 'Списък на всички съобщения';
include 'includes/header.php';

checkLogged();

// Set default sotring.
$field = 'date_when_added';
$method = 'DESC';

if($_GET) {
    // If there is sorting criteria selected.
    $field = normalize($connection, 'field', 'GET');
    $method = normalize($connection, 'method', 'GET');

    if(($field != 'date_when_added' && $field != 'title' && $field != 'body' && $field != 'user' && $field != 'category') || ($method != 'ASC' && $method != 'DESC')) {
        printMessage('Невалидни критерии за сортиране');
    }
}

// Start building the query for selecting the needed messages.
$query = 'SELECT * from messages';

if($_POST) {
    // If there are filters selected.
    $categoryFilter = normalize($connection, 'category_filter');
    $userFilter = normalize($connection, 'user_filter');
    $allDates = normalize($connection, 'all_dates');

    if($allDates == 1) {
        // Validate selected dates and turn them into timestamp.
        $fromDate = normalize($connection, 'from_date');
        $fromTime = normalize($connection, 'from_time');

        $toDate = normalize($connection, 'to_date');
        $toTime = normalize($connection, 'to_time');

        $fromIsValid = validateDate($fromDate.' '.$fromTime);
        $toIsValid = validateDate($toDate.' '.$toTime);

        if($fromIsValid && $toIsValid) {
            $from = strtotime($fromDate.' '.$fromTime);
            $to = strtotime($toDate.' '.$toTime);
        } else {
            printMessage('Избраните дати са невалидни!');
        }
    }

    // If a category is selected for the filter.
    if($categoryFilter != '0') {
        $query = $query.' WHERE category = "'.$categoryFilter.'"';
    }

    // If an user is selected for the filter.
    if($userFilter != '0') {
        if($categoryFilter != '0') {
            $query = $query.' AND user = "'.$userFilter.'"';
        } else {
            $query = $query.' WHERE user = "'.$userFilter.'"';
        }
    }

    // If specific dates are selected for the filter.
    if($allDates != 0) {
        if($categoryFilter == '0' && $userFilter == '0') {
            $query = $query.' WHERE date_when_added >= '.$from.' AND date_when_added <= '.$to;
        } else {
            $query = $query.' AND date_when_added >= '.$from.' AND date_when_added <= '.$to;
        }
    }
}

// Finish building the query for selecting the needed messages.
$query = $query.' ORDER BY '.$field.' '.$method;

$username = $_SESSION['username'];

echo '<h1>Здравейте, '.$username.'!</h1>';

$q = mysqli_query($connection, $query);
$rowsNumber = mysqli_num_rows($q);

if($rowsNumber > 0) {
    echo '<h3>Съобщения:</h3>';

    echo
    '<table>
        <tr>
            <th>Дата и час на публикуване</th>
            <th>Заглавие</th>
            <th>Съобщение</th>
            <th>Добавено от</th>
            <th>Категория</th>';

            if(isAdmin($connection, $username)) {
                echo '<th>Изтрийте</th>';
            }

        echo '</tr>';

        while ($result = $q->fetch_assoc()) {
            echo '<tr>';

            echo '<td>'.date('d-m-Y H:i:s', $result['date_when_added']).'</td>';

            echo '<td>'.$result['title'].'</td>';
            echo '<td>'.$result['body'].'</td>';
            echo '<td>'.$result['user'].'</td>';

            $qCategory = mysqli_query($connection, 'SELECT name, picture from categories WHERE category_id = '.$result['category']);
            $rowsNumberCategory = mysqli_num_rows($qCategory);
            if($rowsNumberCategory > 0) {
                $resultCategory = $qCategory->fetch_assoc();

                echo '<td>';
                if($resultCategory['picture']) {
                    echo '<img class="icon" src="resources/img/'.$resultCategory['picture'].'"> ';
                }
		echo $resultCategory['name'].'</td>';
            } else {
                echo '<td></td>';
            }

            if(isAdmin($connection, $username)) {
                echo '<td> <a href="delete_message.php?id='.$result['message_id'].'"><img class="icon" src="resources/img/glyphicons_197_remove.png"></a></td>';
            }

            echo '</tr>';
        }

        echo '<tr>';

	printSorting('date_when_added');
	printSorting('title');
	printSorting('body');
	printSorting('user');
	printSorting('category');

        if(isAdmin($connection, $_SESSION['username'])) {
            echo '<td></td>';
	}

        echo '</tr></table>';

} else {
    printMessage('Няма съобщения, отговарящи на зададените критерии.');
}

?>

<form method ="POST">
    <fieldset>
        <legend class="bold"><img src="resources/img/glyphicons_027_search.png"> Филтрирайте съобщенията</legend>

        <label for="category_filter"><img src="resources/img/glyphicons_066_tags.png"> Категория</label><br>

	<select name="category_filter" id="category_filter">
            <option value="0">Всички</option>
            <?php
            $q = mysqli_query($connection, 'SELECT category_id, name FROM categories');

            $rowsNumber = mysqli_num_rows($q);
            if($rowsNumber > 0) {
                while($result = $q->fetch_assoc()) {
                    echo '<option value="'.$result['category_id'].'">'.$result['name'].'</option>';
                }
            }
            ?>
        </select><br>

        <label for="user_filter"><img src="resources/img/glyphicons_043_group.png"> Потребител</label><br>

	<select name="user_filter">
            <option value="0">Всички</option>
            <?php
            $q = mysqli_query($connection, 'SELECT username FROM users');

            $rowsNumber = mysqli_num_rows($q);
            if($rowsNumber > 0) {
            	while($result = $q->fetch_assoc()) {
                    echo '<option>'.$result['username'].'</option>';
                }
            }
            ?>
        </select><br>

        <label><img src="resources/img/glyphicons_045_calendar.png"> Дата</label><br>

        <input type="radio" name="all_dates" value="0" id="all_dates" checked> Всички дати<br>
        <input type="radio" name="all_dates" value="1" id="fixed_date"> Избрани дати<br>

        <div class="hidden" id="dmy">
            <label>От:</label>
            <input type="text" name="from_date" placeholder="Ден-Месец-Година">
            <input type="text" name="from_time" placeholder="Час:Минути"> <br>

            <label>До:</label>
            <input type="text" name="to_date" placeholder="Ден-Месец-Година">
            <input type="text" name="to_time" placeholder="Час:Минути"> <br>
        </div>

    	<input class="bold" type="submit" value="Филтрирай" />
    </fieldset>
</form>

<?php
printLink('glyphicons_124_message_plus', 'new_message', 'Добавете ново съобщение');

// If the user is admin, show links for going to the categories and users pages.
if(isAdmin($connection, $username)) {
    printLink('glyphicons_003_user', 'users', 'Потребители');
    printLink('glyphicons_065_tag', 'categories', 'Категории');
}

printLogout();

include 'includes/footer.php';
?>
