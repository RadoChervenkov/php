<?php
session_start();
if (isset($_SESSION['isLogged']) && isset($_SESSION['isAdmin'])) {
    include 'database.php';
    
    if ($_GET) {
        $id = (int)$_GET['id'];
    }
    $sql = 'DELETE FROM message WHERE message_id='.$id;
    $query = mysqli_query($connection, $sql);
    if (!$query) {
        echo 'Грешка в базата данни';
        echo mysqli_error($connection);
        exit();
    }
    header('Location: messages.php');
    exit();
}
else {
    header('Location: messages.php');
    exit();
}
?>
