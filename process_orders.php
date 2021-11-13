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

  $get_order_stock = "select * from customer_orders where invoice_no='$update_order'";
  $run_order_stock = mysqli_query($con,$get_order_stock);
  while ($row_order_stock=mysqli_fetch_array($run_order_stock)) {
    $order_stock_pro = $row_order_stock['pro_id'];
    $order_stock_qty = $row_order_stock['qty'];

    $update_warehouse_stock = "update products set warehouse_stock=warehouse_stock-'$order_stock_qty' where product_id='$order_stock_pro'";
    $run_update_warehouse_stock = mysqli_query($con,$update_warehouse_stock);
  }


    echo "<script>alert('Status Updated')</script>";

    echo "<script>window.open('index.php?dashboard','_self')</script>";


}

if(isset($_GET['order_link'])){

  $order_link = $_GET['order_link'];

  $get_cust_id = "select * from customer_orders where invoice_no='$order_link'";
  $run_cust_id = mysqli_query($con,$get_cust_id);
  $row_cust_id = mysqli_fetch_array($run_cust_id);

  $check_link = mysqli_num_rows($run_cust_id);

  $customer_id = $row_cust_id['customer_id'];

  $get_customer = "select * from customers where customer_id='$customer_id'";
  $run_customer = mysqli_query($con,$get_customer);
  $row_customer = mysqli_fetch_array($run_customer);
  $c_contact = $row_customer['customer_contact'];

  $get_total = "SELECT sum(due_amount) AS total FROM customer_orders WHERE invoice_no='$order_link' and product_status='Deliver'";

  $run_total = mysqli_query($con,$get_total);

  $row_total = mysqli_fetch_array($run_total);

  $total = $row_total['total'];

  $get_discount = "select * from customer_discounts where invoice_no='$order_link'";
  $run_discount = mysqli_query($con,$get_discount);
  $row_discount = mysqli_fetch_array($run_discount);

  $coupon_code = $row_discount['coupon_code'];
  $discount_type = $row_discount['discount_type'];
  $discount_amount = $row_discount['discount_amount'];

  $get_del_charges = "select * from order_charges where invoice_id='$order_link'";
  $run_del_charges = mysqli_query($con,$get_del_charges);
  $row_del_charges = mysqli_fetch_array($run_del_charges);

  $del_charges = $row_del_charges['del_charges'];

  if($discount_type==='amount'){

    $grand_total = ($total+$del_charges)-$discount_amount;

  }elseif ($discount_type==='product') {

    $get_off_pro = "select * from products where product_id='$discount_amount'";
    $run_off_pro = mysqli_query($con,$get_off_pro);
    $row_off_pro = mysqli_fetch_array($run_off_pro);

    $off_product_price = $row_off_pro['product_price'];

    $grand_total = ($total+$del_charges)+$off_product_price;
    
  }elseif (empty($discount_type)) {

    $grand_total = $total+$del_charges;
    
  }

  $get_customer = "select * from customers where customer_id='$customer_id'";
  $run_customer = mysqli_query($con,$get_customer);
  $row_customer = mysqli_fetch_array($run_customer);
  $c_contact = $row_customer['customer_contact'];

  $get_link = "select * from payment_links where invoice_id='$order_link'";
  $run_link = mysqli_query($con,$get_link);
  $row_link = mysqli_fetch_array($run_link);
  
  $payment_link = $row_link['payment_link'];

  if($check_link>0){

    $text = "Below%20is%20the%20pay%20on%20delivery%20link%20for%20contactless%20delivery%20".$payment_link;
    // $text = "abc";
    //echo $url = "https://smsapi.engineeringtgr.com/send/?Mobile=9636286923&Password=DEZIRE&Message=".$m."&To=".$tel."&Key=parasnovxRI8SYDOwf5lbzkZc6LC0h"; 
    //  $url = "http://api.bulksmsplans.com/api/SendSMS?api_id=API31873059460&api_password=W3cy615F&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=91$c_contact&textmessage=$text";
    $url = "http://www.bulksmsplans.com/api/send_sms_multi?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=Transactional&sms_encoding=text&sender=VRNEAR&message=$text&number=+91$c_contact";
    // Initialize a CURL session. 
    $ch = curl_init();  
    
    // Return Page contents. 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    
    //grab URL and pass it to the variable. 
    curl_setopt($ch, CURLOPT_URL, $url);
    
    $result = curl_exec($ch);   

    echo "<script>alert('Link Sent')</script>";

    echo "<script>window.open('index.php?dashboard','_self')</script>";

  }else{
    echo "<script>alert('Link not found')</script>";

    echo "<script>window.open('index.php?dashboard','_self')</script>";

  }

}

?>