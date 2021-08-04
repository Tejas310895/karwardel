<div class="container-fluid px-0">
    <div class="table-responsive">
        <table class="table table">
            <thead>
            <tr class="text-center">
                <th>
                Date
                </th>
                <th>
                Orders
                </th>
                <th>
                Earnings
                </th>
            </tr>
            </thead>
            <tbody>
            <?php 

                    $get_orders_date = "select * from orders_delivery_assign where delivery_partner_id='$del_partner_id' group by CAST(delivery_assign_created_at as DATE)";
                    $run_orders_date = mysqli_query($con,$get_orders_date);
                    while($row_orders_date=mysqli_fetch_array($run_orders_date)){

                    $delivery_assign_date = $row_orders_date['delivery_assign_created_at'];
                    $formated_delivery_assign_date = date("Y-m-d",strtotime($delivery_assign_date));
                    $modal_id = date("Ymd",strtotime($delivery_assign_date));

                    $get_orders_count = "select * from orders_delivery_assign where CAST(delivery_assign_created_at as DATE)='$formated_delivery_assign_date' and delivery_partner_id='$del_partner_id'";
                    $run_orders_count = mysqli_query($con,$get_orders_count);
                    $orders_count = mysqli_num_rows($run_orders_count);

                    $get_orders_charges = "select sum(delivery_charges) as orders_charges from orders_delivery_assign where CAST(delivery_assign_created_at as DATE)='$formated_delivery_assign_date'";
                    $run_orders_charges = mysqli_query($con,$get_orders_charges);
                    $row_orders_charges = mysqli_fetch_array($run_orders_charges);

                    $orders_charges = $row_orders_charges['orders_charges'];

            ?>
            <tr class="text-center table-info">
                <td>
                <?php echo date("d-M-y",strtotime($delivery_assign_date)); ?>
                </td>
                <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#od<?php echo $modal_id; ?>">
                    <?php echo $orders_count; ?>
                </button>
                
                <!-- Modal -->
                <div class="modal fade" id="od<?php echo $modal_id; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Report</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>AMT</th>
                                            <th>DLC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        
                                        $get_orders_details = "SELECT * from customer_orders where CAST(del_date as DATE)='$formated_delivery_assign_date'";
                                        $run_orders_details = mysqli_query($con,$get_orders_details);
                                        while($row_orders_details=mysqli_fetch_array($run_orders_details)){

                                        $customer_id = $row_orders_details['customer_id'];
                                        $invoice_no = $row_orders_details['invoice_no'];

                                        $get_customer = "select * from customers where customer_id='$customer_id'";
                                        $run_customer = mysqli_query($con,$get_customer);             
                                        $row_customer = mysqli_fetch_array($run_customer);             
                                        $c_name = $row_customer['customer_name'];

                                        $get_order_amount = "select sum(due_amount) as order_amount from customer_orders where invoice_no='$invoice_no'";
                                        $run_order_amount = mysqli_query($con,$get_order_amount);
                                        $row_order_amount = mysqli_fetch_array($run_order_amount);

                                        $order_amount = $row_order_amount['order_amount'];

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

                                        $get_dlc_charges = "select sum(delivery_charges) as dlc from orders_delivery_assign where invoice_no='$invoice_no'";
                                        $run_dlc_charges = mysqli_query($con,$get_dlc_charges);
                                        $row_dlc_charges = mysqli_fetch_array($run_dlc_charges);
                    
                                        $dlc = $row_dlc_charges['dlc'];

                                        if($discount_type==='amount'){

                                            $grand_total = ($order_amount+$del_charges)-$discount_amount;
                            
                                          }elseif ($discount_type==='product') {
                            
                                            $get_off_pro = "select * from products where product_id='$discount_amount'";
                                            $run_off_pro = mysqli_query($con,$get_off_pro);
                                            $row_off_pro = mysqli_fetch_array($run_off_pro);
                            
                                            $off_product_price = $row_off_pro['product_price'];
                            
                                            $grand_total = ($order_amount+$del_charges)+$off_product_price;
                                            
                                          }elseif (empty($discount_type)) {
                            
                                            $grand_total = $order_amount+$del_charges;
                                            
                                          }
                                        ?>
                                        <tr>
                                            <td class="text-left"><?php echo $c_name."</br>".$invoice_no; ?></td>
                                            <td><?php echo $grand_total; ?></td>
                                            <td><?php echo $dlc; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                </td>
                <td>
                <?php echo $orders_charges; ?>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

