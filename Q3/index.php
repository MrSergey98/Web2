<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css.css">
    <title>Задание 3</title>
</head>
<body>

    <?php
        include("form.php");
    ?>
    
    <form action="" method="post">
        <?php 
                echo  '<div style="font-size: 25px; color: red; border-radius: 5px; font-weight: bold; text-align: center;">'.$msg.'</div>' ;
        ?>
        
        <label>Имя: <input type="text" class="mrg" name="name" value="<?php echo $name; ?>"></label>

        <label>E-mail: <input type="email" class="mrg" name="email" value="<?php echo $email; ?>"></label>

        <label>Дата рождения: <input type="date" name="bdate" id="" class="mrg" value="<?php echo $date; ?>"></label>

        <div style="display: flex; align-items: center;">
            <label>Пол: </label>
            М<input type="radio" name="gender" id="" class="mrg" value="M" <?php echo $gm ?>>
            Ж<input type="radio" name="gender" id="" class="mrg" value="W" <?php echo $gw ?>>
        </div>

        <label for="">Количество конечностей:
            1<input type="radio" name="limb" id="1limb" value="1" <?php echo $l1; ?>>
            2<input type="radio" name="limb" id="2limb" value="2" <?php echo $l2; ?>>
            3<input type="radio" name="limb" id="3limb" value="3" <?php echo $l3; ?>>
            4<input type="radio" name="limb" id="4limb" value="4" <?php echo $l4; ?>>
        </label>

        <label for="" class="mrg">Суперспособности:</label>
        <select name="super[]" id="" multiple>
            <option name="super1" value="Бессмертие" <?php echo $sg;?>>Бессмертие</option>
            <option name="super2" value="Прохождение сковзь стены" <?php echo $sw;?>>Прохождение сковзь стены</option>
            <option name="super3" value="Левитация" <?php echo $sl;?>>Левитация</option>
        </select>
            
        <label for="biograf" class="mrg">Биография: </label><textarea id="" cols="30" rows="10" class="mrg" style="resize: none;" name="biograf"><?php echo $biograf;?></textarea>

        <label>С контактом ознакомлен:<input type="checkbox" name="check" id="" class="mrg" <?php echo $ch; ?>></label>

        <button name="btn" type="submit" class="mrg" value="Отправить" style="color: white;background-color: rgba(255, 0, 0, 0.726);border-radius: 15px;width: 150px;height: 35px;font-size: 20px;">Отправить</button>
    </form>
    
</body>
</html>