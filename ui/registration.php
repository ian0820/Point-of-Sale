<?php

include_once 'connectdb.php';
session_start();

if($_SESSION['user_email']=="" OR $_SESSION['role']=="User"){

  header('location:../index.php');

}

if($_SESSION['role']=="Admin"){

  include_once "header.php";

}else{

  include_once "headeruser.php";

}

error_reporting(0);

  $id=$_GET['id'];

    if(isset($id)){

    $delete=$pdo->prepare("delete from tbl_user where userid =".$id);

    if($delete->execute()){
      $_SESSION['status']="Account deleted successfully";
      $_SESSION['status_code']="success";

    }else{
      $_SESSION['status']="Account deletion failed";
      $_SESSION['status_code']="warning";

 }
}



if(isset($_POST['btnsave'])){

  $username =$_POST['txtname'];
  $user_email =$_POST['txtemail'];
  $age =$_POST['txtage'];
  $address =$_POST['txtaddress'];
  $contact =$_POST['txtcontact'];
  $password =$_POST['txtpassword'];
  $userrole =$_POST['txtselect_option'];

  if(isset($_POST['txtemail'])){

    $select = $pdo->prepare ("select user_email from tbl_user where user_email='$user_email'");

    $select->execute();

    if($select->rowCount()>0){

      $_SESSION['status'] = "Email already exists";
      $_SESSION['status_code'] = "warning";

      }else{
        $_SESSION['status'] = "New user has been added successfully";
        $_SESSION['status_code'] = "success";
      
      
        if($_POST['txtage']< 18) {
          $_SESSION['status'] = "You are underage";
          $_SESSION['status_code'] = "warning";

        }else{

          if($_POST['txtpassword']){

            $select = $pdo->prepare ("select password from tbl_user where password='$password'");
        
            $select->execute();
        
            if($select->rowCount()>0){
        
              $_SESSION['status'] = "Password already exists";
              $_SESSION['status_code'] = "warning";

    }else{

      $insert = $pdo->prepare ("insert into tbl_user (username,user_email,age,address,contact,password,role) values (:name, :email, :age, :address, :contact, :password, :role)");

      $insert->bindParam(':name', $username);
      $insert->bindParam(':email', $user_email);
      $insert->bindParam(':age', $age);
      $insert->bindParam(':address', $address);
      $insert->bindParam(':contact', $contact);
      $insert->bindParam(':password', $password);
      $insert->bindParam(':role', $userrole);
    
        if ($insert->execute()) {
            $_SESSION['status'] = "New user has been added successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Error in adding new user";
            $_SESSION['status_code'] = "error";
        }
      }
    }
  }

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
            <h1 class="m-0"><b>Registration</b></h1>
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

          <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Registration</h5>
              </div>
              <div class="card-body">

<div class="row">

<div class="col-md-4">

    <form action="" method="post">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" placeholder="Enter Name" name="txtname" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" placeholder="Enter email" name="txtemail" required>
                  </div>

                  <!-- added by edrian -->
                  <div class="form-group">
                    <label for="exampleInputAge1">Age</label>
                    <input type="number" class="form-control" placeholder="Enter Age" name="txtage" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputAddress1">Address</label>
                    <input type="text" class="form-control"  placeholder="Enter Address" name="txtaddress" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputContact1">Contact</label>
                    <input type="number" class="form-control"  placeholder="Enter Contact" name="txtcontact" required>
                  </div>
                  <!-- end -->

                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control"  placeholder="Password" name="txtpassword" required>
                  </div>
    
                <!-- select -->
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="txtselect_option">
                          <option value="" disabled selected>Select Role</option>
                          <option>Admin</option>
                          <option>User</option>
                        </select>
                    </div>


                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="btnsave"><b>Submit</b></button>
                </div>
    </form>

</div>




<div class="col-md-8">

  <table class="table table-hover">
    <thead>
      
        <tr>
          <td><b>NO.</b></td>
          <td><b>Name</b></td>
          <td><b>Email</b></td>
          <td><b>Age</b></td>
          <td><b>Address</b></td>
          <td><b>Contact</b></td>
          <td><b>Password</b></td>
          <td><b>Role</b></td>
          <td><b>Delete</b></td>
        </tr>

  
        
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
              <td>'.$row->password.'</td>
              <td>'.$row->role.'</td>
              <td>
              
                <a href="registration.php?id='.$row->userid.'" class="btn btn-danger delete-btn" data-id="'.$row->userid.'"><i class="fa fa-trash-alt"></i></a></td>

              </td>

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