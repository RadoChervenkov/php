<?php
session_start();
$title = 'Вход';
include 'header.php';
include 'database.php';

if (isset($_SESSION['isLogged'])) {
    header('Location: messages.php');
    exit();
}

if ($_POST) {
    $username = trim($_POST['username']);
    $username = mysqli_real_escape_string($connection, $username);

    $password = trim($_POST['password']);
    $password = mysqli_real_escape_string($connection, $password);

    $sql = 'SELECT username FROM users WHERE username="' . $username . '" AND password="' . $password . '"';
    $query = mysqli_query($connection, $sql);

    $num_rows = mysqli_num_rows($query);
    if ($num_rows > 0) {
        $_SESSION['isLogged'] = true;
        $_SESSION['username'] = $_POST['username'];
        
        $result = mysqli_fetch_assoc($query);
        if ($result['username'] == 'admin') {
            $_SESSION['isAdmin'] = true;
        }
        
        header('Location: messages.php');
        exit();
    } else {
        echo 'Грешен потребител или парола! Моля опитайте отново.';
    }
}
?>

<form method="POST">
    <label for="username">Потребителско име:</label>
    <input type="text" name="username" />
    <label for="passwprd">Парола:</label>
    <input type="password" name="password" />
    <input type="submit" value="Вход" />
</form>
<br />
<br />
<a href="register.php">Регистрирай се</a>
<br />
<br />
<h1>ВАЖНО</h1>
<p>Използвани потребител и парола за базата данни: root , без парола. Може да се променят от файла database.php</p>
<br/>
<p>Администраторски акаунт за триене: admin, парола qwerty</p>
    

<?php
include 'footer.php';
?>