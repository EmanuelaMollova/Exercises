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

function normalize($item, $str_replace = true, $str = '<EOF>', $method = 'POST')
{
    if($method == 'POST') {
        $var = $_POST[$item];
    } else {
        $var = $_GET[$item];
    }

    $var = trim(htmlspecialchars($var));

    if($str_replace) {
        $var = str_replace($str, '', $var);
    }

    return $var;
}

/*
 * Converts bytes to KB and MB if there is need.
 */
function formatBytes($size)
{
    if($size < 1024) {
        return $size.' B';
    }

    if($size < 1024*1024) {
        return round($size/1024, 2).' KB';
    }

    else {
        return round($size/(1024*1024), 2).' MB';
    }
}

/*
 * @return string returns the directory for the uploaded files for the current user.
 */
function getDirectory()
{
    return 'uploaded_files/'.$_SESSION['username'];
}

/*
 * @return string returns the path to uploaded file.
 */
function getFilePath($file)
{
    $directory = getDirectory();
    return $directory.'/'.$file;  
}

/*
 * @return string returns the directory for the file 'filesInfo.txt' for the current user.
 */
function getFileInfoDir()
{
	return 'database_files/'.$_SESSION['username'];
}

/*
 * @return string returns the path for the file 'filesInfo.txt' for the current user.
 */ 
function getFileInfoPath($file)
{
	return getFileInfoDir().'/'.$file.'.txt';
}

/*
 * @return bool|array 
 * if the given file exists, returns an array with elements - exploded lines
 * else returns false
 */ 
function getExplodedFileLines($file)
{
    $filePath = 'database_files/'.$file.'.txt';

    if(file_exists($filePath)) {
        $records = file($filePath);
        
        $items = array();
        foreach($records as $record) {
            array_push($items, explode('<EOF>', $record));
        }

        return $items;
    } else {
        return false;
    }
}

function printNameSizeNote($file)
{
    echo '<td><a href="'.getFilePath($file).'">'.$file.'</a></td>';

    echo '<td>'.formatBytes(filesize(getFilePath($file))).'</td>';
            
    $note = '-';
    if($items = getExplodedFileLines($_SESSION['username'].'/filesInfo')) {
        foreach($items as $itemData) {
            if($file == $itemData[0]) {
                $note = trim($itemData[1]);
            }
        }
    }
    echo '<td>'.$note.'</td>';
}

?>