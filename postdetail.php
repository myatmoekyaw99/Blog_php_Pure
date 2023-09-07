<?php
session_start();
require 'config/config.php';
require 'config/functions.php';

checkLogin();

$post_id = $_GET['id'];

$statement = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id=$post_id");
$stmt->execute();
$cmResults = $stmt->fetchAll();

if($_POST){

  $comment = $_POST['comment'];
  $statement = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES(:content,:authorid,:postid)");
  $result = $statement->execute(
      array(
          ':content' => $comment,
          ':authorid' => $_SESSION['user_id'],
          ':postid' => $post_id
      ),
  );

  if($result){
    header('location:postdetail.php?id='.$post_id);
  }
}
 
require 'header.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8 mx-auto">
            <ol class="breadcrumb">
              <li class="breadcrumb-item text-center"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item text-center active">Post</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <h3 class="my-2 text-center text-primary font-weight-bold"><?= $result['title'];?></h3>
        
        <div class="row">
          <div class="col-md-8 mx-auto">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block">
                  <img class="img-circle" src="dist/img/user1-128x128.jpg" alt="User Image">
                  <span class="username"><a href="#">Jonathan Burke Jr.</a></span>
                  <span class="description">Shared publicly - 7:30 PM Today</span>
                </div>
                <!-- /.user-block -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?= $result['image']?>" alt="Photo">

                <p class="mt-2"><?= $result['content'];?></p>
                <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button>
                <span class="float-right text-muted">127 likes - 3 comments</span>
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <h4 class="text-primary">Comments</h4>
                <hr class="bg-primary">

                <?php foreach($cmResults as $cmResult) :
                  
                  $author_id = $cmResult['author_id'] ?? '';
                  if($author_id){
                    $state = $pdo->prepare("SELECT * FROM users WHERE id=$author_id");
                    $state->execute();
                    $uresult = $state->fetch(PDO::FETCH_ASSOC);
                  }
                ?>
                <div class="mt-4 card-comment">
                  <!-- User image -->
                  <img class="img-circle img-sm" src="dist/img/user3-128x128.jpg" alt="User Image">
                  <div class="comment-text">
                    <span class="username">
                      <?= $uresult['name'] ?? '';?>
                      <span class="text-muted float-right">
                        <?php $date = new DateTimeImmutable($cmResult['created_at']);
                          echo $date->format('g:i a');
                        ?>
                      </span>
                    </span><!-- /.username -->
                    <?= $cmResult['content'];?>
                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
                  
                <?php endforeach ;?>

              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                  <div class="img-push">
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row -->
        <footer class="row bg-dark py-4">
          <!-- Default to the left -->
          <p class="mx-auto"><strong>Copyright &copy; 2023-2024 <a href="#">A Programmer</a>.</strong> All rights reserved.</p>
        </footer>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
    
  <?php include 'footer.html'?>
