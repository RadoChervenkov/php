<?php
$title = 'Регистрация';
include 'header.php';
include 'database.php';


if ($_POST) {
    $error = false;
    $username = trim($_POST['username']);
    if (mb_strlen($username) < 5) {
        $error = true;
        echo'<p>Потребителското име трябва да е най-малко 5 символа.</p>';
    }
    $username = mysqli_real_escape_string($connection, $username);

    $password = trim($_POST['password']);
    if (mb_strlen($password) < 5) {
        $error = true;
        echo'<p>Паролата трябва да е най-малко 5 символа.</p>';
    }
    $password = mysqli_real_escape_string($connection, $password);

    $sql = 'SELECT username FROM users WHERE username="' . $username . '"';
    $query = mysqli_query($connection, $sql);
    if (mysqli_num_rows($query) > 0) {
        $error = true;
        echo '<p>Потребителското име вече съществува!</p>';
    }

    if (!$error) {
        $sql = 'INSERT INTO users (username, password) VALUES ("' . $username . '","' . $password . '")';
        $query = mysqli_query($connection, $sql);
        if ($query) {
            header('Location: index.php');
            exit();
        } else {
            echo 'Грешка!';
        }
    }
}
?>

<form method="POST">
    <p>Моля въведете желаните потребителско име и парола за регистрация.</p>
    <label for="username">Потребителско име:</label>
    <input type="text" name="username" />
    <label for="passwprd">Парола:</label>
    <input type="password" name="password" />
    <input type="submit" value="Регистрация" />
</form>

<?php
include 'footer.php';
?>
