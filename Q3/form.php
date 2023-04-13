<?php

    if(count($_POST)>0) {

    $user = 'u52876'; 
    $pass = '9106944'; 

    //echo var_dump($_POST);
    //echo $_POST['super'][0];
    $gm = "";
    $gw = "";
    $l1 = "";
    $l2 = "";
    $l3 = "";
    $l4 = "";
    
    $name = trim($_POST['name']);
    $email = htmlspecialchars(trim($_POST['email']));
    $date = date($_POST['bdate']);
    
    if(isset($_POST['gender'])){
        $gender = $_POST['gender'];
    }
    else {
        $gender = "undif";
    }
    if(isset($_POST['limb'])){
        $limb = (int)$_POST['limb'];
    }
    else {
        $limb = "undif";
    }
    
    $biograf = htmlspecialchars(trim($_POST['biograf']));
    $msg = '';

    if($gender == "M"){
        $gm = "checked";
    }
    elseif($gender == "W"){
        $gw = "checked";
    }
    switch($limb){
        case 1: $l1 = "checked"; break;
        case 2: $l2 = "checked"; break;
        case 3: $l3 = "checked"; break;
        case 4: $l4 = "checked"; break;
    }
    $sg = "";
    $sw = "";
    $sl = "";
    if(isset($_POST['super'])) {
        $super = $_POST['super'];
    }
    else {
        $super = array();
    }
    for($i = 0; $i<count($super);$i++){
        if($super[$i]=="Бессмертие"){
            $sg = "selected";
        }
        if($super[$i]=="Левитация"){
            $sl = "selected";
        }
        if($super[$i]=="Прохождение сковзь стены"){
            $sw = "selected";
        }
    }
    $ch = "";
    if(isset($_POST['check'])){
        $ch = "checked";
    }
    //validation
    if ( preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$name) || (strlen($name)<2 || strlen($name)>50) ) {
        $msg = 'Введите имя!';
    }
    elseif(!preg_match("/[a-zA-z][a-zA-Z0-9]{0,}@[a-z]{0,}\.[a-z]{0,}/i", $email) || (strlen($email)<2 || strlen($email)>50)) {
        $msg = 'Введите email!';
    }
    elseif(preg_match("/^$/",$date)){
        $msg = 'Введите дату рождения!';
    }
    elseif(preg_match("/^$/",$gm) & preg_match("/^$/",$gw)){
        $msg = 'Укажите пол!';
    }
    elseif(preg_match("/^$/",$l1) & preg_match("/^$/",$l2) & preg_match("/^$/",$l3) & preg_match("/^$/",$l4)) {
        $msg = 'Укажите кол-во конечностей!';
    }
    elseif(preg_match("/^$/",$sg) & preg_match("/^$/",$sw) & preg_match("/^$/",$sl)){
        $msg = 'Укажите суперспособности!';
    }
    elseif(preg_match("/^$/",$biograf)){
        $msg = 'Укажите биографию!';
    }
    elseif(preg_match("/^$/",$ch)){
        $msg= 'Отметьте пункт: С контактом ознакомлен!';
    }
    else {
        try { 
        $db = new PDO ("mysql:host=localhost;dbname=u52876", $user, $pass, [PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $stmt = $db->prepare("INSERT INTO info VALUES(NULL, :fname, :email, :bdate, :gender, :limb, :biography)");

        $stmt->bindParam(':fname',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':bdate',$date);
        $stmt->bindParam(':gender',$gender);
        $stmt->bindParam(':limb',$limb);
        $stmt->bindParam(':biography',$biograf);
        $stmt -> execute();

        $id1 = $db->lastInsertId();

        if($sg=="selected"){
            $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 1)");
            $stmt->execute();
        }
        if($sw=="selected"){
            $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 2)");
            $stmt->execute();
        }
        if($sl=="selected"){
            $stmt = $db->prepare("INSERT INTO sopid VALUES($id1, 3)");
            $stmt->execute();
        }

        $msg = '<div style="font-size: 25px; color: green; border-radius: 5px; font-weight: bold; text-align: center;"> Данные успешно переданы! </div>';
        }
        catch (PDOException $e) { 
            echo "FAIL: " . $e->getMessage();
            $msg = "Fail";
        }
        
    }
    
    

    //redirect
    // $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
    // header("Location: $redirect");
    // exit();


    //<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);
    }
    else {
        $msg = '';
        $name = '';
        $email = '';
        $date = '';
        $biograf = '';
        $gm = "";
        $gw = "";
        $l1 = "";
        $l2 = "";
        $l3 = "";
        $l4 = "";
        $sg = "";
        $sw = "";
        $sl = "";
        $ch = "";
    }
?>
