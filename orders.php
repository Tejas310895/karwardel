<?php 

$del_partner_id = $_COOKIE['wrn_del_user'];

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

$get_settelments = "select sum(settlement_amt) as total_settelments from del_settlements where delivery_partner_id='$del_partner_id' and settlement_status='active'";
$run_settelments = mysqli_query($con,$get_settelments);
$row_settelments = mysqli_fetch_array($run_settelments);

$total_settelments = $row_settelments['total_settelments'];

$get_salary = "select sum(salary_amt) as total_salary from del_payroll where delivery_partner_id='$del_partner_id'";
$run_salary = mysqli_query($con,$get_salary);
$row_salary = mysqli_fetch_array($run_salary);

$total_salary = $row_salary['total_salary'];

$order_total = 0;

$get_order_count = "select * from orders_delivery_assign where delivery_partner_id='$del_partner_id'";
$run_order_count = mysqli_query($con,$get_order_count);

        while ($row_orders_count=mysqli_fetch_array($run_order_count)) {
            $del_count_invoice_no = $row_orders_count['invoice_no'];

            $get_order_status = "select * from customer_orders where invoice_no='$del_count_invoice_no'";
            $run_order_status = mysqli_query($con,$get_order_status);
            $row_order_status = mysqli_fetch_array($run_order_status);

            $order_status_bal = $row_order_status['order_status'];

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

            if($order_status_bal==='Delivered'){
              $del_charges = $row_del_charges['del_charges'];
            }else{
              $del_charges = 0;
            }

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
    <h6 class="mt-1" style="margin-bottom:3px;margin-top:0px!important;">₹ <?php echo $order_total-$total_settelments; ?></h6>
  </div>
  <div class="col-6 mt-1 text-center border bg-warning">
    <small class="text-center mb-2">Pending CHG</small>
    <h6 class="mt-1" style="margin-bottom:3px;margin-top:0px!important;">₹ <?php echo ($total_earnings+$total_bonus)-$total_salary; ?></h6>
  </div>
</div>
<div class="row">
  <?php for ($x = 0; $x <= 10; $x++) {?>
  <div class="col-lg-12 col-md-6">
    <div class="card card-chart p-2">
      <div class="row">
        <div class="col-6">
          <h6 class="badge badge-warning p-1">Earning ₹10</h6>
          <h6 class="card-title">Name : Tejas Shirsat</h6>
          <h6 class="card-title">Mobile : 9867765397</h6>
        </div>
        <div class="col-6 text-right">
          <button class="btn btn-primary mb-1 mt-0 py-1">TAKE ₹100</button>
          <button type="button" class="btn btn-info py-1 mt-0">Click Here</button>
        </div>
      </div>
      <h6 class="card-title">Address : Demo address demo address demo address.</h6>
      <button type="button" class="btn btn-info text-left">View</button>
      <button type="button" class="btn btn-success pull-right">Delivered</button>
    </div>
  </div>
<?php }?>
</div>