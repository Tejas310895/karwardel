<?php 

include("includes/db.php");

if(isset($_GET['update_order'])){

  date_default_timezone_set('Asia/Kolkata');
  $today = date("Y-m-d H:i:s");

  $update_order = $_GET['update_order'];

  $status = $_GET['status'];

  $update_status_del = "UPDATE customer_orders SET order_status='$status',del_date='$today' WHERE invoice_no='$update_order'";

  $run_status_del = mysqli_query($con,$update_status_del);

  $update_discount = "UPDATE customer_discounts set discount_date='$today' where invoice_no='$update_order'";
  $run_update_discount = mysqli_query($con,$update_discount);

  $update_charges = "UPDATE order_charges set updated_date='$today' where invoice_id='$update_order'";
  $run_update_charges = mysqli_query($con,$update_charges);


    echo "<script>alert('Status Updated')</script>";

    echo "<script>window.open('index?dashboard','_self')</script>";


}

?>