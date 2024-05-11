<?php

include_once 'connectdb.php';
session_start();

include_once "header.php";

//delete button
// error_reporting(0);

// $id=$_GET['id'];

// if(isset($id)){

//     $delete=$pdo->prepare("delete from tbl_category where catid=".$id);
      
//               if ($delete->execute()){
      
//                   $_SESSION['status']="Category deleted successfully";
//                       $_SESSION['status_code']="success";

//                   }else{
      
//                   $_SESSION['status']="Category deletion failed";
//                   $_SESSION['status_code']="warning";

//                   }
// }else{

//   $_SESSION['status']="Category deletion failed";
//   $_SESSION['status_code']="warning";

// }  



//save button
if (isset($_POST['btnsave'])) {

    $sgst = $_POST['txtsgst'];
    $cgst = $_POST['txtcgst'];
    $discount = $_POST['txtdiscount'];

        if(empty($sgst)){

            $_SESSION['status']="Field is empty";
            $_SESSION['status_code']="warning";

}else{

    $insert=$pdo->prepare("insert into tbl_taxdis (sgst, cgst, discount) values (:sgst, :cgst, :discount)");

      $insert->bindParam(':sgst',$sgst);
      $insert->bindParam(':cgst',$cgst);
      $insert->bindParam(':discount',$discount);

        if($insert->execute()){

            $_SESSION['status']="Tax & discount added successfully";
            $_SESSION['status_code']="success";
    
            }else{

                $_SESSION['status']="Tax & discount failed to add";
                $_SESSION['status_code']="warning";
    
            }
        }
}


//update button
if (isset($_POST['btnupdate'])) {

    $sgst = $_POST['txtsgst'];
    $cgst = $_POST['txtcgst'];
    $discount = $_POST['txtdiscount'];


    $id = $_POST['txtid'];

        if(empty($sgst)){

            $_SESSION['status']="Field is empty";
            $_SESSION['status_code']="warning";

        }else{

            $update=$pdo->prepare("update tbl_taxdis set sgst=:sgst, cgst=:cgst, discount=:dis where taxdis_id=".$id);

            $update->bindParam(':sgst',$sgst);
            $update->bindParam(':cgst',$cgst);
            $update->bindParam(':dis',$discount);
      

            if($update->execute()){

                $_SESSION['status']="Tax & discount updated successfully";
                $_SESSION['status_code']="success";
    
            }else{

                $_SESSION['status']="tax 7 discount update failed";
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
            <h1 class="m-0"><b>Tax & Discount</b></h1>
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
                <h5 class="m-0">Tax Form</h5>
              </div>
              

              <form action="" method="post">
              <div class="card-body">

<div class="row">

    <?php

        if(isset($_POST['btnedit'])){

            $select=$pdo->prepare("select * from tbl_taxdis where taxdis_id = ".$_POST['btnedit']);

            $select->execute();

            if($select){

                $row = $select->fetch(PDO::FETCH_OBJ);

                echo'
                <div class="col-md-4">


                <div class="form-group">

                    
                    <input type="hidden" class="form-control" placeholder="Enter Category" value="'.$row->taxdis_id.'" name="txtid" >

                    <div class="form-group">
                    <label for="exampleInputEmail1">SGST(%)</label>
                    <input type="text" class="form-control" placeholder="SGST" value="'.$row->sgst.'" name="txtsgst" >
                </div>
    
                <div class="form-group">
                    <label for="exampleInputEmail1">CGST(%)</label>
                    <input type="text" class="form-control" placeholder="CGST" value="'.$row->cgst.'"name="txtcgst" >
                </div>
    
                <div class="form-group">
                    <label for="exampleInputEmail1">Discount(%)</label>
                    <input type="text" class="form-control" placeholder="Enter Discound" value="'.$row->discount.'" name="txtdiscount" >
                </div>

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
                <label for="exampleInputEmail1">SGST(%)</label>
                <input type="text" class="form-control" placeholder="SGST" name="txtsgst" >
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">CGST(%)</label>
                <input type="text" class="form-control" placeholder="CGST" name="txtcgst" >
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Discount(%)</label>
                <input type="text" class="form-control" placeholder="Enter Discound" name="txtdiscount" >
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-warning" name="btnsave"><b>Save</b></button>
            </div>

            </div>';
            
        }

    ?>




<div class="col-md-8">

  <table id="table_tax" class="table table-striped">
    <thead>
      
        <tr>
          <td><b>No.</b></td>
          <td><b>SGST</b></td>  
          <td><b>CGST</b></td>  
          <td><b>Discount</b></td>  
          <td><b>Edit</b></td>
        </tr>

    </thead>

  
        
        <?php

          $select = $pdo->prepare("select * from tbl_taxdis order by taxdis_id ASC");
          $select->execute();

          while ($row = $select->fetch(PDO::FETCH_OBJ)) {

            echo'
            <tr>
              <td>'.$row->taxdis_id.'</td>
              <td>'.$row->sgst.'</td>
              <td>'.$row->cgst.'</td>
              <td>'.$row->discount.'</td>

              <td>
              
                <button type="submit" class="btn btn-primary" value="'.$row->taxdis_id.'" name="btnedit">Edit</button>

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
            window.location.href = 'category.php?id=' + userId;
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
    $('#table_tax').DataTable();
} );

</script>