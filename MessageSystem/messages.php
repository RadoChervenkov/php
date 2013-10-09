<?php
session_start();
include 'header.php';
include 'database.php';

if (!isset($_SESSION['isLogged'])) {
    header('Location: index.php');
}
?>
<a href="add_message.php">Добави ново съобщение</a>
<form method="GET">
    
</form>

<?php
$sql = 'SELECT title, content, author, date FROM message ORDER BY date DESC';
$query = mysqli_query($connection, $sql);
if (!$query) {
    echo 'Грешка в базата данни!';
    echo mysqli_error($connection);
    exit();
}
$result = mysqli_fetch_assoc($query);
print_r($result);

echo '<table border="1">
        <tr>
            <td>Дата</td>
            <td>Потребител</td>
            <td>Заглавие</td>
            <td>Съдържание</td>
        </tr>';
while($result= mysqli_fetch_assoc($query)){
    echo '<tr>
            <td>'.$result['date'].'</td>
            <td>'.$result['author'].'</td>
            <td>'.$result['title'].'</td>
            <td>'.$result['content'].'</td>
          </tr>';                
}
echo '</table>';
include 'footer.php';
?>