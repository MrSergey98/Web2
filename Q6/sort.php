<?php
require_once("bd.php");
    if (empty($_SERVER['PHP_AUTH_USER']) ||empty($_SERVER['PHP_AUTH_PW'])) {
        header('HTTP/1.1 401 Unanthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        print('<h1>401 Требуется авторизация</h1>');
        exit();
      }
    print('<head><link rel="stylesheet" href="styles.css"></head>');
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
    
    print("<form method='POST'> <div>");
    print("<label>Суперспособности: </label> <input name='super' type='radio' value='1'>Бессмертие <input name='super' type='radio' value='2'>Прохождение сковзь стены <input name='super' type='radio' value='3'>Левитация </div>");
    if(!empty($_POST)&&!empty($_POST['super'])){
        $i = $_POST['super'];
        switch($i){
            case '1': {
                $s="Бессмертие";
                break;
            }
            case '2': {
                $s="Прохождение сквозь стены";
                break;
            }
            case '3': {
                $s="Левитация";
                break;
            }
        }
        $stmt = $db->query("SELECT count(idinfo) as c from sopid where idsuper=$i group by idsuper")->fetchAll();
        $count=0;
        if(!empty($stmt)){
            $count=$stmt[0]['c'];
        }
        print("Количество людей с суперспособностью ". $s . ": ". $count);
    }
    else {
        print("Выберите суперспособности");
    }
    print("<input class='submit' name='sort' type='submit' value='Сортировать'>");
    print("<a class='redir' style='width: 135px;' name='exit' type='submit' href='admin.php'>Выход</a>");
    
    print(" </form>");

?>