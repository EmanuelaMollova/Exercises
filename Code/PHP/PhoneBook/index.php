<?php
error_reporting(0);

include 'Contact.php';
include 'Pagination.php';
session_start();

$db = new DataBaseActions();
$db->connect();

if($_GET['mode'] == 'normal') {
    $flag             = 0;
    $_SESSION['mode'] = 'normal';
}

if($_GET['mode'] == 'delete') {
    $id = addslashes($_GET['id']);
    $id = htmlspecialchars(stripslashes($id));
    $id = mysql_escape_string($id);

    $db->delete($id);
    header('Location: index.php');
}

if ($_GET['mode'] == 'edit' && $_GET['id'] > 0) {
    $id   = (int) $_GET['id'];
    $rs   = DataBaseActions::run_q('SELECT * FROM contacts WHERE contact_id = ' . $id);
    $info = mysql_fetch_assoc($rs);
}

if($_GET['mode'] == 'ASC') {
    $flag              = 1;
    $field             = $_GET['field'];
    $mode              = 'ASC';
    $_SESSION['mode']  = 'ASC';
    $_SESSION['field'] = $field;
}

if($_GET['mode'] == 'DESC') {
    $flag              = 1;
    $field             = $_GET['field'];
    $mode              = 'DESC';
    $_SESSION['mode']  = 'DESC';
    $_SESSION['field'] = $field;
}

if($_POST['name']==1) {
    $s_name           = $_POST['search_name'];
    $flag             = 2;
    $_SESSION['mode'] = 'sname';
}

if($_POST['phone']==1) {
    $s_phone          = $_POST['search_phone'];
    $flag             = 3;
    $_SESSION['mode'] = 'sphone';
}

if($_POST['address'] == 1) {
    $s_address        = $_POST['search_address'];
    $flag             = 4;
    $_SESSION['mode'] = 'saddress';
}

if($_POST['notes'] == 1) {
    $s_notes          = $_POST['search_notes'];
    $flag             = 5;
    $_SESSION['mode'] = 'snotes';
}

if($_POST['form_submit'] == 1) {
    $flag             = 0;
    $name             = $_POST['name'];
    $phone            = $_POST['phone'];
    $address          = $_POST['address'];
    $notes            = $_POST['notes'];
    $_SESSION['mode'] = 'normal';

    try {
        $a=new Contact($name, $phone, $address, $notes);

        $id = (int) $_POST['edit_value'];
        $temp = DataBaseActions::run_q('SELECT * FROM contacts WHERE phone='.$a->getPhone().' AND contact_id!='.$id);

        if(mysql_num_rows($temp) == 0) {
            if($id > 0) {
                $db->update($a, $id);
                echo 'Successful update.';
            } else {
                $db->insert($a);
                echo 'The contact was successfully added to the Phone Book!';
            }
       } else {
           echo 'This phone number is already in the Phone Book.';
       }
    } catch(Exception $exc) {
        echo $exc->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>Phone Book</title>
    </head>
    <body>
        <center>
        <h3>Phone Book</h3><br />

        <form method="post" action="index.php">
            <table border="0">
            <tr><td>Name:</td><td> <input type="text" name="name" value="<?php echo $info['name']; ?>"/></td></tr>
            <tr><td>Phone number:</td><td> <input type="text" name="phone" value="<?php echo $info['phone']; ?>"/></td></tr>
            <tr><td>Address:</td><td> <input type="text" name="address" value="<?php echo $info['address']; ?>"/></td></tr>
            <tr><td>Notes: </td><td><input type="textarea" name="notes" value="<?php echo $info['notes']; ?>"/></td></tr>
            </table>
            <input type="hidden" name="form_submit" value="1" /><br />
            <input type="submit" value="Submit" /><br /><br />

            <?php
            if($_GET['mode'] == 'edit') {
                echo '<input type="hidden" name="edit_value" value="'.$_GET['id'].'" /><br />';
            }
            ?>

       </form>

        <table border="3" style="border-collapse:collapse; border-color: gray; padding: 2px;">
            <tr class="header">
                <td>Name</td>
                <td>Phone number</td>
                <td>Address</td>
                <td>Notes</td>
                <td></td>
                <td></td>
            </tr>

            <?php
            $p=new Pagination();

            if((int)$_GET['page'] > 0) {
                $p->setPage((int) $_GET['page'] - 1);
            }

            if($_SESSION['mode'] == 'normal') {
                $flag = 0;
            }
            if($_SESSION['mode'] == 'ASC' || $_SESSION['mode'] == 'DESC') {
                $flag  = 1;
                $field = $_SESSION['field'];
                $mode  = $_SESSION['mode'];
            }
            if($_SESSION['mode'] == 'sname') {
                $flag = 2;
            }

            if($_SESSION['mode'] == 'sphone') {
                $flag = 3;
            }

            if($_SESSION['mode'] == 'saddress') {
                $flag = 4;
            }

            if($_SESSION['mode'] == 'snotes') {
                $flag = 5;
            }

            switch($flag) {
                case 0:
                    $sql = 'SELECT * FROM contacts';
                    $p->setAll($sql);
                    Contact::printTable($p->pageQuery($sql));
                    break;
                case 1:
                    echo'<a href="index.php?mode=normal"> Go back to unsorted  table<br></a>';
                    $p->setAll($db->sortTable($field, $mode));
                    Contact::printTable($p->pageQuery($db->sortTable($field, $mode)));
                    break;
                case 2:
                    echo'<a href="index.php?mode=normal">Go back to all contacts<br></a>';
                    $p->setAll($db->search('name', $s_name));
                    Contact::printTable($p->pageQuery($db->search('name', $s_name)));
                    break;
                case 3:
                    echo'<a href="index.php?mode=normal">Go back to all contacts<br></a>';
                    $p->setAll($db->search('phone', $s_phone));
                    Contact::printTable($p->pageQuery($db->search('phone', $s_phone)));
                    break;
                case 4:
                    echo'<a href="index.php?mode=normal">Go back to all contacts<br></a>';
                    $p->setAll($db->search('address', $s_address));
                    Contact::printTable($p->pageQuery($db->search('address', $s_address)));
                    break;
                case 5:
                    echo'<a href="index.php?mode=normal">Go back to all contacts<br></a>';
                    $p->setAll($db->search('notes', $s_notes));
                    Contact::printTable($p->pageQuery($db->search('notes', $s_notes)));
                    break;
            }
            ?>

            <tr class="content">
                <td>
                    <form method="post" action="index.php">
                        <input type="text" name="search_name"><input type="submit" value=">">
                        <input type="hidden" name="name" value="1">
                    </form>
                </td>
                <td>
                    <form method="post" action="index.php">
                        <input type="text" name="search_phone"><input type="submit" value=">">
                        <input type="hidden" name="phone" value="1">
                    </form>
                </td>
                <td>
                    <form method="post" action="index.php">
                        <input type="text" name="search_address"><input type="submit" value=">">
                        <input type="hidden" name="address" value="1">
                    </form>
                </td>
                <td>
                    <form method="post" action="index.php">
                        <input type="text" name="search_notes"><input type="submit" value=">">
                        <input type="hidden" name="notes" value="1">
                    </form>
                </td>
                <td></td>
                <td></td>
            </tr>

            <tr class="content">
                <td><a href="index.php?mode=ASC&field=name">Sort ASC</a></td>
                <td><a href="index.php?mode=ASC&field=phone">Sort ASC</a></td>
                <td><a href="index.php?mode=ASC&field=address">Sort ASC</a></td>
                <td><a href="index.php?mode=ASC&field=notes">Sort ASC</a></td>
                <td></td>
                <td></td>
            </tr>

            <tr class="content">
                <td><a href="index.php?mode=DESC&field=name">Sort DESC</a></td>
                <td><a href="index.php?mode=DESC&field=phone">Sort DESC</a></td>
                <td><a href="index.php?mode=DESC&field=address">Sort DESC</a></td>
                <td><a href="index.php?mode=DESC&field=notes">Sort DESC</a></td>
                <td></td>
                <td></td>
            </tr>

        </table>
        <br>

        <?php
        $p->printPages();
        ?>

        </div>
        </center>

    </body>
</html>
