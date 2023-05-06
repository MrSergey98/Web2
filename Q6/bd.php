<?php
    function db() {
        $user='u52876';
        $pass='9106944';
        return new PDO ("mysql:host=localhost;dbname=u52876", $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      }
?>