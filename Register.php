<?php

include_once 'ui/connectdb.php';
session_start();

//registration
if(isset($_POST['btn_register'])){

    $Name = $_POST['txt_name'];
    $email = $_POST['txt_email'];
    $age = $_POST['txt_age'];
    $address = $_POST['txt_address'];
    $password = $_POST['txt_password'];
    $Gender = $_POST['txtselect_option'];

    //checking email
    if(isset($_POST['txt_email'])){

      $select = $pdo->prepare ("select email from register_tbl where email='$email'");
  
      $select->execute();
  
      if($select->rowCount()>0){
  
        $_SESSION['status'] = "Email already exists";
        $_SESSION['status_code'] = "warning";
  
        }else{
          $_SESSION['status'] = "New user has been added successfully";
          $_SESSION['status_code'] = "success";

          //password checking
          if($_POST['txt_password']){

            $select = $pdo->prepare ("select password from register_tbl where password='$password'");
        
            $select->execute();
        
      }if($select->rowCount()>0){
        
        $_SESSION['status_code'] = "warning";
        $_SESSION['status'] = "Password already exists";

    }else{          

      //Adding credentials to the database
      $insert = $pdo->prepare("INSERT into register_tbl (Name, email, Age, Address, password, Gender) VALUES (:Name, :email, :Age, :Address, :password, :Gender)");

      $insert->bindParam(':Name', $Name);
      $insert->bindParam(':email', $email);
      $insert->bindParam(':Age', $age);
      $insert->bindParam(':Address', $address);
      $insert->bindParam(':password', $password);
      $insert->bindParam(':Gender', $Gender);

    if ($insert->execute()) {

        $_SESSION['status'] = "New user has been added successfully";
        $_SESSION['status_code'] = "success";

          while($_SESSION['Name'] ==''){

            header('location:index.php');
          
          }
    } else  {

        $_SESSION['status'] = "Error in adding new user";
        $_SESSION['status_code'] = "error";

    }
}
}
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edrian Prelim</title>

 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="Register.php" class="h1"><b>Prelim</b>Edrian</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="" method="post">

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="txt_name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="txt_email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Age" name="txt_age" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Address" name="txt_address" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="txt_password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <select class="form-control" name="txtselect_option" required>
            <option value="" disabled selected>Select Gender</option>
            <option>Male</option>
            <option>Female</option>
          </select>
      </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">

            </div>
          </div>

          <!-- /.col -->
          <div class="col-8">
            <div class="icheck-primary">
              <a href="index.php">Already have an account?</a>
            </div>
          </div>

          <div class="col-4"> 
            <button type="submit" class="btn btn-primary btn-block" name="btn_register">Register</button>
          </div>

          <!-- /.col -->
        </div>
      </form>

    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<?php 

  if(isset($_SESSION['status']) && $_SESSION['status']!='')
  
  
  {

?>

  <script>

    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 5000,
      });

      swal.fire({
          icon: '<?php echo $_SESSION['status_code'];?>',
          title: '<?php echo $_SESSION['status'];?>'
        });
      });

  </script>


<?php

  unset($_SESSION['status']);

  }

?>

</body>
</html>
