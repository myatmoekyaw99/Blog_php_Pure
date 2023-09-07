<?php

function dd($val){
    echo "<pre>";
    var_dump($val);
    die();
}

function checkLogin(){

    if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){

        header('location: login.php');
    }
}

function checkAdmin(){
    $result = empty($_SESSION['role']) ?? $_SESSION['role'] === 1;
    if($result){

        header('location: login.php');
      }
}

function isLogin(){
    if(! empty($_SESSION['user_id']) && ! empty($_SESSION['logged_in'])){

        header('location: index.php');
    }
}


