<?php 

$get_ledger_amount = "select * from orders_delivery_assign where delivery_partner_id='$del_partner_id'";
$run_ledger_amount = mysqli_query($con,$get_ledger_amount);
$order_total = 0;
while($row_ledger_amount = mysqli_fetch_array($run_ledger_amount)){

  $del_invoice_no = $row_ledger_amount['invoice_no'];
}

$get_del_earnings = "select sum(delivery_charges) as total_earnings from orders_delivery_assign where delivery_partner_id='$del_partner_id'";
$run_del_earnings = mysqli_query($con,$get_del_earnings);
$row_del_earnings = mysqli_fetch_array($run_del_earnings);

$total_earnings = $row_del_earnings['total_earnings'];

$get_bonus = "select sum(bonus_amt) as total_bonus from del_bonus where delivery_partner_id='$del_partner_id'";
$run_bonus = mysqli_query($con,$get_bonus);
$row_bonus = mysqli_fetch_array($run_bonus);

$total_bonus = $row_bonus['total_bonus'];

$get_debits = "select sum(del_debit_amt) as total_debits from del_debits where delivery_partner_id='$del_partner_id'";
$run_debits = mysqli_query($con,$get_debits);
$row_debits = mysqli_fetch_array($run_debits);

$total_debits = $row_debits['total_debits'];

$get_settelments = "select sum(settlement_amt) as total_settelments from del_settlements where delivery_partner_id='$del_partner_id'";
        $run_settelments = mysqli_query($con,$get_settelments);
        $row_settelments = mysqli_fetch_array($run_settelments);

        $total_settelments = $row_settelments['total_settelments'];
        $order_total = 0;

        $get_order_count = "select * from orders_delivery_assign where delivery_partner_id='$del_partner_id'";
        $run_order_count = mysqli_query($con,$get_order_count);

        while ($row_orders_count=mysqli_fetch_array($run_order_count)) {
            $del_count_invoice_no = $row_orders_count['invoice_no'];

            $get_order_amount = "select sum(due_amount) as order_amount from customer_orders where invoice_no='$del_count_invoice_no' and order_status='Delivered' and product_status='Deliver'";
            $run_order_amount = mysqli_query($con,$get_order_amount);
            $row_order_amount = mysqli_fetch_array($run_order_amount);

            $order_amount = $row_order_amount['order_amount'];

            $get_payment_status = "select * from paytm where ORDERID='$del_count_invoice_no'";
            $run_payment_status = mysqli_query($con,$get_payment_status);
            $row_payment_status = mysqli_fetch_array($run_payment_status);

            $txn_status = $row_payment_status['STATUS'];

            $get_discount = "select * from customer_discounts where invoice_no='$del_count_invoice_no'";
            $run_discount = mysqli_query($con,$get_discount);
            $row_discount = mysqli_fetch_array($run_discount);

            $coupon_code = $row_discount['coupon_code'];
            $discount_type = $row_discount['discount_type'];
            $discount_amount = $row_discount['discount_amount'];

            $get_del_charges = "select * from order_charges where invoice_id='$del_count_invoice_no'";
            $run_del_charges = mysqli_query($con,$get_del_charges);
            $row_del_charges = mysqli_fetch_array($run_del_charges);

            $del_charges = $row_del_charges['del_charges'];

            if($txn_status==='SUCCESS'){
              $grand_total = 0;
          }else {

            if($discount_type==='amount'){

                $grand_total = ($order_amount+$del_charges)-$discount_amount;
                $order_total += $grand_total;

              }elseif ($discount_type==='product') {

                $get_off_pro = "select * from products where product_id='$discount_amount'";
                $run_off_pro = mysqli_query($con,$get_off_pro);
                $row_off_pro = mysqli_fetch_array($run_off_pro);

                $off_product_price = $row_off_pro['product_price'];

                    $grand_total = ($order_amount+$del_charges)+$off_product_price;
                    $order_total += $grand_total;
                
              }elseif (empty($discount_type)) {

                    $grand_total = $order_amount+$del_charges;
                    $order_total += $grand_total;
              }
        }
      }
?>
<div class="row shadow bg-white px-2 fixed-bottom">
  <div class="col-6 mt-1 text-center border bg-info">
    <small class="text-center mb-2">Pending AMT</small>
    <h5 class="mt-1">₹ <?php echo $order_total; ?></h5>
  </div>
  <div class="col-6 mt-1 text-center border bg-warning">
    <small class="text-center mb-2">Pending CHG</small>
    <h5 class="mt-1">₹ <?php echo ($total_earnings+$total_bonus)-$total_settelments; ?></h5>
  </div>
</div>
<?php 

$get_assgined_orders = "select * from orders_delivery_assign where delivery_partner_id='$del_partner_id' order by delivery_assign_updated_at desc";
$run_assgined_orders = mysqli_query($con,$get_assgined_orders);
while($row_assgined_orders=mysqli_fetch_array($run_assgined_orders)){

  $invoice_no = $row_assgined_orders['invoice_no'];
  $delivery_charges = $row_assgined_orders['delivery_charges'];

  $get_orders = "select * from customer_orders where invoice_no='$invoice_no'";

  $run_orders = mysqli_query($con,$get_orders);

  $order_count = mysqli_num_rows($run_orders);

  $row_orders = mysqli_fetch_array($run_orders);

  $c_id = $row_orders['customer_id'];

  $date = $row_orders['order_date'];

  $add_id = $row_orders['add_id'];

  $order_date = $row_orders['order_date'];

  $order_schedule = $row_orders['order_schedule'];

  $order_status = $row_orders['order_status'];

  $get_total = "SELECT sum(due_amount) AS total FROM customer_orders WHERE invoice_no='$invoice_no' and product_status='Deliver'";

  $run_total = mysqli_query($con,$get_total);

  $row_total = mysqli_fetch_array($run_total);

  $total = $row_total['total'];

  $get_customer = "select * from customers where customer_id='$c_id'";

  $run_customer = mysqli_query($con,$get_customer);

  $row_customer = mysqli_fetch_array($run_customer);

  $c_name = $row_customer['customer_name'];

  $c_contact = $row_customer['customer_contact'];

  $get_add = "select * from customer_address where add_id='$add_id'";

  $run_add = mysqli_query($con,$get_add);

  $row_add = mysqli_fetch_array($run_add);

  $customer_address = $row_add['customer_address'];

  $customer_phase = $row_add['customer_phase'];

  $customer_landmark = $row_add['customer_landmark'];

  $customer_city = $row_add['customer_city'];

  $get_txn_sta = "select * from paytm where ORDERID='$invoice_no'";
  $run_txn_sta = mysqli_query($con,$get_txn_sta);
  $row_txn_sta = mysqli_fetch_array($run_txn_sta);

  $STATUS = $row_txn_sta['STATUS'];

  $get_discount = "select * from customer_discounts where invoice_no='$invoice_no'";
  $run_discount = mysqli_query($con,$get_discount);
  $row_discount = mysqli_fetch_array($run_discount);

  $coupon_code = $row_discount['coupon_code'];
  $discount_type = $row_discount['discount_type'];
  $discount_amount = $row_discount['discount_amount'];

  $get_del_charges = "select * from order_charges where invoice_id='$invoice_no'";
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

  $checkarray = array('Cancelled','Delivered');

  if(!in_array($order_status,$checkarray)){

?>
<div class="col-md-12 col-lg-12 shadow p-2 rounded bg-white mt-2" style="font-family:Expletus Sans;">
  <div class="row">
    <div class="col-6">
      <h5><span class="badge badge-warning rounded text-white">You Earn : ₹ <?php echo $delivery_charges; ?></span></h5>
      <h5>ID-<?php echo $invoice_no; ?></h5>
      <h5 class="text-uppercase"><?php echo $c_name; ?></h5>
      <h5 class="text-uppercase"><?php echo $c_contact; ?></h5>
    </div>
    <?php 
    
    if(empty($STATUS)){

      ?>
        <div class="col-6 text-right"> 
          <span class="badge badge-pill badge-danger rounded"><h4 class="text-right mb-0"><small>TO PAY<?php echo $STATUS; ?></small> ₹ <?php echo $grand_total; ?>/-</h4></span> <br>
          <?php 
          
          $get_link = "select * from payment_links where invoice_id='$invoice_no'";
          $run_link = mysqli_query($con,$get_link);
          $count_links = mysqli_num_rows($run_link);

          if($count_links>0){
          ?>
          <a href="process_orders.php?order_link=<?php echo $invoice_no; ?>" class="btn btn-info btn-sm py-1 text-white mt-1"><i class="ti-link"></i> Click Here</a>
        <?php } ?>
        </div>
      <?php

    }else{

      if($STATUS==='SUCCESS'){

      ?>
    <div class="col-6 text-right"> <span class="badge badge-pill badge-success rounded"><h4 class="text-right mb-0">PAID</h4></span></div>

    <?php 
    
      }else{
    
    ?>

    <div class="col-6 text-right"> <span class="badge badge-pill badge-danger rounded"><h4 class="text-right mb-0"><small>TO PAY<?php echo $STATUS; ?></small> ₹ <?php echo $grand_total; ?>/-</h4></span></div>

      <?php
      }
    }
    
    ?>
  </div>
  <p>Address:- <?php echo $customer_address; ?>, 
              <?php echo $customer_phase; ?>, 
              <?php echo $customer_landmark; ?>, 
              <?php echo $customer_city; ?>.
  </p>
  <div class="row">
    <div class="col-6 pr-1">
        <button id="show_details" class="btn btn-primary text-white" data-toggle="modal" data-target="#KK<?php echo $invoice_no; ?>" title="view">
            View Details
        </button>

      <!-- Modal -->
      <div class="modal modal-black fade" id="KK<?php echo $invoice_no; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Order Id - <?php echo $invoice_no; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="tim-icons icon-simple-remove"></i>
                        </button>
                    </div>
                    <div class="modal-body my-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">ITEMS</th>
                                <th class="text-center">QTY</th>
                                <th class="text-right">PRICE</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        
                        $get_vendor = "select * from customer_orders where invoice_no='$invoice_no' group by client_id";
                        $run_vendor = mysqli_query($con,$get_vendor);
                        while ($row_vendor=mysqli_fetch_array($run_vendor)) {
                        $vendor_id = $row_vendor['client_id'];

                        $get_client = "select * from clients where client_id='$vendor_id'";

                        $run_client = mysqli_query($con,$get_client);

                        $row_client = mysqli_fetch_array($run_client);

                        $client_name = $row_client['client_shop'];

                        echo "<td colspan='5' class='text-center text-uppercase py-2'><h4 class='mb-0'>$client_name</h4></td>";

                        $get_pro_id = "select * from customer_orders where invoice_no='$invoice_no' and client_id='$vendor_id'";

                        $run_pro_id = mysqli_query($con,$get_pro_id);

                        $counter = 0;

                        while($row_pro_id = mysqli_fetch_array($run_pro_id)){

                        $pro_id = $row_pro_id['pro_id'];

                        $qty = $row_pro_id['qty'];

                        $sub_total = $row_pro_id['due_amount'];

                        $client_id = $row_pro_id['client_id'];

                        $pro_price = $sub_total/$qty;                                  

                        $pro_status = $row_pro_id['product_status'];

                        $get_pro = "select * from products where product_id='$pro_id'";

                        $run_pro = mysqli_query($con,$get_pro);

                        $row_pro = mysqli_fetch_array($run_pro);

                        $pro_title = $row_pro['product_title'];

                        $pro_img1 = $row_pro['product_img1'];

                        // $pro_price = $row_pro['product_price'];

                        $pro_desc = $row_pro['product_desc'];
                        
                        // $sub_total = $pro_price * $qty;

                        $get_min = "select * from admins";

                        $run_min = mysqli_query($con,$get_min);

                        $row_min = mysqli_fetch_array($run_min);

                        $min_price = $row_min['min_order'];

                        // $del_charges = $row_min['del_charges'];

                        
                        $get_del_charges = "select * from order_charges where invoice_id='$invoice_no'";
                        $run_del_charges = mysqli_query($con,$get_del_charges);
                        $row_del_charges = mysqli_fetch_array($run_del_charges);

                        $del_charges = $row_del_charges['del_charges'];

                        ?>
                            <tr>
                                <td class="text-center"><?php echo $pro_title; ?><br><?php echo $pro_desc; ?></td>
                                <td class="text-center"><?php echo $qty; ?> x ₹ <?php echo $pro_price; ?></td>
                                <td class="text-right">₹ <?php echo $sub_total; ?></td>
                            </tr>
                            <?php 
                            
                            if($discount_type==='product'){

                            $get_off_pro_det = "select * from products where product_id='$discount_amount'";
                            $run_off_pro_det = mysqli_query($con,$get_off_pro_det);
                            $row_off_pro_det = mysqli_fetch_array($run_off_pro_det);

                            $off_product_det_client_id = $row_off_pro_det['client_id'];
                            $off_product_det_product_img1 = $row_off_pro_det['product_img1'];
                            $off_product_det_product_title = $row_off_pro_det['product_title'];
                            $off_product_det_product_desc = $row_off_pro_det['product_desc'];
                            $off_product_det_product_price = $row_off_pro_det['product_price'];

                            $get_off_client = "select * from clients where client_id='$off_product_det_client_id'";
                            $run_off_client = mysqli_query($con,$get_off_client);
                            $row_off_client = mysqli_fetch_array($run_off_client);

                            $off_client_name = $row_off_client['client_name'];
                            
                            ?>
                            <tr>
                            <td colspan="6" class="py-2">
                                <h5 class="card-title text-center mb-0 text-uppercase" colspan="6">Offer Product Zone</h5>
                            </td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2"><?php echo $off_product_det_product_title; ?><br><?php echo $off_product_det_product_desc; ?></td>
                                <td class="text-right" colspan="2">₹ <?php echo $off_product_det_product_price; ?></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                    </div>
                </div>
            </div>
        <!-- Modal -->
    </div>
    <div class="col-6">
      <a href="process_orders.php?update_order=<?php echo $invoice_no; ?>&status=Delivered" onclick="return confirm('Are you sure?')" class="btn btn-success btn-md d-block">Delivered</a>
    </div>
  </div>
</div>
<?php } ?>
<?php } ?>