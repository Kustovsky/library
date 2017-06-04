<?php
$myrow1 = 0;
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
    $query = "INSERT INTO library.customer VALUES (NULL, '" . $fio . "', '" . $addr . "')";
    mysqli_query($connection, $query);
    echo "Зарегистрирован посетитель ".$fio.", проживающий по адресу: ".$addr;
    }


else echo "<center>Введите корректные данные <br/></center>";
?>
<html>
<head>
    <title>Регистрация</title>
    <link rel="stylesheet" href="CSS/reg.css">
</head>
<body>


<table>
    <tr>
        <td><form action="/library/register.php" method="POST">
                Адрес: <input type="text" name="addr"><br/>
                Ф.И.О.<input type="text" name="fio"><br/>
                <input type="submit" value="Зарегистрировать"><br/>
                <input type="submit" name="show" value="Список клиентов"><br/>
                <select name="sort">
                    <option value="desc">По убыванию</option>
                    <option value="acc">По возрастанию</option>
                </select>
            </form>
            <form action="main.html" method="post">
                <input type="submit" value="Вернуться на главную">
            </form></td>
        <td><?php
            if (isset($_POST['show'])) {
            if ($_POST['sort']=='desc') {
                $result1 = mysqli_query($connection, "SELECT * FROM customer ORDER BY name_cust DESC ");
                echo '<table border=1>';
                do {
                    echo '<tr><td>' . $myrow1['name_cust'] . '</td><td>' . $myrow1['cust_addr'] . '</td></tr>';
                } while ($myrow1 = mysqli_fetch_array($result1));
                echo '</table>';
            }
            else {
            $result1 = mysqli_query($connection,"SELECT * FROM customer ORDER BY name_cust ASC");
            echo '<table border=1>';
                do{
                echo '<tr><td>'.$myrow1['name_cust'].'</td><td>'.$myrow1['cust_addr'].'</td></tr>';
                }
                while ($myrow1 = mysqli_fetch_array($result1));
                echo '</table>';
            }
            }
            ?></td>
    </tr>
</table>

</body>
</html>
