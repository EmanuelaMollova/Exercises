<?php
$title = 'Книги';
include 'includes/header.php';

if(isset($_GET['id'])) {
    $id = normalize($connection, 'id', 'GET');
}

$sql = 'SELECT * FROM comments LEFT JOIN books ON comments.book_id = books.book_id 
        WHERE comments.user_id = '.$id; 

$q = mysqli_query($connection, $sql);
$rowsNumberAll = mysqli_num_rows($q);

$qUsername = mysqli_query($connection, 'SELECT username FROM users WHERE user_id ='.$id);
$resultUsername = $qUsername->fetch_assoc();

echo '<h1>Коментари на '.$resultUsername['username'].'</h1>';

echo '<table>
          <tr>
              <td>Дата и час</td>
              <td>Коментар</td>
              <td>Книга</td>
          </tr>';

while($result = $q->fetch_assoc()) {
    echo '<tr>';
    echo '<td>'.date('d-m-Y H:i', $result['datetime']).'</td>';
    echo '<td>'.$result['comment'].'</td>';
    echo '<td><a href="book_with_comments.php?id='.$result['book_id'].'">'.$result['book_title'].'</a></td>';
    echo '</tr>';
}

echo '</table>';

include 'includes/footer.php';
?>
