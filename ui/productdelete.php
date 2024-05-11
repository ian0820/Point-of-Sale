<?php
include_once'connectdb.php';

$id= $_POST['pidd'];
$sql= "delete from tbl_product where pID =$id";

$delete=$pdo->prepare($sql);
 if($delete->execute()) {

 }else{

    echo"Error in deleting product";

 }


?>