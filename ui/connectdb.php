<?php

    try{

        $pdo = new PDO ('mysql:host=localhost;dbname=edrian_db','root','');


    }catch(PDOexception $e){

        echo $e->getMessage();
    }

?>