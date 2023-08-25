<?php

require '../config/config.php';
require '../config/functions.php';

checkAdmin();

$statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
$statement->execute();
$rawResults = $statement->fetchAll();

if(! empty($_GET['pageno'])){
  $pageno = $_GET['pageno'];
}else{
  $pageno = 1;
}

$numOfrecs = 5;
$offset = ($pageno - 1) * $numOfrecs;
$total_pages = ceil(count($rawResults) / $numOfrecs);

$statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
$statement->execute();
$results = $statement->fetchAll();

?>

<?php include 'views/header.php'; ?>

  <div class="col-md-12">
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
              <?= substr($result['content'],0,60); ?>
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
            <a class="page-link" href="?pageno=1">First</a>
          </li>
          <li class="page-item <?php if($pageno <= 1){ echo 'disabled';}?>">
            <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo '?pageno='.($pageno-1);}?>">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="#"><?= $pageno; ?></a></li>

          <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';}?>">
            <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#';}else{echo '?pageno='.($pageno+1);}?>">Next</a>
          </li>
          <li class="page-item"><a class="page-link" href="?pageno=<?= $total_pages;?>">Last</a></li>
        </ul>
      </nav>
    </div>
    <!-- /.card -->

  </div>

  <?php include 'views/footer.html'; ?>
