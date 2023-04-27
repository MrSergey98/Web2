<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if(!empty($_COOKIE['auth_error'])){
    setcookie('auth_error','',10000);
    $messages='<div class="error">Неверные логин или пароль.</div>';
  }
  else
    $messages='';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css.css">
  <title>Авторизация</title>
</head>
<body>
  <?php
  echo $messages;
  ?>
  <form action="" method="post" class="form_2">
    <label style="font-size: 25px; color: rgb(12,120,120)">Логин:</label> <input name="login" style="margin: 10px; height: 20px;"/> 
    <label style="font-size: 25px; color: rgb(12,120,120)">Пароль: </label><input name="pass" type="password" style="margin: 10px; margin-bottom: 20px;  height: 20px;"/> 
    <input type="submit" value="Войти" style="color: white;background-color: rgba(255, 0, 0, 0.726);border-radius: 15px;width: 150px;height: 35px;font-size: 20px;"/>
  </form>
  <a style="margin-top: 15px;color: white;background-color: rgba(255, 0, 0, 0.726);border-radius: 15px;width: 150px;height: 35px;font-size: 20px; text-align: center; padding-top: 10px; text-decoration: none;" href="unlog.php">ВЫЙТИ</a>
</body>
</html>


<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {

  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.
  $user = 'u52876'; 
  $pass = '9106944';
  $db = new PDO ("mysql:host=localhost;dbname=u52876", $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  $login = $_POST['login'];
  $password = md5($_POST['pass']);
  $stmt = $db->query("SELECT id from log where logi='".$login."'"." and pass='".$password."'")->fetch();
  // Если все ок, то авторизуем пользователя.
  if(!empty($stmt)){
    $_SESSION['login'] = $_POST['login'];
    // Записываем ID пользователя.
    $_SESSION['uid'] = $stmt['id'];
    setcookie('uid',$stmt['id'],time()+60*60*30);
    header('Location: ./');
  }
  else {
    setcookie('auth_error','1',time()+24 * 60 * 60);
    header('Location: login.php');
    exit();
  }
  // Делаем перенаправление.
 
}
