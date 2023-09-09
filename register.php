<?php

session_start();
 
require 'config/config.php';
require 'config/functions.php';


if($_POST){

  $file = 'images/'.$_FILES['image']['name'];
  $imageType = pathinfo($file,PATHINFO_EXTENSION);
  
  if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){

    echo "<script>
    alert('Incorrect file extension!Image must be png,jpg or jpeg.');
    </script>";
  }else{

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],$file);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        echo "<script>
        alert('Email already exist!');
    </script>";
    }else{
        $statement = $pdo->prepare("INSERT INTO users(name,email,password,image) VALUES(:name,:email,:password,:image)");
        $result = $statement->execute(
            array(
                ':name' => $name,
                ':email' => $email,
                ':password' => $password,
                ':image' => $image
            ),
        );

        if($result){
            echo "<script>alert('User registration is successful!'); window.location.href='login.php';</script>";
        }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User | Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="login.php"><b>User</b> Register</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body bg-info">
      <p class="login-box-msg">Register a new account</p>

      <form action="register.php" method="post" enctype="multipart/form-data">

        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <label for="image">Profile image:</label><br>
        <div class="input-group mb-3">
          <input type="file" name="image" id="image" class="form-control" placeholder="Image">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-image"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 mx-auto">
            <button type="submit" class="btn btn-primary btn-block bg-dark">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>