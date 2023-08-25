<?php

session_start();
require '../config/config.php';
require '../config/functions.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){

  header('location: login.php');
}

$statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
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
                  <a href="delete.php?id=<?= $result['id']?>" type="button" class="btn btn-danger ml-2">Delete</a>
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
      
    </div>
    <!-- /.card -->

  </div>

  <?php include 'views/footer.html'; ?>
