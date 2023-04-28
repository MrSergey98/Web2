<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    // Выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
    // Если в куках есть пароль, то выводим сообщение.
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['super'] = !empty($_COOKIE['super_error']);
  $errors['biograf'] = !empty($_COOKIE['biograf_error']);
  $errors['ch'] = !empty($_COOKIE['ch_error']);


  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните email.</div>';
  }
  if ($errors['date']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('date_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните дату рождения.</div>';
  }
  if ($errors['gender']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['limb']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limb_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите кол-во конечностей.</div>';
  }
  if ($errors['super']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('super_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Укажите суперспособности.</div>';
  }
  if ($errors['biograf']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('biograf_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }
  if ($errors['ch']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('ch_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Ознакомьтесь с контактом.</div>';
  }
  // Складываем предыдущие значения полей в массив, если есть.
  // При этом санитизуем все данные для безопасного отображения в браузере.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['sg'] = empty($_COOKIE['sg_value']) ? '' : $_COOKIE['sg_value'];
  $values['sw'] = empty($_COOKIE['sw_value']) ? '' : $_COOKIE['sw_value'];
  $values['sl'] = empty($_COOKIE['sl_value']) ? '' : $_COOKIE['sl_value'];
  $values['biograf'] = empty($_COOKIE['biograf_value']) ? '' : $_COOKIE['biograf_value'];
  $values['ch'] = empty($_COOKIE['ch_value']) ? '' : $_COOKIE['ch_value'];
  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login']))
  {
    // TODO: загрузить данные пользователя из БД
    // и заполнить переменную $values,
    // предварительно санитизовав.
    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
    $user = 'u52876'; 
    $pass = '9106944';
    $db = new PDO ("mysql:host=localhost;dbname=u52876", $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $id1=$_SESSION["uid"];
    $data = $db->query("SELECT * from info where id=$id1")->fetch();
    $values['fio'] = $data['name'];
    setcookie('fio_value', $data['name'], time() + 30 * 24 * 60 * 60);
    $values['email'] = $data['email'];
    setcookie('email_value', $data['email'], time() + 30 * 24 * 60 * 60);
    $values['date'] = $data['bdate'];
    setcookie('date_value', $data['bdate'], time() + 30 * 24 * 60 * 60);
    $values['gender'] = $data['gender'];
    setcookie('gender_value', $data['gender'], time() + 30 * 24 * 60 * 60);
    $values['limb'] = $data['kol'];
    setcookie('limb_value', $data['kol'], time() + 30 * 24 * 60 * 60);
    $values['biograf'] = $data['biography'];
    setcookie('biograf_value', $data['biography'], time() + 30 * 24 * 60 * 60);
    
    $data = $db->query("SELECT * from sopid where idinfo=$id1")->fetchAll();
    if(!empty($data)){
    if(is_array($data[0]))
      foreach($data as $d){
        switch($d['idsuper']) {
          case 1: {$values['sg']='selected'; setcookie('sg_value', 'selected', time() + 30 * 24 * 60 * 60); break;}
          case 3: {$values['sl']='selected'; setcookie('sl_value', 'selected', time() + 30 * 24 * 60 * 60); break;}
          case 2: {$values['sw']='selected'; setcookie('sw_value', 'selected', time() + 30 * 24 * 60 * 60); break;}
        }
      }
    else
      switch($data['idsuper']) {
        case 1: {$values['sg']='selected'; setcookie('sg_value', 'selected', time() + 30 * 24 * 60 * 60); break;}
        case 3: {$values['sl']='selected'; setcookie('sl_value', 'selected', time() + 30 * 24 * 60 * 60); break;}
        case 2: {$values['sw']='selected'; setcookie('sw_value', 'selected', time() + 30 * 24 * 60 * 60); break;}
      }
    }
    
  }

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {

  setcookie('fio_value', '', 100000);
  setcookie('email_value', '', 100000);
  setcookie('date_value', '', 100000);
  setcookie('gender_value', '', 100000);
  setcookie('limb_value', '', 100000);
  setcookie('sg_value', '', 100000);
  setcookie('sw_value', '', 100000);
  setcookie('sl_value', '', 100000);
  setcookie('biograf_value', '', 100000);
  setcookie('ch_value', '', 100000);
  
  // Проверяем ошибки.
  $errors = FALSE;
  if ( preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",trim($_POST['name'])) || (strlen(trim($_POST['name']))<2 || strlen(trim($_POST['name']))>50) ) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('fio_value', trim($_POST['name']), time() + 30 * 24 * 60 * 60);
  }

  if ( !preg_match("/[a-zA-z][a-zA-Z0-9]{0,}@[a-z]{0,}\.[a-z]{0,}/i", $_POST['email']) || (strlen($_POST['email'])<2 || strlen($_POST['email'])>50) ) {
    // Выдаем куку на день с флажком об ошибке в поле email.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', trim($_POST['email']), time() + 30 * 24 * 60 * 60);
  }

  if (preg_match("/^$/",$_POST['bdate'])) {
    // Выдаем куку на день с флажком об ошибке в поле date.
    setcookie('date_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('date_value', trim($_POST['bdate']), time() + 30 * 24 * 60 * 60);
  }

  if (!isset($_POST['gender'])) {
    // Выдаем куку на день с флажком об ошибке в поле gender.
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }

  if (!isset($_POST['limb'])) {
    // Выдаем куку на день с флажком об ошибке в поле limb.
    setcookie('limb_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limb_value', $_POST['limb'], time() + 30 * 24 * 60 * 60);
  }

  if (!isset($_POST['super'])) {
    // Выдаем куку на день с флажком об ошибке в поле super.
    setcookie('super_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    foreach ($_POST['super'] as $s) {
      switch($s) {
        case "Бессмертие": {setcookie("sg_value", 'selected', time() + 30 * 24 * 60 * 60); break;}
        case "Левитация": {setcookie("sl_value", 'selected', time() + 30 * 24 * 60 * 60); break;}
        case "Прохождение сковзь стены": {setcookie("sw_value", 'selected', time() + 30 * 24 * 60 * 60); break;}
      }
    }
  }

  if (preg_match("/^$/",$_POST['biograf'])) {
    // Выдаем куку на день с флажком об ошибке в поле biograf.
    setcookie('biograf_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('biograf_value', $_POST['biograf'], time() + 30 * 24 * 60 * 60);
  }

  if (!isset($_POST['check'])) {
    // Выдаем куку на день с флажком об ошибке в поле check.
    setcookie('ch_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('ch_value', isset($_POST['check'])?' ':'on', time() + 30 * 24 * 60 * 60);
  }


  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limb_error', '', 100000);
    setcookie('super_error', '', 100000);
    setcookie('biograf_error', '', 100000);
    setcookie('ch_error', '', 100000);
    setcookie('date_error', '', 100000);
  }

  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
    if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
    try {
    $user = 'u52876'; 
    $pass = '9106944';
    $db = new PDO ("mysql:host=localhost;dbname=u52876", $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $login=$_SESSION['login'];
    $id1 = $db->query("SELECT id from log where logi='".$login."'")->fetch();
    $id1=$id1[0];


    $stmt = $db->prepare("UPDATE info set name= :fname, email= '". $_POST['email'] ."' ,bdate= :bdate, gender= :gender,kol= :kol,biography= :biography where id=$id1");

    $stmt->bindParam(':fname',$_POST['name']);
    //$stmt->bindParam(':email',$_COOKIE['email_value']);
    $stmt->bindParam(':bdate',$_POST['bdate']);
    $stmt->bindParam(':gender',$_POST['gender']);
    $stmt->bindParam(':kol',$_POST['limb']);
    $stmt->bindParam(':biography',$_POST['biograf']);
    $stmt -> execute();

    $stmt=$db->prepare("DELETE from sopid where idinfo=$id1");
    $stmt->execute();
    

    foreach ($_POST['super'] as $s) {
      switch($s) {
        case "Бессмертие": {
          $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 1)");
          $stmt->execute();; break;
        }
        case "Левитация": {
          $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 3)");
          $stmt->execute(); break;
        }
        case "Прохождение сковзь стены": { 
          $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 2)");
          $stmt->execute(); break;
        }
      }
    }

    
    }
    catch (PDOException $e) { 
        echo "Fail: ".$e->getMessage();
        exit();
    }
  }
  else {
    // Генерируем уникальный логин и пароль.
    // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
    $str='qwertyuiopasdfghjklzxcvbnm1234567890';
    $login = substr(str_shuffle($str), 0, 5);
    $password = substr(str_shuffle($str), 0, 5);
    // Сохраняем в Cookies.
    setcookie('login', $login);
    setcookie('pass', $password);

    try {
    $user = 'u52876'; 
    $pass = '9106944';
    $db = new PDO ("mysql:host=localhost;dbname=u52876", $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $db->prepare("INSERT INTO info VALUES(NULL, :fname, :email ,:bdate,:gender,:limb,:biography)");

    $stmt->bindParam(':fname',$_POST['name']);
    $stmt->bindParam(':email',$_POST['email']);
    $stmt->bindParam(':bdate',$_POST['bdate']);
    $stmt->bindParam(':gender',$_POST['gender']);
    $stmt->bindParam(':limb',$_POST['limb']);
    $stmt->bindParam(':biography',$_POST['biograf']);
    $stmt -> execute();

    $id1 = $db->lastInsertId();

    foreach ($_POST['super'] as $s) {
      switch($s) {
        case "Бессмертие": {
          $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 1)");
          $stmt->execute();; break;
        }
        case "Левитация": {
          $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 3)");
          $stmt->execute(); break;
        }
        case "Прохождение сковзь стены": { 
          $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 2)");
          $stmt->execute(); break;
        }
      }
    }

    $password=md5($password);
    $stmt = $db->prepare("INSERT INTO log VALUES(:log, :hpas, $id1)");
    $stmt->bindParam(':log',$login);
    $stmt->bindParam(':hpas',$password);
    $stmt->execute();
    }
    catch (PDOException $e) {
        echo "Fail: ".$e->getMessage();
        exit();
    }
  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: ./');
}
