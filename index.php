<?php

session_start();
require 'config/functions.php';
require 'config/config.php';

if(! empty($_GET['pageno'])){
  $pageno = $_GET['pageno'];
}else{
  $pageno = 1;
}

$numOfrecs = 3;
$offset = ($pageno - 1) * $numOfrecs;

if(empty($_POST['search'])){

  $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
  $statement->execute();
  $rawResults = $statement->fetchAll();

  $total_pages = ceil(count($rawResults) / $numOfrecs);

  $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $statement->execute();
  $results = $statement->fetchAll();

}else{
  $searchKey = $_POST['search'];

  $statement = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%".$searchKey."%' ORDER BY id DESC");
  $statement->execute();
  $rawResults = $statement->fetchAll();
  // dd($rawResults);
  
  $total_pages = ceil(count($rawResults) / $numOfrecs);

  $statement = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%{$searchKey}%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $statement->execute();
  $results = $statement->fetchAll();
}

require 'views/header.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <form class="form-inline ml-auto" method="POST">
            <div class="input-group input-group-sm">
              <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search">
            </div>

            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
            </div>
          </form>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <?php foreach($results as $value) :

            $statement = $pdo->prepare("SELECT * FROM users WHERE id=".$value['author_id']);
            $statement->execute();
            $user = $statement->fetch();
            
            
          ?>
          <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block">
                  <img class="img-circle" src="admin/images/<?= $user['image'];?>" alt="User Image">
                  <span class="username"><a href="#"><?= $user['name'];?></a></span>
                  <span class="description">Shared publicly -  
                    <?php $date = new DateTimeImmutable($value['created_at']);
                      echo $date->format('d/m/y');
                      echo "&nbsp;&nbsp;&nbsp;";
                      echo $date->format('g:i a');
                    ?>
                  </span>
                </div>
                <!-- /.user-block -->
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="postdetail.php?id=<?= $value['id']?>">
                  <img class="img-fluid pad" src="admin/images/<?= $value['image']?>" alt="Photo" style="height: 200px !important;">
                  <h5 class="mt-2"><?= $value['title'];?></h5>
                </a>
              </div>
              <!-- /.card-body -->
              <!-- /.card-footer -->
              <div class="card-footer text-center">
                <?php 
                
                  $stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id =".$value['id']);
                  $stmt->execute();
                  $cms = $stmt->fetchAll();
                
                ?>
              <span class=" text-muted ">127 likes - <?= count($cms);?> comments</span>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <?php endforeach; ?>
        </div>
        <!-- /.row -->

<?php require 'views/pagination.php';?>
<?php include 'views/footer.php';?>
