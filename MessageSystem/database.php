<?php
$connection = mysqli_connect('localhost', 'root', '', 'messages');
if (!$connection) {
    echo 'Няма връзка с базата данни!';
    echo mysqli_error($connection);
    exit();
}
mysqli_set_charset($connection, 'utf8');
?>
