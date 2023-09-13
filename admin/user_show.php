<?php

require '../config/config.php';
require '../config/functions.php';

checkAdmin();
// dd(checkAdmin());

if(! empty($_GET['pageno'])){
  $pageno = $_GET['pageno'];
}else{
  $pageno = 1;
}

$numOfrecs = 4;
$offset = ($pageno - 1) * $numOfrecs;

if(empty($_POST['search'])){

  $statement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
  $statement->execute();
  $rawResults = $statement->fetchAll();

  $total_pages = ceil(count($rawResults) / $numOfrecs);

  $statement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $statement->execute();
  $results = $statement->fetchAll();

}else{

  $searchKey = $_POST['search'];

  $statement = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%".$searchKey."%' ORDER BY id DESC");
  $statement->execute();
  $rawResults = $statement->fetchAll();
  // dd($rawResults);
  
  $total_pages = ceil(count($rawResults) / $numOfrecs);

  $statement = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%{$searchKey}%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $statement->execute();
  $results = $statement->fetchAll();
}

include 'views/header.php'; 

?>

  <div class="col-md-12">

    <h4 class="text-info">Users Table</h4>

    <div class="card">
      <div class="card-header">
        <!-- <h1 class="card-title">Posts Lists</h1>             -->
        <div class="float-right">
          <a href="user_add.php" type="button" class="btn btn-success">Create new user</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
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
              <td><?=$result['name']?></td>
              <td>
              <?= $result['email']; ?>
              </td>
              <td>
              <?= $result['role'] === 0 ? 'User' : 'Admin' ;?>
              </td>
              <td>
                <div class="btn-group">
                  <a href="user_edit.php?id=<?= $result['id']?>" type="button" class="btn btn-info ml-2">Edit</a>
                </div>
                <div class="btn-group">
                  <a href="user_delete.php?id=<?= $result['id']?>" type="button" class="btn btn-danger ml-2" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
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
