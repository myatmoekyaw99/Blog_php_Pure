
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aprogrammer | Blog</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
   <!-- Navbar -->
   <nav class="navbar navbar-expand navbar-dark py-2" style="border-bottom: 1px solid rgba(0,0,0,0.1);">
      <!-- Left navbar links -->
      <ul class="navbar-nav col-md-4">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link text-white">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#contact" class="nav-link text-white">Contact</a>
        </li>
      </ul>

      <ul class="navbar-nav col-md-4">
        <li class="nav-item d-none d-sm-inline-block mx-auto">
          <a href="index.php" class="nav-link text-white h5">A Programmer | <span class="text-info">Blog Site</span></a>
        </li>
      </ul>

      <ul class="navbar-nav col-md-4">

      <?php if($_SESSION['user_id'] ?? ''):?>
        <li class="nav-item d-none d-sm-inline-block ml-auto">
          <a href="index.php" class="nav-link text-info"><i class="fas fa-user mr-2"></i> Welcome <?= $_SESSION['username'];?></a>
        </li>
      <?php endif;?>
        <li class="nav-item d-none d-sm-inline-block ml-auto">
          <?php if($_SESSION['user_id'] ?? ''):?>
            <a href="logout.php" class="nav-link text-info"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
          <?php else :?>
            <a href="login.php" class="nav-link text-info"><i class="fas fa-user mr-2"></i> Login</a>
          <?php endif;?>
        </li>
      </ul>
    </nav>
  <!-- /.navbar -->