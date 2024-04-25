<?php

include_once 'connectdb.php';
session_start();

include_once "header.php";

//update button
if (isset($_POST['btnupdate'])) {

    $userid = $_POST['txtuserid'];
    $username = $_POST['txtusername'];
    $user_email = $_POST['txtemail'];
    $age = $_POST['txtage'];
    $address = $_POST['txtaddress'];
    $contact = $_POST['txtcontact'];
    $role = $_POST['txtrole'];

    $update = $pdo->prepare("UPDATE tbl_user SET userid = ?username = ?, user_email = ?, age = ?, address = ?, contact = ?, role = ? WHERE userid = ?");
    $success = $update->execute([$username, $user_email, $age, $address, $contact, $role, $userid]);

            if($update->execute()){

                $_SESSION['status']="Category update successfully";
                $_SESSION['status_code']="success";
    
            }else{

                $_SESSION['status']="Category update failed";
                $_SESSION['status_code']="warning";
    
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
            <h1 class="m-0"><b>Edit Information</b></h1>
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
                <h5 class="m-0">Edit Form</h5>
              </div>
              

              <form action="" method="post">
              <div class="card-body">

<div class="row">

    <?php

        if(isset($_POST['btnedit'])){

            $select=$pdo->prepare("select * from tbl_user where userid= '$userid'");

            $select->execute();

            if($select){

                $row = $select->fetch(PDO::FETCH_OBJ);

                echo'
                <div class="col-md-4">
    
    
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" placeholder="Enter Category" name="txtusername" >
                </div>
    
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning" name="btnsave"><b>Save</b></button>
                </div>
    
                </div>';

            }

        }else{

            $select=$pdo->prepare("select * from tbl_user set username = username, user_email = user_email, age = age, address = address, contact = contact, role = role WHERE userid = ?");

            $row = $select->fetch(PDO::FETCH_OBJ);

                echo'
                <div class="col-md-4">


                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    
                    <input type="hidden" class="form-control" placeholder="Enter Category" value="'.$row->userid.'" name="txtuserid" >

                    <input type="text" class="form-control" placeholder="Enter Username" value="'.$row->username.'" name="txtusername" >
                </div>

                <div class="form-group">
                <label for="exampleInputEmail1">Email</label>

                <input type="text" class="form-control" placeholder="Enter Username" value="'.$row->user_email.'" name="txtemail" >

                </div>

                <div class="form-group">
                <label for="exampleInputEmail1">Age</label>

                <input type="text" class="form-control" placeholder="Enter Username" value="'.$row->age.'" name="txtage" >

                </div>

                <div class="form-group">
                <label for="exampleInputEmail1">Address</label>

                <input type="text" class="form-control" placeholder="Enter Username" value="'.$row->address.'" name="txtaddress" >

                </div>

                <div class="form-group">
                <label for="exampleInputEmail1">Contact</label>

                <input type="text" class="form-control" placeholder="Enter Username" value="'.$row->contact.'" name="txtcontact" >

                </div>

                <div class="form-group">
                <label>Role</label>
                <select class="form-control" name="txtrole">
                  <option value="" disabled selected>Select Role</option>
                  <option>Admin</option>
                  <option>User</option>
                </select>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info" name="btnupdate"><b>Update</b></button>
                </div>

                </div>';
            
        }

    ?>




<div class="col-md-8">

  <table id="table_category" class="table table-hover">
    <thead>
      
        <tr>
          <td><b>No.</b></td>
          <td><b>Name</b></td>  
          <td><b>Email</b></td>
          <td><b>Age</b></td>
          <td><b>Address</b></td>
          <td><b>Contact</b></td>
          <td><b>Role</b></td>
        </tr>

    </thead>

  
        
        <?php

          $select = $pdo->prepare("select * from tbl_user order by userid ASC");
          $select->execute();

          while ($row = $select->fetch(PDO::FETCH_OBJ)) {

            echo'
            <tr>
              <td>'.$row->userid.'</td>
              <td>'.$row->username.'</td>
              <td>'.$row->user_email.'</td>
              <td>'.$row->age.'</td>
              <td>'.$row->address.'</td>
              <td>'.$row->contact.'</td>
              <td>'.$row->role.'</td>
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
            window.location.href = 'editregistration.php?id=' + userId;
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