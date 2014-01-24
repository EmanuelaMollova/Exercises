<?php
$title = 'Списък на всички съобщения';
include 'includes/header.php';

checkLoggedAdmin($connection, $_SESSION['username']);

if($_GET) {
    $id = normalize($connection, 'id', 'GET');
}

$q = mysqli_query($connection, 'SELECT * from users');

$rowsNumber = mysqli_num_rows($q);
if($rowsNumber > 0) {    
    echo '<h1>Потребители</h1>';

    echo 
    '<table>
        <tr>
            <th></th>
            <th>Потребителско име</th>
            <th>E-mail</th>
            <th>Роля</th>
            <th></th>';

    while($result = $q->fetch_assoc()) {
        echo '<tr>';

        if($result['gender'] == 0) {
            echo '<td><img src="resources/img/glyphicons_034_old_man.png"></td>';
        } else {
            echo '<td><img src="resources/img/glyphicons_035_woman.png"></td>';
        }
            
        echo '<td>'.$result['username'].'</td>';
        echo '<td>'.$result['email'].'</td>';
            
        if($result['role'] == 0) {
            echo '<td>Потребител</td>';
        } elseif ($result['role'] == 1) {
            echo '<td> Администратор</td>';
        } else {
            echo '<td><img src="resources/img/glyphicons_361_crown.png"> Главен Администратор</td>';
        }

        if($result['username'] == $_SESSION['username'] || $result['role'] == 2) {
            echo '<td></td>';
        } else {
            if($result['role'] == 0) {
                echo '<td><a href="change_role.php?role=1&userId='.$result['user_id'].'">Дайте администраторски права</a></td>';
            } else {
                echo '<td><a href="change_role.php?role=0&userId='.$result['user_id'].'">Отнемете администраторските права</a></td>';
            }
	}

            echo '</tr>';
    }

    echo '</table>';
}

printLink('glyphicons_330_blog', 'messages', 'Списък на всички съобщения');
printLink('glyphicons_124_message_plus', 'new_message', 'Добавете ново съобщение');
printLink('glyphicons_065_tag', 'categories', 'Категории');

printLogout();

include 'includes/footer.php';
?>
