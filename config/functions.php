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

    if(empty($_SESSION['role']) || $_SESSION['role'] !== 1){
        header('location: login.php');
    }
}

function isLogin(){
    if(! empty($_SESSION['user_id']) && ! empty($_SESSION['logged_in'])){

        header('location: index.php');
    }
}

function search(){

    if(! empty($_POST['search'])){
        setcookie('search',$_POST['search'], time() + (86400 * 30) , "/");
    }else{
        if(empty($_GET['pageno'])){
            unset($_COOKIE['search']);
            setcookie('search','',-1,'/');
        } 
    }
}


