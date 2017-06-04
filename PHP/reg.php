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
if (isset($_POST['addr']) AND $_POST['fio']) {
    $addr = mysqli_real_escape_string($connection, $_POST['addr']);
    $fio = mysqli_real_escape_string($connection, $_POST['fio']);
    echo $addr . $fio;
    $query = "INSERT INTO library.customer VALUES (NULL, '" . $addr . "', '" . $fio . "')";
    mysqli_query($connection, $query);
    }
else echo "Введите корректные данные <br/>";
?>

<form action="/library/PHP/reg.php" method="POST">
    Адрес: <input type="text" name="addr">
    Ф.И.О.<input type="text" name="fio">
    <input type="submit" value="Зарегистрировать">
</form>
<form action="main.html" method="post">
    <input type="submit" value="Вернуться на главную">
</form>
