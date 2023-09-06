<?php
require 'config/functions.php';
require 'config/config.php';

$statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
$statement->execute();
$results = $statement->fetchAll();

require 'header.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blogs</h1>
          </div>
          <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <form class="form-inline">
                  <div class="input-group input-group-sm">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                  </div>

                  <div class="input-group-append">
                      <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                      </button>
                  </div>
                </form>
            </li>
          </ul>
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
              <span class=" text-muted ">127 likes - 3 comments</span>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <?php endforeach; ?>
        </div>
        <!-- /.row -->

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
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="text-info">3,200</h5>
                      <span class="text-info">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="text-info">13,000</h5>
                      <span class="text-info">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="text-info">35</h5>
                      <span class="text-info">PRODUCTS</span>
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

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
