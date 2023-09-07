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

require 'header.php';
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
          
          <?php foreach($results as $value) :?>
          <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block">
                  <img class="img-circle" src="dist/img/user1-128x128.jpg" alt="User Image">
                  <span class="username"><a href="#">Jonathan Burke Jr.</a></span>
                  <span class="description">Shared publicly - 7:30 PM Today</span>
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

        <nav class="row mb-3">
          <ul class="pagination mx-auto">
            <li class="page-item">
              <a class="page-link" href="<?php if($total_pages == 1){echo '#';}else{echo '?pageno=1';}?>">First</a>
            </li>
            <li class="page-item <?php if($pageno <= 1){ echo 'disabled';}?>">
              <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo '?pageno='.($pageno-1);}?>">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#"><?= $pageno; ?></a></li>

            <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';}?>">
              <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#';}else{echo '?pageno='.($pageno+1);}?>">Next</a>
            </li>
            <li class="page-item"><a class="page-link" href="<?= ($total_pages == 1) ? '#' : '?pageno='.$total_pages;?>">Last</a></li>
          </ul>
        </nav>
        <!--Contact--->
        <div class="row bg-dark pt-3" id="contact">
          <div class="col-md-4 mx-auto">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">Alexander Pierce</h3>
                <h5 class="widget-user-desc">Founder & CEO</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="dist/img/user1-128x128.jpg" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <!-- <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="text-info">3,200</h5>
                      <span class="text-info">SALES</span>
                    </div>
                    /.description-block
                  </div> -->
                  <!-- /.col -->
                  <div class="col-sm-6 border-right">
                    <div class="description-block">
                      <p class="text-info my-0">aprogrammer@gmail.com</p>
                      <span class="text-info"><a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a></span><br>
                      <span class="text-info"><a href="#"><i class="fa-brands fa-linkedin"></i> Linkedin</a></span>
                      <span class="text-info"><a href="#"><i class="fa-brands fa-github"></i> Github</a></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                    <div class="description-block">
                      <h6 class="text-info"> No.130/B, 18th St, Latha, Yangon.</h6>
                      <span class="text-info">09-999000111</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.col -->
          <div class="col-md-8 bg-dark" style="padding: 250px 0 0 100px;">
            <strong>Copyright &copy; 2023-2024 <a href="#">A Programmer</a>.</strong> All rights reserved.
          </div>
        </div>
        <!-- /.row --> 
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
<?php include 'footer.html';?>
