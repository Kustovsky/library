<?php
$connection = mysqli_connect("localhost","username","password");
if (!$connection) {
    die("Database connection failed: " . mysqli_error());
}
mysqli_set_charset($connection, "utf8");
$db_select = mysqli_select_db($connection, "library");
if (!$db_select) {
    die("Database selection failed: " . mysqli_error());
}
//Выбор имени
$name_cust = mysqli_query($connection, "SELECT id_cust, name_cust  FROM customer");
echo "<form action='run.php' method='post'>";
echo "<select name='name'>";
while ($row = mysqli_fetch_array($name_cust)) {
        echo "<option value='" . $row['id_cust'] . "'>" . $row['name_cust'] .  "</option>";
}
echo "</select>";

//Выбор книги
$choose_book = mysqli_query($connection, "SELECT title, id_book FROM bookshelf");

echo "<select name='title' method='post'>";
while ($row = mysqli_fetch_array($choose_book)) {
    echo "<option value='" . $row['id_book'] . "'>" . $row['title'] . "</option>";
}
echo "</select>";

//ID книги и посетителя
if (isset($_POST['show'])) {
$idbook = $_POST['title'];
$idcust = $_POST['name'];
}
//Дата приема и выдачи
$date_out = date("Y-m-d H:i:s");
$date_cache = str_replace('.', '/', $date_out);
$date_in = date("Y-m-d H:i:s",strtotime($date_cache . "+14 days"));
//Проведение транзакции выдачи
if (isset($_POST['show'])) {
    mysqli_query($connection, "INSERT INTO library.transaction VALUES (NULL, '" . $idbook . "','" . $idcust . "', '" . $date_out . "' , NULL , 'Получил' )");
    mysqli_query($connection, "UPDATE library.bookshelf SET quantity = quantity - 1 WHERE id_book = '" . $idbook . "'");

}
//Забор книг
elseif (isset($_POST['take'])) {
    $idbook = $_POST['title'];
    $idcust = $_POST['name'];
    mysqli_query($connection, "INSERT INTO library.transaction VALUES (NULL, '" . $idbook . "','" . $idcust . "', NULL , '" . $date_out . "', 'Вернул' )");
    mysqli_query($connection, "UPDATE library.bookshelf SET quantity = quantity + 1 WHERE id_book = '" . $idbook . "'");
}
//Выборка посетителей
//if (isset($_POST['search'])) {
    $myrow1 = 0;
    $myrow2 = 0;
    $result1 = mysqli_query($connection, "SELECT `transaction`.*, `customer`.name_cust
FROM `transaction`
INNER JOIN `customer`
ON `customer`.id_cust = `transaction`.id_cust
ORDER BY `transaction`.id_cust");
    $result2 = mysqli_query($connection, "SELECT `transaction`.*, `bookshelf`.title
FROM `transaction`
INNER JOIN `bookshelf`
ON `bookshelf`.id_book = `transaction`.id_book");
    echo '<table border=1>';
    echo '<tr>
<td>Имя</td><td>Название книги</td><td>Прием/передача</td><td>Дата возврата</td>
</tr>';
    do {
        echo '<tr><td>' . $myrow1['name_cust'] . '</td><td>' . $myrow2['title'] . '</td><td>' . $myrow1['in_out'] . '</td><td>' . $myrow1['date_in'] . '</td></tr>';
    } while ($myrow1 = mysqli_fetch_array($result1) and $myrow2 = mysqli_fetch_array($result2));
    echo '</table>';
//}

echo "<input type='submit' name='show' value='Выдать книгу'>";
echo "<input type='submit' name='take' value='Вернуть книгу'>";
echo "<input type='submit' name='search' value='Показать'>";
echo "</form>";
?>

<html>
<head>
    <title>Выдача книг</title>
    <link rel="stylesheet" href="CSS/reg.css">
</head>
<body>
<form action="run.php" method="post">
</form>
<form action="main.html" method="post">
    <input type="submit" value="Вернуться на главную">
</form>
</body>
</html>

