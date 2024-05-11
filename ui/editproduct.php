<?php

include_once 'connectdb.php';
session_start();

include_once "header.php";

//Getting the Product ID from data base
$id = $_GET['id'];

$select = $pdo->prepare("select * from tbl_product where pID = $id");
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$id_db = $row['pID'];

$barcode_db = $row['Barcode'];
$product_db = $row['Product'];
$category_db = $row['Category'];
$description_db = $row['Description'];
$stock_db = $row['Stock'];
$purchaseprice_db = $row['PurchasePrice'];
$productprice_db = $row['ProductPrice'];
$image_db = $row['Image'];


if (isset($_POST['btneditproduct'])){

    // $barcode_txt=$_POST['txtbarcode'];
    $product_txt=$_POST['txtproductname'];
    $category_txt=$_POST['txtcategory'];
    $description_txt=$_POST['txtdescription'];
    $stock_txt=$_POST['txtstock'];
    $purchaseprice_txt=$_POST['txtprice'];
    $productprice_txt=$_POST['txtSalePrice'];

    //image
    $f_name = $_FILES['myfile']['name'];

    if(!empty($f_name)){

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

                 $f_newfile;

                 $update = $pdo->prepare("update tbl_product set Product=:Product, Category=:Category, Description=:Description, Stock=:Stock, PurchasePrice=:PurchasePrice, ProductPrice=:ProductPrice, Image=:Image where pID = $id");

                 $update->bindParam(':Product', $product_txt);
                 $update->bindParam(':Category', $category_txt);
                 $update->bindParam(':Description', $description_txt);
                 $update->bindParam(':Stock', $stock_txt);
                 $update->bindParam(':PurchasePrice', $purchaseprice_txt);
                 $update->bindParam(':ProductPrice', $productprice_txt);
                 $update->bindParam(':Image', $f_newfile);
             
                 if($update->execute()){
             
                     $_SESSION['status']="Product image is succesfully updated";
                     $_SESSION['status_code']="success";
             
                 }else{
             
                     $_SESSION['status']="Product image is failed to update";
                     $_SESSION['status_code']="error";
             
                 }

           }
          }
        }


    }else{

    $update = $pdo->prepare("update tbl_product set Product=:Product, Category=:Category, Description=:Description, Stock=:Stock, PurchasePrice=:PurchasePrice, ProductPrice=:ProductPrice, Image=:Image where pID = $id");

    $update->bindParam(':Product', $product_txt);
    $update->bindParam(':Category', $category_txt);
    $update->bindParam(':Description', $description_txt);
    $update->bindParam(':Stock', $stock_txt);
    $update->bindParam(':PurchasePrice', $purchaseprice_txt);
    $update->bindParam(':ProductPrice', $productprice_txt);
    $update->bindParam(':Image', $image_db);

    if($update->execute()){

        $_SESSION['status']="Product is succesfully updated";
        $_SESSION['status_code']="success";

    }else{

        $_SESSION['status']="Product is failed to update";
        $_SESSION['status_code']="error";

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
            <!-- <h1 class="m-0">Admin Dashboard</h1> -->
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

          <div class="card card-success card-outline">
              <div class="card-header">
                <h5 class="m-0"><b>Edit Product</b></h5>
              </div>

              <form action="" method="post" name = "formeditproduct" enctype="multipart/form-data">
              <div class="card-body">

<div class="row">

    <div class="col-md-6">

        <div class="form-group">
            <label>Barcode</label>
            <input type="text" class="form-control" value="<?php echo $barcode_db;?>" placeholder="Enter Barcode" name="txtbarcode" autocompete="off" disabled>
        </div>

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" class="form-control" value="<?php echo $product_db;?>" placeholder="Enter Product Name" name="txtproductname" required>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="txtcategory">
              <option value="" disabled selected>Select Category</option>

                  <?php

                  $select=$pdo->prepare("select * from tbl_category order by catid desc");
                  $select->execute();

                  while($row=$select->fetch(PDO::FETCH_ASSOC)){

                    extract($row);

                  ?>
                  
                  <option <?php if($row['category']==$category_db ){?> 
                    
                    selected="selected"

                    <?php }?>  ><?php echo $row['category'];?></option>

                  <?php

                  }

                  ?>

            </select>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4" required><?php echo $description_db;?></textarea>
        </div>

    </div>


<div class="col-md-6">

        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" min="1" step="any" class="form-control" value="<?php echo $stock_db;?>" placeholder="Enter Quantity" name="txtstock" required>
        </div>

        <div class="form-group">
            <label>Purchase Price</label>
            <input type="number" min="1" step="any" class="form-control" value="<?php echo $purchaseprice_db;?>" placeholder="Enter Purchase Price" name="txtprice" required>
        </div>

        <div class="form-group">
            <label>Product Price</label>
            <input type="number" min="1" step="any" class="form-control" value="<?php echo $productprice_db;?>" placeholder="Enter Product Price" name="txtSalePrice" required>
        </div>

        <!-- added category -->
        <div class="form-group">
            <label>Supplier</label>
            <select class="form-control" name="txtselect_option">
              <option value="" disabled selected>Select Supplier</option>

                  <?php

                  $select=$pdo->prepare("select * from tbl_catsupplier order by CategoryID desc");
                  $select->execute();

                  while($row=$select->fetch(PDO::FETCH_ASSOC)){

                    extract($row);

                  ?>
                  
                  <option><?php echo $row['CatSupplier'];?></option>

                  <?php

                  }

                  ?>

            </select>
        </div>

        <div class="form-group">
            <label>Product Image</label> <br>

            <td><image src="productimages/<?php echo $image_db;?>" class="img-rounded" width="50px" height="50px/"></td>

            <input type="file" class="input-group" name="myfile">
            <p>Upload image</p>
        </div>


</div>



</div>

      <div class="card-footer">
          <div class="text-center">
            <button type="submit" class="btn btn-success" name="btneditproduct"><b>Update Product</b></button>
          </div>
      </div>

              </form>

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