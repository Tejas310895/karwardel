<div class="row">
<?php 
    $get_assgined_orders = "select * from orders_delivery_assign where delivery_partner_id='$del_partner_id' order by delivery_assign_updated_at desc";
    $run_assgined_orders = mysqli_query($con,$get_assgined_orders);
    while($row_assgined_orders=mysqli_fetch_array($run_assgined_orders)){
    
      $invoice_id = $row_assgined_orders['invoice_no'];
      $delivery_charges = $row_assgined_orders['delivery_charges'];
    
      $get_orders = "select * from customer_orders where invoice_no='$invoice_id'";
    
      $run_orders = mysqli_query($con,$get_orders);

        $order_count = mysqli_num_rows($run_orders);

        $row_orders = mysqli_fetch_array($run_orders);

        $c_id = $row_orders['customer_id'];

        $date = $row_orders['order_date'];

        $add_id = $row_orders['add_id'];

        $order_date = $row_orders['order_date'];

        $order_status = $row_orders['order_status'];

        $get_total = "SELECT sum(due_amount) AS total FROM customer_orders WHERE invoice_no='$invoice_id' and product_status='Deliver'";       

        $run_total = mysqli_query($con,$get_total);

        $row_total = mysqli_fetch_array($run_total);

        $total = $row_total['total'];

        $get_vendor_total = "SELECT sum(vendor_due_amount) AS vendor_total FROM customer_orders WHERE invoice_no='$invoice_id' and product_status='Deliver'";      

        $run_vendor_total = mysqli_query($con,$get_vendor_total);

        $row_vendor_total = mysqli_fetch_array($run_vendor_total);

        $vendor_total = $row_vendor_total['vendor_total'];

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

        $get_discount = "select * from customer_discounts where invoice_no='$invoice_id'";
        $run_discount = mysqli_query($con,$get_discount);
        $row_discount = mysqli_fetch_array($run_discount);

        $discount_type = $row_discount['discount_type'];
        $discount_amount = $row_discount['discount_amount'];

        $get_txn_sta = "select * from paytm where ORDERID='$invoice_id'";
        $run_txn_sta = mysqli_query($con,$get_txn_sta);
        $row_txn_sta = mysqli_fetch_array($run_txn_sta);
      
        $STATUS = $row_txn_sta['STATUS'];

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
          <div class="col-lg-12 col-md-6">
            <div class="card card-chart">
                <div class="card-header">
                  <div class="row">
                    <div class="col-7">
                      <h6><span class="badge badge-warning rounded text-white">You Earn : ₹ <?php echo $delivery_charges; ?></span></h6>
                      <h6 class="card-title">Name - <?php echo $c_name; ?></h6>
                      <h6 class="card-title">Mobile - +91 <?php echo $c_contact; ?></h6>
                      <h6 class="card-title">Address - 
                      <?php echo $customer_address; ?>, 
                      <?php echo $customer_phase; ?>, 
                      <?php echo $customer_landmark; ?>, 
                      <?php echo $customer_city; ?> . 
                      </h6>
                    </div>
                    <?php 
    
                    if(!isset($STATUS)){

                      ?>
                        <div class="col-5 text-right"> 
                          <span class="badge badge-pill badge-danger rounded"><h4 class="text-right mt-0 mb-0"><small>TO PAY<?php echo $STATUS; ?></small> ₹ <?php echo $grand_total; ?>/-</h4></span> <br>
                          <?php 
                          
                          $get_link = "select * from payment_links where invoice_id='$invoice_id'";
                          $run_link = mysqli_query($con,$get_link);
                          $count_links = mysqli_num_rows($run_link);

                          if($count_links>0){
                          ?>
                          <a href="process_orders.php?order_link=<?php echo $invoice_id; ?>" class="btn btn-info btn-sm py-1 text-white mt-1"><i class="ti-link"></i> Click Here</a>
                        <?php } ?>
                        </div>
                      <?php

                    }else{

                      if($STATUS==='SUCCESS'){

                      ?>
                    <div class="col-5 text-right"> <span class="badge badge-pill badge-success rounded"><h4 class="text-right mb-0 mt-0">PAID</h4></span></div>

                    <?php 
                    
                      }else{
                    
                    ?>

                    <div class="col-5 text-right"> <span class="badge badge-pill badge-danger rounded"><h4 class="text-right mb-0"><small>TO PAY</small> ₹ <?php echo $grand_total; ?>/-</h4></span></div>

                      <?php
                      }
                    }
                    
                    ?>
                  </div>
                </div>
                <div class="card-body">
                    <a href="process_orders.php?update_order=<?php echo $invoice_id; ?>&status=Delivered" class="btn btn-success pull-right" onclick="return confirm('Are you sure?')" style="padding: 11px 21px;">
                    <i class="now-ui-icons shopping_basket"></i>
                    Delivered
                    </a>
                    <button id="show_details" class="btn btn-danger pull-left" data-toggle="modal" data-target="#cK<?php echo $invoice_id; ?>" style="padding: 11px 21px;">
                    <i class="now-ui-icons travel_info"></i>
                    View
                    </button>
                </div>
            </div>
          </div>
        <!-- Modal -->
        <div class="modal modal-black fade text-dark" id="cK<?php echo $invoice_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Id - <?php echo $invoice_id; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="tim-icons icon-simple-remove"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">ITEMS</th>
                            <th class="text-center">QTY</th>
                            <th class="text-right">MRP</th>
                            <!-- <th class="text-right">Status</th> -->
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                    $get_vendor = "select * from customer_orders where invoice_no='$invoice_id' group by client_id";
                    $run_vendor = mysqli_query($con,$get_vendor);
                    while ($row_vendor=mysqli_fetch_array($run_vendor)) {
                    $vendor_id = $row_vendor['client_id'];

                    $get_client = "select * from clients where client_id='$vendor_id'";

                    $run_client = mysqli_query($con,$get_client);

                    $row_client = mysqli_fetch_array($run_client);

                    $client_name = $row_client['client_shop'];

                    echo "<td colspan='4' class='text-center text-uppercase py-2'><h6 class='mb-0 mt-0'>$client_name</h6></td>";

                    $get_pro_id = "select * from customer_orders where invoice_no='$invoice_id' and client_id='$vendor_id'";    

                    $run_pro_id = mysqli_query($con,$get_pro_id);

                    $counter = 0;

                    while($row_pro_id = mysqli_fetch_array($run_pro_id)){

                    $pro_id = $row_pro_id['pro_id'];

                    $qty = $row_pro_id['qty'];

                    $sub_total = $row_pro_id['due_amount'];

                    $vendor_sub_total = $row_pro_id['vendor_due_amount'];

                    // $client_id = $row_pro_id['client_id'];

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

                    ?>
                        <tr>
                            <td class="text-center"><?php echo $pro_title; ?><br><?php echo $pro_desc; ?></td>
                            <td class="text-center"><?php echo $qty; ?></td>
                            <td class="text-right">₹ <?php echo $sub_total; ?></td>
                            <!-- <td class="text-right"><?php //echo $pro_status; ?></td> -->
                        </tr>
                        <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
                        </div>
                    </div>     
                </div>
                </div>
            </div>
            </div>
            <?php } ?>
<?php } ?>
</div>