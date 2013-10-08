<?php
$connection = mysqli_connect('localhost', 'root', '', 'messages');
if (!$connection) {
    echo mysqli_error($connection);
    exit();
}
mysqli_set_charset($connection, 'utf8');
?>
