<?php

include_once 'connectdb.php';
session_start();

include_once "header.php";


if (isset($_POST['btnsave'])){

  $barcode=$_POST['txtbarcode'];
  $product=$_POST['txtproductname'];
  $category=$_POST['txtselect_option'];
  $barcode=$_POST['txtbarcode'];
  $description=$_POST['txtdescription'];
  $stock=$_POST['txtstock'];
  $purchaseprice=$_POST['txtprice'];
  $productprice=$_POST['txtSalePrice'];


  $f_name = $_FILES['myfile']['name'];
       $f_tmp = $_FILES['myfile']['tmp_name'];

       $f_size = $_FILES['myfile']['size'];

       $f_extension = explode('.',  $f_name);
       $f_extension = strtolower(end($f_extension));

       echo $f_newfile = uniqid().'.'. $f_extension;

       $store = "productimages/".$f_newfile;

            if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif'){

                if ($f_size>=5000000){

                    $_SESSION['status']="Max file must be 5MB";
                    $_SESSION['status_code']="warning";

            }else{

                if (move_uploaded_file($f_tmp, $store)){

                  $productimage=$f_newfile;

                  if(empty($barcode)){

                    $insert =$pdo->prepare("insert into tbl_product (Product, Category, Description, Stock, PurchasePrice, ProductPrice, Image) values (:Product, :Category, :Description, :Stock, :PurchasePrice, :ProductPrice, :img)");

                    // $insert->bindParam(':Barcode', $barcode);

                    $insert->bindParam(':Product', $product);
                    $insert->bindParam(':Category', $category);
                    $insert->bindParam(':Description', $description);
                    $insert->bindParam(':Stock', $stock);
                    $insert->bindParam(':PurchasePrice', $purchaseprice);
                    $insert->bindParam(':ProductPrice', $productprice);
                    $insert->bindParam(':img', $productimage);
                    
                    
                    $insert->execute();

                    $pid=$pdo->lastInsertId();

                    date_default_timezone_set("Asia/Manila");
                    $newbarcode=$pid.date('his');

                    $update=$pdo->prepare("update tbl_product SET barcode='$newbarcode' where pid='".$pid."'");

                    if($update->execute()){
                      
                      $_SESSION['status']="Product is succesfully added";
                      $_SESSION['status_code']="success";

                    }else{

                      $_SESSION['status']="Product insertion failed";
                      $_SESSION['status_code']="error";

                    }

                  }else{

                     $insert =$pdo->prepare("insert into tbl_product (Barcode, Product, Category, Description, Stock, PurchasePrice, ProductPrice, Image) values (:Barcode, :Product, :Category, :Description, :Stock, :PurchasePrice, :ProductPrice, :img)");

                     $insert->bindParam(':Barcode', $barcode);
                     $insert->bindParam(':Product', $product);
                     $insert->bindParam(':Category', $category);
                     $insert->bindParam(':Description', $description);
                     $insert->bindParam(':Stock', $stock);
                     $insert->bindParam(':PurchasePrice', $purchaseprice);
                     $insert->bindParam(':ProductPrice', $productprice);
                     $insert->bindParam(':img', $productimage);
                     
                     
                     if($insert->execute()){

                      $_SESSION['status']="Product is succesfully added";
                      $_SESSION['status_code']="success";

                     }else{

                      $_SESSION['status']="Product insertion failed";
                      $_SESSION['status_code']="error";

                     }

                  }

                }

            }

        }else{

            $_SESSION['status']="Only JPEG, PNG, & GIF files are supported";
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
            <h1 class="m-0"><b>Add Product</b></h1>
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
                <h5 class="m-0">Products</h5>
              </div>
              
              <form action="" method="post" enctype="multipart/form-data">
              <div class="card-body">

<div class="row">

    <div class="col-md-6">

        <div class="form-group">
            <label>Barcode</label>
            <input type="text" class="form-control" placeholder="Enter Barcode" name="txtbarcode">
        </div>

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" class="form-control" placeholder="Enter Product Name" name="txtproductname" required>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="txtselect_option">
              <option value="" disabled selected>Select Category</option>

                  <?php

                  $select=$pdo->prepare("select * from tbl_category order by catid desc");
                  $select->execute();

                  while($row=$select->fetch(PDO::FETCH_ASSOC)){

                    extract($row);

                  ?>
                  
                  <option><?php echo $row['category'];?></option>

                  <?php

                  }

                  ?>

            </select>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4" required></textarea>
        </div>

    </div>


<div class="col-md-6">

        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" min="1" step="any" class="form-control" placeholder="Enter Quantity" name="txtstock" required>
        </div>

        <div class="form-group">
            <label>Purchase Price</label>
            <input type="number" min="1" step="any" class="form-control" placeholder="Enter Purchase Price" name="txtprice" required>
        </div>

        <div class="form-group">
            <label>Product Price</label>
            <input type="number" min="1" step="any" class="form-control" placeholder="Enter Product Price" name="txtSalePrice" required>
        </div>

        <div class="form-group">
            <label>Product Image</label>
            <input type="file" class="input-group" name="myfile" required>
            <p>Upload image</p>
        </div>


</div>



</div>

      <div class="card-footer">
          <div class="text-center">
            <button type="submit" class="btn btn-primary" name="btnsave"><b>Save Product</b></button>
          </div>
      </div>

              </form>

            </div>
          
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
</div>

<?php

include_once 'footer.php';

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
