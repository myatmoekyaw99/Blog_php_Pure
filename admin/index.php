<?php

require '../config/config.php';
require '../config/functions.php';

checkAdmin();
// dd(checkAdmin());
search();

if(! empty($_GET['pageno'])){
  $pageno = $_GET['pageno'];
}else{
  $pageno = 1;
}

$numOfrecs = 10;
$offset = ($pageno - 1) * $numOfrecs;

if(empty($_POST['search']) && empty($_COOKIE['search'])){

  $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
  $statement->execute();
  $rawResults = $statement->fetchAll();

  $total_pages = ceil(count($rawResults) / $numOfrecs);

  $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $statement->execute();
  $results = $statement->fetchAll();

}else{

  $searchKey = $_POST['search'] ?? $_COOKIE['search'];

  $statement = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%".$searchKey."%' ORDER BY id DESC");
  $statement->execute();
  $rawResults = $statement->fetchAll();
  // dd($rawResults);
  
  $total_pages = ceil(count($rawResults) / $numOfrecs);

  $statement = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%{$searchKey}%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $statement->execute();
  $results = $statement->fetchAll();
}

$statement = $pdo->prepare("SELECT * FROM users WHERE role=0 ORDER BY id DESC");
$statement->execute();
$uresults = $statement->fetchAll();

$statement = $pdo->prepare("SELECT * FROM posts");
$statement->execute();
$post = $statement->fetchAll();

$statement = $pdo->prepare("SELECT * FROM comments");
$statement->execute();
$cmt = $statement->fetchAll();


include 'views/header.php'; 

?>

  <div class="col-md-12">

    <h5 class="">Info Box</h5>
    <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Posts</span>
            <span class="info-box-number"><?= count($post);?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="far fa-comment"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Comments</span>
            <span class="info-box-number"><?= count($cmt);?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="far fa-user"></i></span>

          <a href="user_show.php" class="text-dark">
            <div class="info-box-content">
              <span class="info-box-text">Users</span>
              <span class="info-box-number"><?= count($uresults);?></span>
            </div>
          </a>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Likes</span>
            <span class="info-box-number">93,139</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="card">
      <div class="card-header">
        <h1 class="card-title">Posts Lists</h1>            
        <div class="float-right">
          <a href="add.php" type="button" class="btn btn-success">Create new post</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Title</th>
              <th>Content</th>
              <th style="width: 200px">Actions</th>
            </tr>
          </thead>
          <tbody>

          <?php 
            if($results){
              $i=1;
              foreach($results as $result){
          ?>
            <tr>
              <td><?= $i ?></td>
              <td><?=$result['title']?></td>
              <td>
              <?= substr($result['content'],0,80); ?>
              </td>
              <td>
                <div class="btn-group">
                  <a href="edit.php?id=<?= $result['id']?>" type="button" class="btn btn-info ml-2">Edit</a>
                </div>
                <div class="btn-group">
                  <a href="delete.php?id=<?= $result['id']?>" type="button" class="btn btn-danger ml-2" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                </div>
              </td>
            </tr>
          <?php $i++; 
            }
          } ?>

          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
      <nav aria-label="Page navigation example">
        <ul class="pagination float-right mr-3">
          <li class="page-item">
            <a class="page-link" href="<?php if($total_pages == 1){echo '#';}else{echo '?pageno=1';}?>">First</a>
          </li>
          <li class="page-item <?php if($pageno <= 1){ echo 'disabled';}?>">
            <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo '?pageno='.($pageno-1);}?>">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="#">Page <?= $pageno; ?></a></li>

          <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';}?>">
            <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#';}else{echo '?pageno='.($pageno+1);}?>">Next</a>
          </li>
          <li class="page-item"><a class="page-link" href="<?= ($total_pages == 1) ? '#' : '?pageno='.$total_pages;?>">Last</a></li>
        </ul>
      </nav>
    </div>
    <!-- /.card -->

  </div>

  <?php include 'views/footer.html'; ?>
