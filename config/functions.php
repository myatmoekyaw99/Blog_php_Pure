<?php

function dd($val){
    echo "<pre>";
    var_dump($val);
    die();
}

function checkAdmin(){

    if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){

        header('location: login.php');
      }
}
