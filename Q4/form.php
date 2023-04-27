<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css.css">
    <title>Задание 4</title>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

    <form action="" method="POST">

      <label>Имя: <input type="text" class="mrg" name="name" value="<?php print $values['fio']; ?>"></label>

        <label>E-mail: <input type="email" class="mrg" name="email" value="<?php print $values['email']; ?>"></label>

        <label>Дата рождения: <input type="date" name="bdate" id="" class="mrg" value="<?php print $values['date']; ?>"></label>

        <div style="display: flex; align-items: center;">
            <label>Пол: </label>
            М<input type="radio" name="gender" id="" class="mrg" value="M" <?php print $values['gender']=='M'?'checked':''; ?>>
            Ж<input type="radio" name="gender" id="" class="mrg" value="W" <?php print $values['gender']=='W'?'checked':''; ?>>
        </div>

        <label for="">Количество конечностей:
            1<input type="radio" name="limb" id="1limb" value="1" <?php print $values['limb']==1?'checked':''; ?>>
            2<input type="radio" name="limb" id="2limb" value="2" <?php print $values['limb']==2?'checked':''; ?>>
            3<input type="radio" name="limb" id="3limb" value="3" <?php print $values['limb']==3?'checked':''; ?>>
            4<input type="radio" name="limb" id="4limb" value="4" <?php print $values['limb']==4?'checked':''; ?>>
        </label>

        <label for="" class="mrg">Суперспособности:</label>
        <select name="super[]" id="" multiple>
            <option name="super1" value="Бессмертие" <?php print $values['sg'];?>>Бессмертие</option>
            <option name="super2" value="Прохождение сковзь стены" <?php print $values['sw'];?>>Прохождение сковзь стены</option>
            <option name="super3" value="Левитация" <?php print $values['sl']; ?>>Левитация</option>
        </select>
            
        <label for="biograf" class="mrg">Биография: </label><textarea id="" cols="30" rows="10" class="mrg" style="resize: none;" name="biograf"><?php print $values['biograf'];?></textarea>

        <label>С контактом ознакомлен:<input type="checkbox" name="check" id="" class="mrg" <?php print $values['ch']==''?'':'checked'; ?>></label>

        <button name="btn" type="submit" class="mrg" value="Отправить" style="color: white;background-color: rgba(255, 0, 0, 0.726);border-radius: 15px;width: 150px;height: 35px;font-size: 20px;">Отправить</button>

    </form>
  </body>
</html>
