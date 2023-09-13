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

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'] ?? 0;
        $image = $_FILES['image']['name'];

        // dd($role);
        move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $statement = $pdo->prepare("INSERT INTO users(name,email,image,role,password) VALUES(:name,:email,:image,:role,:password)");
        
        $result = $statement->execute(
            array(
                ':name' => $name,
                ':email' => $email,
                ':image' => $image,
                ':password' => $password,
                ':role' => $role
            ),
        );

        if($result){

            echo "<script> alert('Successfully updated!!');
                window.location.href='user_show.php';
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
       <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Name</label>
                <input type="text" name="name" id="name" value="" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="content">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Image</label><br>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label><br>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="h5" for="role"><input type="checkbox" name="role" id="role" value="1" class="">  Admin</label>
            </div>

            <div class="form-group">
                <a href="user_show.php" class="btn btn-warning" >Back</a>
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
            </div>
       </form>
      </div>
      <!-- /.card-body -->
      
    </div>
    <!-- /.card -->

</div>

<?php include 'views/footer.html'; ?>
