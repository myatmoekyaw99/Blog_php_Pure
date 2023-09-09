<?php

require '../config/config.php';
require '../config/functions.php';

checkAdmin();

if($_POST){

    $file = 'images/'.$_FILES['image']['name'];
    $imageType = pathinfo($file,PATHINFO_EXTENSION);

    if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){

        echo "<script>
        alert('Incorrect file extension!Image must be png,jpg or jpeg.');
        </script>";
    }else{

        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $statement = $pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUES(:title,:content,:image,:authorid)");
        
        $result = $statement->execute(
            array(
                ':title' => $title,
                ':content' => $content,
                ':image' => $image,
                ':authorid' => $_SESSION['user_id']
            ),
        );

        if($result){

            echo "<script> alert('Successfully updated!!');
                window.location.href='index.php';
                </script>";
        }
    }
}


?>

<?php include 'views/header.php'; ?>
        
<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h1 class="card-title font-weight-bold">Create Posts</h1>            
      </div>
      <!-- /.card-header -->
      <div class="card-body">
       <form action="add.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" rows="8" cols="80"></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image</label><br>
                <input type="file" name="image" id="image" value="" required>
            </div>

            <div class="form-group">
                <label class="h5" id="role"><input type="checkbox" name="role" id="role" value="1" class="">  Admin</label>
            </div>

            <div class="form-group">
                <a href="index.php" class="btn btn-warning" >Back</a>
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
            </div>
       </form>
      </div>
      <!-- /.card-body -->
      
    </div>
    <!-- /.card -->

</div>

<?php include 'views/footer.html'; ?>
