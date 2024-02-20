<?php

  include_once "ui/connectdb.php";
  session_start();

  if(isset($_POST['btn_login'])){

    $userInput = $_POST['txt_email'];
    $password = $_POST['txt_password'];
    
    $select = $pdo->prepare("SELECT * FROM tbl_user WHERE (user_email=:username OR username=:username) AND password=:password");

    $select->bindParam(':username', $userInput);
    $select->bindParam(':password', $password);
    $select->execute();
    

    $select = $pdo->prepare("SELECT * FROM tbl_user where user_email='$userInput' AND password='$password'"); 
    $select->execute();

    $row = $select->fetch(PDO::FETCH_ASSOC);

    if(is_array($row)){

      if($row['user_email'] == $userInput AND $row['password'] == $password AND $row['role']=="Admin"){

        $_SESSION['status']="Admin successfully logged in";
        $_SESSION['status_code']="success";
        
        header ('refresh: 2; ui/dashboard.php');

        $_SESSION['userid']=$row['userid'];
        $_SESSION['username']=$row['username'];
        $_SESSION['user_email']=$row['user_email'];
        $_SESSION['role']=$row['role'];

      }else if($row['user_email']==$userInput AND $row['password']==$password AND $row['role']=="User"){

        $_SESSION['status']="Log in successfuly";
        $_SESSION['status_code']="success";

        header ('refresh: 2; ui/user.php');

        $_SESSION['userid']=$row['userid'];
        $_SESSION['username']=$row['username'];
        $_SESSION['user_email']=$row['user_email'];
        $_SESSION['role']=$row['role'];

      }
        
    }else{

      $_SESSION['status']="Invalid Email or Password";
      $_SESSION['status_code']="warning";

    }

  }


?>


<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log In</title>


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

</head>

<body class="hold-transition login-page">
<div class="login-box">

  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.php" class="h1"><b>POS</b>byEd</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"> <b>Let's get started!</b><br>Log in to join your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">

          <input type="text" class="form-control" placeholder="Email or Username" name="txt_email" required>

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
        <div class="row">
        <div class="col-8">
          <div class="icheck-primary">
             <a href="register.php">Don't have an account? Sign up here!</a>
          </div>
        </div>



          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="btn_login">Log in</button>
          </div>

          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        
      </p>
    </div>

    <!-- /.card-body -->
  </div>

  <!-- /.card -->

</div>

</body>
</html>

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


<?php 

  if(isset($_SESSION['status']) && $_SESSION['status']!='')
  
  
  {

?>

  <script>

      Swal.fire({
        position: "middle",
        icon: "success",
        title: "Your work has been saved",
        timer: 1500
      });

      swal.fire({
          icon: '<?php echo $_SESSION['status_code'];?>',
          title: '<?php echo $_SESSION['status'];?>'
        });

  </script>


<?php

  unset($_SESSION['status']);

  }

?>
