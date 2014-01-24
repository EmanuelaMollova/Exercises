<?php
$title = 'Списък на всички файлове';
include 'includes/header.php';

echo '<h1>Здравейте, '.$_SESSION['username'].'!</h1>';

// If there is a folder for this user and it contains files, show them.
if(is_dir(getDirectory()) && count($files = scandir(getDirectory())) > 2) { 
    echo '<h3>Вашите файлове:<h3>';

    echo 
    '<table>
        <tr>
            <th>Име</th>
            <th>Размер</th>
            <th>Бележка</th>
            <th>Свалете</th>
            <th>Изтрийте</th>
        </tr>';

    foreach($files as $file) {
        if($file == '.' || $file == '..') {
            continue;
        }
        
        echo '<tr>';
        printNameSizeNote($file);

        echo '<td>
                <a href="download_file.php?file='.$file.'">
                    <img class="icon" src="resources/img/glyphicons_181_download_alt.png">
                </a>
              </td>';

        echo '<td>
                <a href="delete_file.php?file='.$file.'">
                    <img class="icon" src="resources/img/glyphicons_197_remove.png">
                </a>
              </td></tr>';
    }
    
    echo '</table>';
} else {
    printMessage('Все още нямате добавени файлове');
}

printLink('glyphicons_201_upload', 'upload_file', 'Качете нов файл');
printLogout();

include 'includes/footer.php';
?>