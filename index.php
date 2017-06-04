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

if (isset($_POST['login']) && isset($_POST['password'])) {
    //Цепляем логин и пароль
    $login = mysqli_real_escape_string($connection, ($_POST['login']));
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    //Проверяем
    $result = mysqli_fetch_assoc(mysqli_query($connection, "SELECT login, password FROM `pers` WHERE `login`='".mysqli_real_escape_string($connection, $_POST['login'])."' LIMIT 1"));

    if ($result['password'] === $_POST['password'])  {
        //Логин успешен
        header("Location: main.html");;
    }
    else {
        //Если пользователя нет, то пусть пробует еще
        header("Location: index.php");
    }

}

?>
<html>
<head>
    <title>Вход</title>
    <link rel="stylesheet" href="CSS/reg.css">
</head>
<body>
<form action="index.php" method="POST">
    Логин: <input type="text" name="login" /><br />
    Пароль:  <input type="password" name="password" /><br />
    <input type="submit" name="submit" value="Войти" />
</form>
</body>
</html>

