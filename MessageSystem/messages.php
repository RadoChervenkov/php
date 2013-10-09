<?php
session_start();
$title = 'Съобщения';
include 'header.php';
include 'database.php';
include 'variables.php';

if (!isset($_SESSION['isLogged'])) {
    header('Location: index.php');
}
?>

<a href="logout.php">Изход</a><br />
<a href="add_message.php">Добави ново съобщение</a>
<form method="GET">
    Сортирай по дата:
    <select name="sort">
        <option value="DESC">Най-нови</option>
        <option value="ASC">Най-стари</option>
    </select><br />
    Филтрирай по група:
    <select name="group">
        <option value="0">Всички</option>
        <?php
        foreach ($groups as $key=>$value){
            echo '<option value="'.$key.'">'.$value.'</option>';
        }
        ?>
    </select>
    <input type="submit" value="Филтър" />
</form>

<?php
$sort = 'DESC';
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'DESC' || $_GET['sort'] == 'ASC') {
        $sort = $_GET['sort'];
    }
}

$group = 0;
if (isset($_GET['group'])) {
    $group = (int)$_GET['group'];
}

if ($group !== 0 && array_key_exists($group, $groups)) {
    $sql = 'SELECT message_id, groups, title, content, author, date FROM message WHERE groups='.$group.' ORDER BY date '.$sort.'';
}
else {
    $sql = 'SELECT message_id, groups, title, content, author, date FROM message ORDER BY date '.$sort.'';
}
$query = mysqli_query($connection, $sql);
if (!$query) {
    echo 'Грешка в базата данни!';
    echo mysqli_error($connection);
    exit();
}
if (mysqli_num_rows($query) > 0) {
    echo '<table border="1">
        <tr>
            <td>Дата</td>
            <td>Група</td>
            <td>Потребител</td>
            <td>Заглавие</td>
            <td>Съдържание</td>';
    if (isset($_SESSION['isAdmin'])) {
        echo '<td>Изтриване</td>';
    }
    echo '</tr>';
 
    while ($result = mysqli_fetch_assoc($query)) {
        echo '<tr>
            <td>' . $result['date'] . '</td>
            <td>' . $groups[$result['groups']] . '</td>
            <td>' . $result['author'] . '</td>
            <td>' . $result['title'] . '</td>
            <td>' . $result['content'] . '</td>';
        if (isset($_SESSION['isAdmin'])) {
            $id = $result['message_id'];
            echo '<td><a href="delete.php?id='.$id.'">Изтрий</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
 else {
     echo 'Няма въведени съобщения.';
}

include 'footer.php';
?>