<?php

function printLink($img, $link, $message, $class = 'link')
{
    echo 
    '<div class="'.$class.'">
        <img src="resources/img/'.$img.'.png"> 
        <a class="bold" href="'.$link.'.php">'.$message.'</a>
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

function printSorting($field, $id = false, $page = 'books')
{       
    if($id) {
        $printId = 'id='.$id.'&';
    } else {
        $printId = '';
    }

    echo 
    '<td>
        <a href="'.$page.'.php?'.$printId.'field='.$field.'&method=ASC"><img src="resources/img/glyphicons_212_down_arrow.png" alt="sort ASC"></a>   
        <a href="'.$page.'.php?'.$printId.'field='.$field.'&method=DESC"><img src="resources/img/glyphicons_213_up_arrow.png"></a>
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

?>
