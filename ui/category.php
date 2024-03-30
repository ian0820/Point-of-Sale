<?php

include_once 'connectdb.php';
session_start();

include_once "header.php";


//save button
if (isset($_POST['btnsave'])) {

    $category = $_POST['txtcategory'];

        if(empty($category)){

            $_SESSION['status']="Field is empty";
            $_SESSION['status_code']="warning";

        }else{

            $insert=$pdo->prepare("insert into tbl_category (category) values (:cat)");

            $insert->bindParam(':cat',$category);

            if($insert->execute()){

                $_SESSION['status']="Category added successfully";
                $_SESSION['status_code']="success";
    
            }else{

                $_SESSION['status']="Category added failed";
                $_SESSION['status_code']="warning";
    
            }
        }

}

//update button
if (isset($_POST['btnupdate'])) {

    $category = $_POST['txtcategory'];
    $id = $_POST['txtcatid'];

        if(empty($category)){

            $_SESSION['status']="Field is empty";
            $_SESSION['status_code']="warning";

        }else{

            $update=$pdo->prepare("update tbl_category set category=:cat where catid=".$id);

            $update->bindParam(':cat',$category);

            if($update->execute()){

                $_SESSION['status']="Category update successfully";
                $_SESSION['status_code']="success";
    
            }else{

                $_SESSION['status']="Category update failed";
                $_SESSION['status_code']="warning";
    
            }
        }

}

//delete button
if(isset($_POST['btndelete'])){

    $delete=$pdo->prepare("delete from tbl_category where catid=".$_POST['btndelete']);

        if ($delete->execute()){

            $_SESSION['status']="Category deleted successfully";
                $_SESSION['status_code']="success";
            
        }else{

            $_SESSION['status']="Category deletion failed";
            $_SESSION['status_code']="warning";


        }


}else{



}

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><b>Category</b></h1>
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
      <div class="card card-warning card-outline">
              <div class="card-header">
                <h5 class="m-0">Category Form</h5>
              </div>
              

              <form action="" method="post">
              <div class="card-body">

<div class="row">

    <?php

        if(isset($_POST['btnedit'])){

            $select=$pdo->prepare("select * from tbl_category where catid = ".$_POST['btnedit']);

            $select->execute();

            if($select){

                $row = $select->fetch(PDO::FETCH_OBJ);

                echo'
                <div class="col-md-4">


                <div class="form-group">
                    <label for="exampleInputEmail1">Category</label>
                    
                    <input type="hidden" class="form-control" placeholder="Enter Category" value="'.$row->catid.'" name="txtcatid" >

                    <input type="text" class="form-control" placeholder="Enter Category" value="'.$row->category.'" name="txtcategory" >
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
                <label for="exampleInputEmail1">Category</label>
                <input type="text" class="form-control" placeholder="Enter Category" name="txtcategory" >
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-warning" name="btnsave"><b>Save</b></button>
            </div>

            </div>';
            
        }

    ?>




<div class="col-md-8">

  <table id="table_category" class="table table-hover">
    <thead>
      
        <tr>
          <td><b>No.</b></td>
          <td><b>Category</b></td>
          <td><b>Edit</b></td>
          <td><b>Delete</b></td>
        </tr>

    </thead>
        
        <?php

          $select = $pdo->prepare("select * from tbl_category order by catid ASC");
          $select->execute();

          while ($row = $select->fetch(PDO::FETCH_OBJ)) {

            echo'
            <tr>
              <td>'.$row->catid.'</td>
              <td>'.$row->category.'</td>

              <td>
              
                <button type="submit" class="btn btn-primary" value="'.$row->catid.'" name="btnedit">Edit</button>

              </td>

              <td>
              
              <button type="submit" class="btn btn-danger" value="'.$row->catid.'" name="btndelete">Delete</button>

              </td>

              </td>
            </tr>';

          }

        ?>

        <tbody>

          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

      </tbody>

      <tfoot>

        <tr>
          <td><b>No.</b></td>
          <td><b>Category</b></td>
          <td><b>Edit</b></td>
          <td><b>Delete</b></td>
        </tr>

      </tfoot>
      
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
            window.location.href = 'registration.php?id=' + userId;
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
