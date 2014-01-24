<?php

function printLink($img, $link, $message)
{
    echo 
    '<div class="link">
        <img src="resources/img/'.$img.'.png"> 
        <a class="bold" href="'.$link.'.php">'.$message.'</a>
    </div>';
}

function printLogout()
{
    echo 
    '<div class="logout">
        <a class="bold" href="logout.php">Изход</a> <img class="" src="resources/img/glyphicons_388_exit.png">
    </div>';
}

function printMessage($message, $kind = 'error')
{
    echo '<div class="note '.$kind.'">'.$message.'</div>';
}

function printError()
{	
    printMessage('За съжаление възникна грешка :(');
}

function printSorting($field)
{       
    echo 
    '<td>
        <a href="messages.php?field='.$field.'&method=ASC"><img src="resources/img/glyphicons_213_up_arrow.png" alt="sort ASC"></a>   
        <a href="messages.php?field='.$field.'&method=DESC"><img src="resources/img/glyphicons_212_down_arrow.png"></a>
     </td>';
}

function normalize($connection, $item, $method = 'POST')
{
    if($method == 'POST') {
        $var = $_POST[$item];
    } else {
        $var = $_GET[$item];
    }

    $var = trim(htmlspecialchars($var));
    return $var = mysqli_real_escape_string($connection, $var);
}

function isAdmin($connection, $username)
{
    $q = mysqli_query($connection, 'SELECT role from users WHERE username = "'.$username.'"');
    $rowsNumber = mysqli_num_rows($q);
    
    if($rowsNumber != 1) {
        return false;
    } else {
        $result = $q->fetch_assoc();
        
        if($result['role'] == 1 || $result['role'] == 2) {
            return true;
        } else {
            return false;
        }
    }
}

function checkLogged()
{
    if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] != 1) {
        header('Location: index.php'); 
        exit();
    }
}

function checkLoggedAdmin($connection, $username)
{
    if(!isAdmin($connection, $username)) {
        header('Location: messages.php');
        exit();
    }
}

function validateDate($date, $format = 'd-m-Y H:i')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

?>
