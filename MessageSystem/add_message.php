<?php
session_start();
$title = 'Добави съобщение';
include 'header.php';
include 'database.php';
include 'variables.php';

if (!isset($_SESSION['isLogged'])) {
    header('Location: index.php');
}

if ($_POST) {
    $error = false;

    $messageTitle = mysqli_real_escape_string($connection, trim($_POST['title']));
    $messageContent = mysqli_real_escape_string($connection, trim($_POST['content']));

    $messageTitle = htmlentities($messageTitle, ENT_QUOTES);
    $messageContent = htmlentities($messageContent, ENT_QUOTES);

    $user = $_SESSION['username'];
    
    $group = (int)$_POST['group'];

    if (mb_strlen($messageTitle) < 1 || mb_strlen($messageTitle) > 50) {
        echo '<p>Заглавието трябва да бъде между 1 и 50 символа.</p>';
        $error = true;
    } 
    if (mb_strlen($messageContent) < 1 || mb_strlen($messageContent) > 250) {
        echo '<p>Съдържанието трябва да бъде между 1 и 250 символа.</p>';
        $error = true;
    }
    if (!array_key_exists($group, $groups)) {
        echo '<p>Невалидна група.</p>';
        $error = true;
    }
    
    if (!$error) {
        $sql = 'INSERT INTO message (groups, title, content, author, date) 
                VALUES ('.$group.', "' . $messageTitle . '", "' . $messageContent . '", "' . $user . '", NOW())';

        $query = mysqli_query($connection, $sql);
        if (!$query) {
            echo 'Грешка в базата данни!';
            echo mysqli_error($connection);
            exit();
        } else {
            header('Location: messages.php');
            exit();
        }
    }
}
?>

<a href="logout.php">Изход</a><br />
<form method="POST">
    <label for="title">Въведете заглавие:</label>
    <input type="text" name="title" /><br />
    <label for="content">Въведете съобщението:</label>
    <textarea name="content"></textarea><br />
    <label for="group">Група:</label>
    <select name="group">
        <?php
        foreach ($groups as $key=>$value) {
            echo '<option value="'.$key.'">'.$value.'</option>';
        }
        ?>
    </select>
    <input type="submit" value="Изпратете съобщението" />
</form>

<?php
include 'footer.php';
?>