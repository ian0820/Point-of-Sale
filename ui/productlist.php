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

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li> -->
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

          <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0"><b>Product List</b></h5>
              </div>
              <div class="card-body">
                
              <table class="table table-hover" id="table_product">
    <thead>
      
        <tr>
          <td><b>Barcode</b></td>
          <td><b>Product</b></td>
          <td><b>category</b></td>
          <td><b>Description</b></td>
          <td><b>Stock</b></td>
          <td><b>Purchase Price</b></td>
          <td><b>Product Price</b></td>
          <td><b>Image</b></td>
          <td><b>Action Buttons</b></td>

        </tr>

  
        
        <?php
          $select = $pdo->prepare("select * from tbl_product order by pID ASC");
          $select->execute();

          while ($row = $select->fetch(PDO::FETCH_OBJ)) {

            echo'
            <tr>
              <td>'.$row->Barcode.'</td>
              <td>'.$row->Product.'</td>
              <td>'.$row->Category.'</td>
              <td>'.$row->Description.'</td>
              <td>'.$row->Stock.'</td>
              <td>'.$row->PurchasePrice.'</td>
              <td>'.$row->ProductPrice.'</td>

              <td><image src="productimages/'.$row->Image.'" class="img-rounded" width="40px" height="40px/"></td>

              <td>

                <div class="btn-group">

                <a href="printbarcode.php?id"='.$row->pID.'" class="btn btn-primary btn-xs role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="Print Barcode"></span></a>  

                <a href="viewproduct.php?id"='.$row->pID.'" class="btn btn-warning btn-xs role="button"><span class="fa fa-eye"  style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>  

                <a href="editproduct.php?id"='.$row->pID.'" class="btn btn-success btn-xs role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>  

                <button id='.$row->pID.'" class="btn btn-danger btn-xs"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>

                </div>

              </td>

            </tr>';

          }

          // <button onclick="Delete('.$row->userid.')" type="button" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>


        ?>
        <tbody>

          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

      </tbody>
      
    </thead>
  </table>
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

<script>

$(document).ready( function () {
    $('#table_product').DataTable();
} );

</script>

<script>

$(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip();
} );

</script>
