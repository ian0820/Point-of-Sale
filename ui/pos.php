<?php

include_once 'connectdb.php';
session_start();

include_once "header.php";

function fill_product($pdo){

$output=  ' ';
$select=$pdo->prepare("select * from tbl_product order by Product asc");

$select->execute();

$result=$select->fetchAll();

foreach($result as $row){

  $output.='<option value="'.$row["pID"].'">'.$row["Product"].'</option>';

}

return $output;  ;

}


$select=$pdo->prepare("select * from tbl_taxdis where taxdis_id =1");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

?>

<!-- CSS for table -->
<style type="text/css">

.tableFixHead{
overflow: scroll;
height: 520px;
}

.tableFixHead thead th{
position: sticky;
top: 0;
z-index: 1;
}

table {border-collapse: collapse; width: 100px;}
th, td {padding: 8px, 16px;}
th {background: #eee;}

</style>



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0"><b>Point of Sale</b></h1> -->
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
                <h5 class="m-0">POS</h5>
              </div>
              <div class="card-body">



              <div class="row">

            <div class="col-md-8"> 

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode" placeholder="Scan Barcode" id=txtbarcode_id></i></span>
                  </div>
                  <input type="text" class="form-control" placeholder="Scan Barcode">
                </div>

                  <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;">

                    <option>Select or Search product</option><?php echo fill_product($pdo);?>
  

                  </select>

                  <br>  

                  <!-- table heading -->
                  <div class="tableFixHead">

                  <table id="producttable" class="table table-bordered table-hover">
                  <thead>
                    
                      <tr>
                        <th><b>Product</b></th>
                        <th><b>Stock</b></th>
                        <th><b>Price</b></th>
                        <th><b>QTY</b></th>
                        <th><b>Total</b></th>
                        <th><b>Delete</b></th>
                      </tr>

                </thead>
                <tbody class="details" id="itemtable">

                  <tr data-widget="expandable-table" aria-expanded="false">
                      
                  
                  </tr>

                </tbody>



                  

                </table>

          </div>
</div>


            <div class="col-md-4"> 

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">SUBTOTAL: </span>
                  </div>
                  <input type="text" class="form-control" id="txtsubtotal_id" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>
                
                <br>

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">DISCOUNT: </span>
                  </div>
                  <input type="text" class="form-control" id="txtdiscount_p" value="<?php echo $row->discount; ?>">
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                </div>

                <br>

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">DISCOUNT: </span>
                  </div>
                  <input type="text" class="form-control" id="txtdiscount_n" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                <br>

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">SGST(%): </span>
                  </div>
                  <input type="text" class="form-control" id="txtsgst_id_p" value="<?php echo $row->sgst; ?>" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                </div>

                <br>

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">CGST(%): </span>
                  </div>
                  <input type="text" class="form-control" id="txtcgst_id_n" value="<?php echo $row->cgst; ?>" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                </div>

                <br>

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">SGST(₱): </span>
                  </div>
                  <input type="text" class="form-control" id="txtsgst_id_n" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                <br>

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">CGST(₱): </span>
                  </div>
                  <input type="text" class="form-control" id="txtcgst_id_n" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span> 
                  </div>
                </div> 

                <hr style="height: 2px; border-width: 0; color: black; background-color: black;">

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">TOTAL(₱): </span>
                  </div>
                  <input type="text" class="form-control form-control-lg total" id="txttotal" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                <hr style="height: 2px; border-width: 0; color: black; background-color: black;">

                <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="radio" name="r3" checked id="radioSuccess1">
                        <label for="radioSuccess1">
                          CASH
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" name="r3" id="radioSuccess2">
                        <label for="radioSuccess2">
                          CARD
                        </label>
                      </div>
                      <div class="icheck-danger d-inline">
                        <input type="radio" name="r3" id="radioSuccess3">
                        <label for="radioSuccess3">
                          CHECK
                        </label>
                      </div>
              
                <hr style="height: 2px; border-width: 0; color: black; background-color: black;">

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">DUE(₱): </span>
                  </div>
                  <input type="text" class="form-control" id="txtdue" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                <br>

                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">PAID(₱): </span>
                  </div>
                  <input type="text" class="form-control" id="txtpaid">
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                <hr style="height: 2px; border-width: 0; color: black; background-color: black;">

                <div class="card-footer">

                  <input type="button" value="Save Order" class="btn btn-primary"></input>

                </div>
            

            </div>

                  </div>



               </div>

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

<script>

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    var productarr=[];
    $(function(){
    $('#txtbarcode_id').on('change', function(){  

    var barcode = $("#txtbarcode_id").val();

    $.ajax({
    url: "getproduct.php",
    method: "get",
    dataType: "json",
    data: {id:barcode},
    success: function(data){

      //alert("pID");

      //console.log(data);

      if(Jquery.inArray(data["pID"], productarr)!== -1){

        var actualqty = parseInt($('#qty_id'+data["pID"]).val())+1;
        $('#qty_id'+data["pID"].val(actualqty));


        //check saleprice if the code is not working (edrian)
        var saleprice = parseInt(actualqty)*data["ProductPrice"];

        $('#saleprice_id'+data["pID"]).html(saleprice);
        $('#saleprice_idd'+data["pID"]).val(saleprice);

        $("#txtbarcode_id").val("");


      }else{

        //revised version

        addrow(data["pID"], data["Product"], data["ProductPrice"], data["Stock"], data["Barcode"]);

        productarr.push(data["pID"]);

        $("#txtbarcode_id").val("");

        function addrow(pID, Product, ProductPrice, Stock, Barcode){

          var tr='<tr>'+
          '<td style="text-align: left; vertical-align: middle; font-size: 17px;"><class="form-control product_c" name="product_arr[]" <span class="badge badge-dark">'+Product+'</span><input type="hidden" class="form-control pid" name="pid_arr[]" value="'+Product+'"><input type="hidden" class="form-control pID" name="pid_arr[]" value="'+pID+'"></td>'+

          '<td style="text-align: left; vertical-align: middle; font-size: 17px;"><span class="badge badge-primary stocklbl" name="stock_arr[]" id="stock_id'+pID+'">'+Stock+'</span><input type="hidden" class="form-control stock_c" name="stock_c_arr[]" id="stock_idd'+pID+'" value="'+Stock+'"></td>'+

          '<td style="text-align: left; vertical-align: middle; font-size: 17px;"><span class="badge badge-warning price" name="price_arr[]" id="price_id'+pID+'">'+ProductPrice+'</span><input type="hidden" class="form-control price_c" name="price_c_arr[]" id="price_idd'+pID+'" value="'+ProductPrice+'"></td>'+

          '<td><input type="text" class="form-control qty" name="quantity_arr[]" id="qty_id'+pID+'" value="'+1+'" size="1"></td>'+

          '<td style="text-align: left; vertical-align: middle; font-size: 17px;"><span class="badge badge-danger totalamt" name="netamt_arr[]" id="saleprice_id'+pID+'">'+ProductPrice+'</span><input type="hidden" class="form-control saleprice" name="saleprice_arr[]" id="saleprice_idd'+pID+'" value="'+ProductPrice+'"></td>'+

          '<td style="text-align: left; vertical-align: middle;"><center><name="remove" class="btnremove" data-id="'+pID+'"><span class="fas fa-trash" style="color:red"></span></center></td>'+

          '</tr>';

          $('.details').append(tr);


          //uncomment if this line is essential for this part
          // calculate();


        }//end f function addrow

      }


    } //end pf success function

  }) //end of ajax request

}) // end of onchange function

}); // end of main function



//for search ajax
var productarr=[];

$(function(){

    $('.select2').on('change', function(){  

    var productid = $(".select2").val();

    $.ajax({
    url: "getproduct.php",
    method: "get",
    dataType: "json",
    data: {id:productid},
    success: function(data){

      //alert("pID");

      //console.log(data);

      if(jQuery.inArray(data["pID"], productarr)!== -1){

        var actualqty = parseInt($('#qty_id'+data["pID"]).val())+1;
        $('#qty_id'+data["pID"].val(actualqty));


        //check saleprice if the code is not working (edrian)
        var saleprice = parseInt(actualqty)=data["ProductPrice"];

        $('#saleprice_id'+data["pID"]).html(saleprice);
        $('#saleprice_idd'+data["pID"]).val(saleprice);

        $("#taxtbarcode_id").val("");



      }else{

               //revised version

               addrow(data["pID"], data["Product"], data["ProductPrice"], data["Stock"], data["Barcode"]);

                productarr.push(data["pID"]);

                $("#txtbarcode_id").val("");

                function addrow(pID, Product, ProductPrice, Stock, Barcode){
                  

                  var tr='<tr>'+
                  '<td style="text-align: left; vertical-align: middle; font-size: 17px;"><class="form-control product_c" name="product_arr[]" <span class="badge badge-dark">'+Product+'</span><input type="hidden" class="form-control pid" name="pid_arr[]" value="'+Product+'"><input type="hidden" class="form-control pID" name="pid_arr[]" value="'+pID+'"></td>'+

                  '<td style="text-align: left; vertical-align: middle; font-size: 17px;"><span class="badge badge-primary stocklbl" name="stock_arr[]" id="stock_id'+pID+'">'+Stock+'</span><input type="hidden" class="form-control stock_c" name="stock_c_arr[]" id="stock_idd'+pID+'" value="'+Stock+'"></td>'+

                  '<td style="text-align: left; vertical-align: middle; font-size: 17px;"><span class="badge badge-warning price" name="price_arr[]" id="price_id'+pID+'">'+ProductPrice+'</span><input type="hidden" class="form-control price_c" name="price_c_arr[]" id="price_idd'+pID+'" value="'+ProductPrice+'"></td>'+

                  '<td><input type="text" class="form-control qty" name="quantity_arr[]" id="qty_id'+pID+'" value="'+1+'" size="1"></td>'+

                  '<td style="text-align: left; vertical-align: middle; font-size: 17px;"><span class="badge badge-danger totalamt" name="netamt_arr[]" id="saleprice_id'+pID+'">'+ProductPrice+'</span><input type="hidden" class="form-control saleprice" name="saleprice_arr[]" id="saleprice_idd'+pID+'" value="'+ProductPrice+'"></td>'+

                  '<td style="text-align: left; vertical-align: middle;"><center><name="remove" class="btnremove" data-id="'+pID+'"><span class="fas fa-trash" style="color:red"></span></center></td>'+

                  '</tr>';

                  $('.details').append(tr);

                  calculate();



}//end f function addrow

}


} //end pf success function

}) //end of ajax request

}) // end of onchange function

}); // end of main function


$("#itemtable").dalegate(".qty" ,"keyup change", function(){

var quantity = $(this);
var tr = $(this).parent().parent();

if((quantity.val()-0)>(tr.find(".stock_c").val()-0)){

  swal.fire("WARNING", "Sorry! This much quantity is not available", "warning");
  quantity.val(1);

  tr.find(".totalamt").text(quantity.val() * tr.find(".price").text());

  tr.find(".saleprice").value(quantity.val() * tr.find(".price").text());

}else{

  tr.find(".totalamt").text(quantity.val() * tr.find(".price").text());

  tr.find(".saleprice").value(quantity.val() * tr.find(".price").text());

}

calculate();

});


function calculate(){

  var subtotal=0;
  var discount=0;
  var sgst=0;
  var cgst=0;
  var total=0;
  var paid_amt=0;
  var due=0;

  $(".saleprice").each(function(){

    subtotal=subtotal+($(this).val()*1);

  });

$("#txtsubtotal_id").value(subtotal.toFixed(2));


sgst=parseFloat($("#txtsgst_id_p").val());

cgst=parseFloat($("#txtcgst_id_p").val());

discount=parseFloat($("#txtdiscount_p").val());

sgst=sgst/100;
sgst=sgst*subtotal;

cgst=cgst/100;
cgst=cgst*subtotal;

discount=discount/100;
discount=discount*subtotal;



$("#txtsgst_id_n").val(sgst.toFixed(2)); 

$("#txtcgst_id_n").val(cgst.toFixed(2)); 

$("#txtdiscount_n").val(discount.toFixed(2)); 

total=sgst+cgst+subtotal-discount;
due=total-paid_amt;

$("#txttotal").val(total.toFixed(2)); 

$("#txtdue").val(due.toFixed(2)); 



}
    

    
</script>
