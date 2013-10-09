<?php
session_start();
include 'header.php';
include 'database.php';

if (!isset($_SESSION['isLogged'])) {
    header('Location: index.php');
}

if ($_POST) {
    $messageTitle = mysqli_real_escape_string($connection, trim($_POST['title']));
    $messageContent = mysqli_real_escape_string($connection, trim($_POST['content']));

    $messageTitle = htmlentities($messageTitle, ENT_QUOTES);
    $messageContent = htmlentities($messageContent, ENT_QUOTES);
    
    $user = $_SESSION['username'];

    if (mb_strlen($messageTitle) < 1 || mb_strlen($messageContent) < 1) {
        echo '<p>Заглавието и съдържанието трябва да съдържат минимум 1 символ.</p>';
    }

    $sql = 'INSERT INTO message (title, content, author, date) 
            VALUES ("'.$messageTitle.'", "'.$messageContent.'", "'.$user.'", NOW())';
    
    $query = mysqli_query($connection, $sql);
    if (!$query) {
        echo 'Грешка в базата данни!';
        echo mysqli_error($connection);
        exit();
    }
    else {
        header('Location: messages.php');
        exit();
    }
}
?>

<form method="POST">
    <label for="title">Въведете заглавие:</label>
    <input type="text" name="title" /><br />
    <label for="content">Въведете съобщението:</label>
    <textarea name="content"></textarea><br />
    <input type="submit" value="Изпратете съобщението" />
</form>

<?php
include 'footer.php';
?>