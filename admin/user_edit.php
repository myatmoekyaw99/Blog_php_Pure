<?php

require '../config/config.php';
require '../config/functions.php';

checkAdmin();

if($_POST){

    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'] ?? 0;

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

            $stmt = $pdo->prepare('UPDATE users SET name=:name,email=:email,image=:image,role=:role,password=:password WHERE id='.$id);
            $result = $stmt->execute(
                array(
                    ':name' => $name,
                    ':email' => $email,
                    ':image' => $image,
                    ':role' => $role,
                    ':password' => $password 
                ),
            );

        }
    }else{

        $stmt = $pdo->prepare('UPDATE users SET name=:name,email=:email,role=:role,password=:password WHERE id='.$id);
        $result = $stmt->execute(
            array(
                ':name' => $name,
                ':email' => $email,
                ':role' => $role,
                ':password' => $password 
            ),
        );

    }

    if($result){
        echo "<script> 
        alert('Successfully updated!!');
        window.location.href='user_show.php';
        </script>";
    }
    
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id='.$_GET['id']);
$stmt->execute();
$user = $stmt->fetch();

include 'views/header.php';

?>
        
<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h1 class="card-title font-weight-bold">Edit Users</h1>            
      </div>
      <!-- /.card-header -->
      <div class="card-body">
       <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $user['id']?>">
            <div class="form-group">
                <label for="title">Name</label>
                <input type="text" name="name" id="name" value="<?= $user['name']?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="content">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $user['email']?>" required>
            </div>

            <div class="form-group">
                <label for="image">Image</label><br>
                <img src="images/<?= $user['image']?>" alt="" width="150" height="150" class="mb-2"><br>
                <input type="file" name="image" id="image" class="form-control" value="">
            </div>

            <div class="form-group">
                <label for="password">Password</label><br>
                <input type="password" name="password" id="password" class="form-control" value="<?= $user['password']?>" required>
            </div>

            <div class="form-group">
                <label class="h5" for="role"><input type="checkbox" name="role" id="role" value="1" <?= $user['role'] === 1 ? 'checked': '';?>>  Admin</label>
            </div>

            <div class="form-group">
                <a href="user_show.php" class="btn btn-warning" >Back</a>
                <input type="submit" name="submit" id="submit" value="Update" class="btn btn-primary">
            </div>
       </form>
      </div>
      <!-- /.card-body -->
      
    </div>
    <!-- /.card -->

</div>

<?php include 'views/footer.html'; ?>

