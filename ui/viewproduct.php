<?php

include_once 'connectdb.php';
session_start();

include_once "header.php";

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0">Admin Dashboard</h1> -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page3</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">

          <div class="card card-info card-outline">
              <div class="card-header">
                <h5 class="m-0"><b>View Product</b></h5>
              </div>
              <div class="card-body">

              <!-- view image -->

              <?php

              $id=$_GET['id'];

              $select = $pdo->prepare("select * from tbl_product where pID = $id");
              $select->execute();

              while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                echo' 
                
                    
               <div class="row">

               <div class="col-md-6 ">

               <ul class="list-group">

               <center>

               <p class="list-group-item list-group-item-info"><b>Product Details</b></p>

               </center>

                   <li class="list-group-item">Barcode: <span class="badge badge-info float-right">'.$row->pID.'</span></li>
                   <li class="list-group-item">Product: <span class="badge badge-warning float-right">'.$row->Product.'</span></li>
                   <li class="list-group-item">Category: <span class="badge badge-success float-right">'.$row->Category.'</span></li>
                   <li class="list-group-item">Description: <span class="badge badge-primary float-right">'.$row->Description.'</span></li>
                   <li class="list-group-item">Stock: <span class="badge badge-danger float-right">'.$row->Stock.'</span></li>
                   <li class="list-group-item">PurchasePrice: <span class="badge badge-secondry float-right">'.$row->PurchasePrice.'</span></li>
                   <li class="list-group-item">ProductPrice: <span class="badge badge-dark float-right">'.$row->ProductPrice.'</span></li>
               </ul>
               

               </div>

               <div class="col-md-6">

               <ul class="list-group">

               <center>

               <p class="list-group-item list-group-item-info"><b>Product Image</b></p>

               </center>

                   <li class="list-group-item">New <span class="badge">12</span></li>
                   <li class="list-group-item">Deleted <span class="badge">5</span></li>
                   <li class="list-group-item">Warnings <span class="badge">3</span></li>
               </ul>

               </div>

               </div>
                
                ';



              }

              ?>


              </div>
            </div>
          
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php

include_once"footer.php";

?>