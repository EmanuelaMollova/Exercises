<?php

if(isset($data['errors']['db'])) {
    echo '<p>' . $data['errors']['db'] . '</p>';
}

if (isset($data['errors']['post'])) {
    foreach ($data['errors']['post'] as $error) {
        echo '<p>' . $error . '</p>';
    }
}

if (isset($data['success'])) {
    echo '<p>' . $data['success'] . '</p>';
}

?>
