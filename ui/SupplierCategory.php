<?php

include_once 'connectdb.php';
session_start();

include_once "header.php";

//delete button
error_reporting(0);

$id=$_GET['id'];

if(isset($id)){

      $delete=$pdo->prepare("delete from tbl_catsupplier where CategoryID=".$id);
        
                if ($delete->execute()){
        
                    $_SESSION['status']="Supplier deleted successfully";
                        $_SESSION['status_code']="success";

                    }else{
        
                    $_SESSION['status']="Supplier deletion failed";
                    $_SESSION['status_code']="warning";

                    }
}else{

  $_SESSION['status']="Supplier deletion failed";
  $_SESSION['status_code']="warning";

}




//save button
if (isset($_POST['btnsave'])) {

    $supplier = $_POST['txtsupplier'];

    $select = $pdo->prepare ("select CatSupplier from tbl_catsupplier where CatSupplier='$supplier'");

    $select->execute();

        if ($select->rowCount()>0){

          $_SESSION['status']="Supplier already exist";
          $_SESSION['status_code']="warning";

        }else{

          $_SESSION['status']="Supplier added successfully";
          $_SESSION['status_code']="success";


        if(empty($supplier)){

            $_SESSION['status']="Field is empty";
            $_SESSION['status_code']="warning";

        }else{

            $insert=$pdo->prepare("insert into tbl_catsupplier (CatSupplier) values (:cat)");

            $insert->bindParam(':cat',$supplier);

            if($insert->execute()){

                $_SESSION['status']="Supplier added successfully";
                $_SESSION['status_code']="success";
    
            }else{

                $_SESSION['status']="Supplier added failed";
                $_SESSION['status_code']="warning";
    
            }
        }
}
}

//update button
if (isset($_POST['btnupdate'])) {

    $supplier = $_POST['txtsupplier'];
    $id = $_POST['txtcatid'];

        if(empty($supplier)){

            $_SESSION['status']="Field is empty";
            $_SESSION['status_code']="warning";

        }else{

            $update=$pdo->prepare("update tbl_catsupplier set CatSupplier=:cat where CategoryID=".$id);

            $update->bindParam(':cat',$supplier);

            if($update->execute()){

                $_SESSION['status']="Supplier update successfully";
                $_SESSION['status_code']="success";
    
            }else{

                $_SESSION['status']="Supplier update failed";
                $_SESSION['status_code']="warning";
    
            }
        }

}



?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><b>Supplier</b></h1>
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
      <div class="card card-success card-outline">
              <div class="card-header">
                <h5 class="m-0">Supplier Form</h5>
              </div>
              

              <form action="" method="post">
              <div class="card-body">

<div class="row">

    <?php

        if(isset($_POST['btnedit'])){

            $select=$pdo->prepare("select * from tbl_catsupplier where CategoryID = ".$_POST['btnedit']);

            $select->execute();

            if($select){

                $row = $select->fetch(PDO::FETCH_OBJ);

                echo'
                <div class="col-md-4">


                <div class="form-group">
                    <label for="exampleInputEmail1">Supplier</label>
                    
                    <input type="hidden" class="form-control" placeholder="Enter Category" value="'.$row->CategoryID.'" name="txtcatid" >

                    <input type="text" class="form-control" placeholder="Enter Supplier" value="'.$row->CatSupplier.'" name="txtsupplier" >
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info" name="btnupdate"><b>Update</b></button>
                </div>

                </div>';

            }

        }else{

            echo'
            <div class="col-md-4">


            <div class="form-group">
                <label for="exampleInputEmail1">Supplier</label>
                <input type="text" class="form-control" placeholder="Enter Supplier" name="txtsupplier" >
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success" name="btnsave"><b>Save</b></button>
            </div>

            </div>';
            
        }

    ?>




<div class="col-md-8">

  <table id="table_category" class="table table-hover">
    <thead>
      
        <tr>
          <td><b>No.</b></td>
          <td><b>Supplier</b></td>  
          <td><b>Edit</b></td>
          <td><b>Delete</b></td>
        </tr>

    </thead>

  
        
        <?php

          $select = $pdo->prepare("select * from tbl_catsupplier order by CategoryID ASC");
          $select->execute();

          while ($row = $select->fetch(PDO::FETCH_OBJ)) {

            echo'
            <tr>
            
              <td>'.$row->CategoryID.'</td>
              <td>'.$row->CatSupplier.'</td>

              <td>
              
                <button type="submit" class="btn btn-primary" value="'.$row->CategoryID.'" name="btnedit">Edit</button>

              </td>

              <td>
              
              <a href="SupplierCategory.php?id='.$row->CategoryID.'" class="btn btn-danger delete-btn" data-id="'.$row->CategoryID.'" name= "btndelete"><i class="fa fa-trash-alt"></i></a></td>


              </td>

              </td>

            </tr>';

          }

        ?>

        <tbody>

          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        </tbody>
      
  </table>


</div>


              </div>

              </form>

              </div>
            </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php

include_once "footer.php";

?>


<?php 

  if(isset($_SESSION['status']) && $_SESSION['status']!='')
  
  
  {

?>

<script>

    swal.fire({
      icon: '<?php echo $_SESSION['status_code'];?>',
      title: '<?php echo $_SESSION['status'];?>'
    });

    $(document).ready(function() {
      $('.delete-btn').click(function(e) {
      e.preventDefault();
      
      var userId = $(this).data('id');

      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d63032',
        confirmButtonText: 'Delete'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'SupplierCategory.php?id=' + userId;
        }
      });
      });
      });

</script>



<?php

  unset($_SESSION['status']);

  }

?>

<script>

$(document).ready( function () {
    $('#table_category').DataTable();
} );

</script>