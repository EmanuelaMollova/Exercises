<?php
$title = 'Изтрийте файл';
include 'includes/header.php';

// If the file is still not deleted, show the content.
// Else show only the message for successful deletion.
$showContent = true;

if($_GET) {
    $file = normalize('file', false, '', 'GET');
}

if(isset($_POST['delete']) and $_POST['delete'] == 1) {
    // Delete the file itself.
    unlink(getFilePath($file));

    $error = false;
    // Delete also the line for this file in files.txt, if there is one.
    if(file_exists(getFileInfoPath('filesInfo'))) {
        $items = file(getFileInfoPath('filesInfo'));

        $count = 0;
        foreach($items as $item) {
            $itemData = explode('<EOF>', $item);

            if($file == $itemData[0]) {
                unset($items[$count]);

                if((file_put_contents(getFileInfoPath('filesInfo'), $items))|| filesize(getFileInfoPath('filesInfo')) == 0) {
                    $error = false;
                } else {
                    $error = true;
                }
            }
            $count++;
        }
    }

    if(!$error) {
        printMessage('Файлът е изтрит успешно.', 'success');
        $showContent = false;
    }
}

if($showContent) {
?>

    <h1>Изтрийте файл</h1>

    <h3>Сигурни ли сте, че искате да изтриете следния файл:</h3>

    <table>
        <tr>
            <th>Име</th>
            <th>Размер</th>
            <th>Бележка</th>
        </tr>

        <tr>
            <?php printNameSizeNote($file); ?>
        </tr>
    </table>

    <form method="POST">
        <input type="hidden" value="1" name="delete" />
        <input class="bold" type="submit" value="Изтриване" />
    </form>

<?php
}
printLink('glyphicons_319_sort', 'files', 'Списък на всички файлове');
printLink('glyphicons_201_upload', 'upload_file', 'Качете нов файл');
printLogout();

include 'includes/footer.php';
?>
