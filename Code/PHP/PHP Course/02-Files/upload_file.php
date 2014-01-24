<?php
$title = 'Качете нов файл';
include 'includes/header.php';

if(isset($_POST['note'])) {
    $note = normalize('note');
	
	$error = false;
	// If there is a note entered, write to file files.txt the name of the uploaded file and the note.
    if(mb_strlen($note) > 0) {
        $record = $_FILES['file']['name'].'<EOF>'.$note."\n";
		if(!is_dir(getFileInfoDir())) {
			mkdir(getFileInfoDir());
		}
        if(!file_put_contents(getFileInfoPath('filesInfo'), $record, FILE_APPEND)) {
            $error = true;
        }
    }
}

if($_FILES) {
	// Each user has a directory, called by his username in the folder uploaded_files.
	// If the directory for this user is still not created, create it.
    if(!is_dir(getDirectory())) { 
        mkdir(getDirectory());
    }

    $filePath = getFilePath($_FILES['file']['name']);
    if(file_exists($filePath)) {
        printMessage('Вече има добавен файл със същото име!');
    } else {
		if(move_uploaded_file($_FILES['file']['tmp_name'], $filePath) && !$error) {
		   printMessage('Файлът беше добавен успешно.', 'success');
		} else {
			printMessage('Грешка при качването на файла.');
		}
	}
}
?>

<h1>Качете нов файл</h1>

<form method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend class="bold"><img src="resources/img/glyphicons_062_paperclip.png"> Изберете файл</legend>
        <input type="file" name="file" id="file" />
    </fieldset>

    <fieldset>
        <legend class="bold"><img src="resources/img/glyphicons_039_notes.png"> Бележка</legend>
        <input type="textarea" name="note" id="note" />
    </fieldset>

    <input type="submit" value="Качване" />
</form>

<?php
printLink('glyphicons_319_sort', 'files', 'Списък на всички файлове');
printLogout();

include 'includes/footer.php';
?>