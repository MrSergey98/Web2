<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
require_once("bd.php");
function v_name($name){
  if(preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",trim($name)) || (strlen(trim($name))<2 || strlen(trim($name))>50)){
    return false;
  }
  return true;
}
function v_email($email){
  if(!preg_match("/[a-zA-z][a-zA-Z0-9]{0,}@[a-z]{0,}\.[a-z]{0,}/i",$email) || (strlen($email)<2 || strlen($email)>50))
    return false;
  return true;
}
function v_bdate($bdate){
  if(preg_match("/^$/",$bdate))
    return false;
  return true;
}
function v_limb($limb){
  if(!isset($limb))
    return false;
  return true;
}
function v_gender($gender){
  if(!isset($gender))
    return false;
  return true;
}
function v_super($super){
  if(!isset($super))
    return false;
  return true;
}
function v_biography($biography){
  if(preg_match("/^$/",$biography))
    return false;
  return true;
}

if($_SERVER['REQUEST_METHOD']=='GET') {

  if (empty($_SERVER['PHP_AUTH_USER']) ||empty($_SERVER['PHP_AUTH_PW'])) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
  print('<head><link rel="stylesheet" href="styles.css"></head>');
  print('Вы успешно авторизовались и видите защищенные паролем данные.');
  if(!empty($_COOKIE['err'])) {
    print("<div class='err' style='width:fit-content; font-size:25px; color: red;'>Некорректно введены значения</div>");
    setcookie('err','',10);
  }
  
  print("<form method='POST'>");
  try {
    
    $db = db();
    $login = $_SERVER['PHP_AUTH_USER'];
    $pw = $_SERVER['PHP_AUTH_PW'];
    $stmt = $db->query("SELECT pass from logadm where logi='".$login."'")->fetch();
    if($stmt['pass']!=md5($pw)){
      header('HTTP/1.1 401 Unanthorized');
      header('WWW-Authenticate: Basic realm="My site"');
      print('<h1>401 Неверный логин или пароль</h1>');
      exit();
    }
    else {
      $data = $db->query("SELECT * from info")->fetchAll();
      if(empty($data)){
        print("Нет данных.");
        exit();
      }
      $count=count($data);
      if(is_array($data)){
        for($i=0;$i<$count;$i++ ){
          $id=$data[$i]['id'];
          $name=htmlspecialchars($data[$i]['name']);
          $email=htmlspecialchars($data[$i]['email']);
          $bdate=$data[$i]['bdate'];
          $gender=$data[$i]['gender'];
          $mg = $gender=='M'?'checked':'';
          $wg = $gender=='W'?'checked':'';
          $kol=$data[$i]['kol'];
          $biography=htmlspecialchars($data[$i]['biography']);
          $sg='';
          $sw='';
          $sl='';
          $super=$db->query("SELECT * from sopid where idinfo=$id")->fetchAll();
          if(is_array($super))
            foreach($super as $s)
              switch($s['idsuper']){
                case 1: {
                  $sg='selected'; break;
                }
                case 2: {
                  $sw='selected'; break;
                }
                case 3: {
                  $sl='selected'; break;
                }
              }
          else
            switch($super['idsuper']){
              case 1: {
                $sg='selected'; break;
              }
              case 2: {
                $sw='selected'; break;
              }
              case 3: {
                $sl='selected'; break;
              }
            }

          
          
          $name_err="";
          $email_err="";
          $bdate_err="";
          $gender_err="";
          $limb_err="";
          $super_err="";
          $biography_err="";
          if(!empty($_COOKIE['name_err'.$i])){
            $name_err="err";
            setcookie('name_err'.$i,'',-1,);
          }
          if(!empty($_COOKIE['email_err'.$i])){
            $email_err="err";
            setcookie('email_err'.$i,'',-1);
          }
          if(!empty($_COOKIE['bdate_err'.$i])){
            $bdate_err="err";
            setcookie('bdate_err'.$i,'',-1);
          }
          if(!empty($_COOKIE['gender_err'.$i])){
            $gender_err="err";
            setcookie('gender_err'.$i,'',-1);
          }
          if(!empty($_COOKIE['limb_err'.$i])){
            $limb_err="err";
            setcookie('limb_err'.$i,'',-1);
          }
          if(!empty($_COOKIE['super_err'.$i])){
            $super_err="err";
            setcookie('super_err'.$i,'',-1);
          }
          if(!empty($_COOKIE['biography_err'.$i])){
            $biography_err="err";
            setcookie('biography_err'.$i,'',-1);
          }
          

          print(' <div style="border: 1px solid black; padding: 30px; display: flex; align-items: center;">');
          print(" <input type='checkbox' name='ch$i' value='$id'>   ");
          print(" <label>id:".strval($id)."</label>");
          print(" <label>Имя: <input name='name$i' class='$name_err' value='$name'> </label>");
          print(" <label>e-mail: <input name='email$i' class='$email_err' value='$email'> </label>");
          print(" <label>Дата рождения: <input type='date' class='$bdate_err' name='bdate$i' value='$bdate'> </label>");
          print(" <label class='$gender_err'>Пол: М:<input type='radio'  name='gender$i' value='M' $mg>  Ж:<input type='radio' name='gender$i' value='W' $wg> </label>");
          print(" <label> Кол-во конечностей: <div class='$limb_err'>");
          for($j=1;$j<=4;$j++){
            if($j==($kol)){
              print(" <label>$j</label><input name='limb$i' value='$j' type='radio' checked>");
            }
            else
              print(" <label>$j</label><input name='limb$i' value='$j' type='radio'>");
          }
          print("</div> </label>");
          print("<label>Суперспособности: </label><select class='$super_err' name='super$i".'[]'."' multiple> <option name='super1' value='Бессмертие' $sg>Бессмертие</option> <option name='super2' value='Прохождение сковзь стены' $sw>Прохождение сковзь стены</option> <option name='super3' value='Левитация' $sl>Левитация</option> </select> ");
          print(" <label>Биография: </label><textarea class='$biography_err' name='biography$i'>$biography</textarea>");
          print(' </div>');
          
        }
      }


    }
  }
  catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }

  print("<input class='submit' type='submit' name='change' value='Изменить выбранные'> ");
  print("<input class='submit' type='submit' name='delete' value='Удалить выбранные'> ");
  print("<a class='redir' style='width: 200px;' name='sort' href='sort.php'>Сортировать</a>");
  print("</form");
  
}
else {

  if (empty($_SERVER['PHP_AUTH_USER']) ||empty($_SERVER['PHP_AUTH_PW'])) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }

  try{
    $db=db();

    $login = $_SERVER['PHP_AUTH_USER'];
    $pw = $_SERVER['PHP_AUTH_PW'];
    $stmt = $db->query("SELECT pass from logadm where logi='".$login."'")->fetch();
    if($stmt['pass']!=md5($pw)){
      header('HTTP/1.1 401 Unanthorized');
      header('WWW-Authenticate: Basic realm="My site"');
      print('<h1>401 Неверный логин или пароль</h1>');
      exit();
    }


    $count = $db->query("SELECT id from info")->fetchAll();
    $count = count($count);
    $onchange=array();
    for($i=0;$i<$count;$i++){
      if(!empty($_POST['ch'.$i])){
        $onchange[]=$i;
      }
    }
    if(!empty($_POST['change'])){
      foreach($onchange as $s){
        
        
        $err=false;



        if(!v_name($_POST['name'.$s]))
        {
          setcookie('name_err'.$s,'1',time()+10000);
          $err=true;
        }
        else {

        }
        
        if(!v_email($_POST['email'.$s]))
        {
          setcookie('email_err'.$s,'1',time()+10000);
          $err=true;
        }
        if(!v_bdate($_POST['bdate'.$s]))
        {
          setcookie('bdate_err'.$s,'1',time()+10000);
          $err=true;
        }
        if(!v_gender($_POST['gender'.$s]))
        {
          setcookie('gender_err'.$s,'1',time()+10000);
          $err=true;
        }
        if(!v_limb($_POST['limb'.$s]))
        {
          setcookie('limb_err'.$s,'1',time()+10000);
          $err=true;
        }
        if(!v_biography($_POST['biography'.$s]))
        {
          setcookie('biography_err'.$s,'1',time()+10000);
          $err=true;
        }
        if(!v_super($_POST['super'.$s]))
        {
          setcookie('super_err'.$s,'1',time()+10000);
          $err=true;
        }
        if($err){
          setcookie('err','1',time()+10000);
          continue;
        }
        else{
          $stmt = $db->prepare("UPDATE info set name= :fname, email=:email ,bdate= :bdate, gender= :gender, kol= :kol,biography= :biography where id=:id");
          $stmt->bindParam(':id',$_POST['ch'.$s]);
          $stmt->bindParam(':fname',htmlspecialchars($_POST['name'.$s]));
          $stmt->bindParam(':email',htmlspecialchars($_POST['email'.$s]));
          $stmt->bindParam(':bdate',$_POST['bdate'.$s]);
          $stmt->bindParam(':gender',$_POST['gender'.$s]);
          $stmt->bindParam(':kol',$_POST['limb'.$s]);
          $stmt->bindParam(':biography',htmlspecialchars($_POST['biography'.$s]));
          $stmt->execute();
          $id=$_POST['ch'.$s];
          $stmt = $db->prepare("DELETE from sopid where idinfo=$id");
          $stmt->execute();
          foreach ($_POST['super'.$s] as $sup) {
            switch($sup) {
              case "Бессмертие": {
                $stmt = $db->prepare("INSERT INTO sopid VALUES($id, 1)");
                $stmt->execute();; break;
              }
              case "Левитация": {
                $stmt = $db->prepare("INSERT INTO sopid VALUES($id, 3)");
                $stmt->execute(); break;
              }
              case "Прохождение сковзь стены": { 
                $stmt = $db->prepare("INSERT INTO sopid VALUES($id, 2)");
                $stmt->execute(); break;
              }
            }
          }
        }
      }
    }
    if(!empty($_POST['delete'])){
      foreach($onchange as $s){
        $id=$_POST['ch'.$s];
        $stmt = $db->prepare("DELETE from info where id=$id");
        $stmt->execute();
        $stmt = $db->prepare("DELETE from sopid where idinfo=$id");
        $stmt->execute();
        $stmt=$db->prepare("DELETE from log where id=$id");
        $stmt->execute();
      }
    }
  }
  catch(PDOException $e){
    echo $e->getMessage();
    exit();
  }
  header('Location: admin.php');
}


// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
