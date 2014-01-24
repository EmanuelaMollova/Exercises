<?php
$title = 'Изтрийте съобщение';
include 'includes/header.php';

checkLoggedAdmin($connection, $_SESSION['username']);

if($_GET) {
    $id = normalize($connection, 'id', 'GET');
}

if(isset($_POST['delete']) && $_POST['delete'] == 1) {
    $q = mysqli_query($connection, 'DELETE from messages WHERE message_id = '.$id);

    if($q) {
        header('Location: messages.php');
	exit();
    } else {
        printError();
    }
}

$q = mysqli_query($connection, 'SELECT date_when_added, title, body, user FROM messages WHERE message_id = '.$id);
$rowsNumber = mysqli_num_rows($q);
    
if($rowsNumber != 1) {
    printError();
} else {
    $result = $q->fetch_assoc();

?>

    <h1>Изтрийте съобщение</h1>
	
    <h3>Сигурни ли сте, че искате да изтриете следното съобщение:</h3>
	
    <table>
        <tr>
            <th>Дата и час на публикуване</th>
            <th>Заглавие</th>
            <th>Съобщение</th>
            <th>Добавено от</th>
	</tr>
		
        <tr>
            <?php
            echo '<td>'.date('d-m-Y H:i:s', $result['date_when_added']).'</td>';
            echo '<td>'.$result['title'].'</td>';
            echo '<td>'.$result['body'].'</td>';
            echo '<td>'.$result['user'].'</td>';
            ?>
        </tr>
    </table>

    <form method="POST">
	<input type="hidden" value="1" name="delete" />
	<input class="bold" type="submit" value="Изтриване" />
    </form>

<?php
}
printLink('glyphicons_330_blog', 'messages', 'Списък на всички съобщения');
printLink('glyphicons_124_message_plus', 'new_message', 'Добавете ново съобщение');
printLink('glyphicons_003_user', 'users', 'Потребители');
printLink('glyphicons_065_tag', 'categories', 'Категории');

printLogout();

include 'includes/footer.php';
?>
