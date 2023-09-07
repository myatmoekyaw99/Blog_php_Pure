<?php

require '../config/config.php';
require '../config/functions.php';

checkAdmin();

    if($_POST){

        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        if($_FILES['image']['name'] != null){

            $file = 'images/'.$_FILES['image']['name'];
            $imageType = pathinfo($file,PATHINFO_EXTENSION);

            if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){

                echo "<script>
                alert('Incorrect file extension!Image must be png,jpg or jpeg.');
                </script>";

            }else{

                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],$file);

                $statement = $pdo->prepare("UPDATE posts SET title=:title,content=:content,image=:image WHERE id=:id");
                
                $result = $statement->execute(
                    array(
                        ':id' => $id,
                        ':title' => $title,
                        ':content' => $content,
                        ':image' => $image,
                    ),
                );

                if($result){
                    echo "<script> 
                    alert('Successfully updated!!');
                    window.location.href='index.php';
                    </script>";
                }
            }      
        }else{

            $statement = $pdo->prepare("UPDATE posts SET title=:title,content=:content WHERE id=:id");
                
            $result = $statement->execute(
                array(
                    ':id' => $id,
                    ':title' => $title,
                    ':content' => $content,
                ),
            );

            if($result){

                echo "<script> alert('Successfully updated!!');
                window.location.href='index.php';
                </script>";
            }
        }
    }    

        $statement = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
        $statement->execute();
        $results = $statement->fetchAll();

    include 'views/header.php';
?>
        
<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h1 class="card-title font-weight-bold">Edit Posts</h1>            
      </div>
      <!-- /.card-header -->
      <div class="card-body">
       <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $results[0]['id']?>">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?= $results[0]['title']?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" rows="8" cols="80"><?= $results[0]['content']?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image</label><br>
                <img src="images/<?= $results[0]['image']?>" alt="" width="150" height="150" class="mb-2"><br>
                <input type="file" name="image" id="image" value="">
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