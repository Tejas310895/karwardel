<?php 

include("includes/db.php");

session_start();
$del_partner_id = $_SESSION['del_id'];

?>
<?php
if(isset($_POST["limit"], $_POST["start"])){
    
?>

<?php 
  
  $get_reports = "SELECT * FROM orders_delivery_assign where delivery_partner_id='$del_partner_id' GROUP BY CAST(delivery_assign_updated_at as DATE) order by delivery_assign_updated_at desc LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
  $run_reports = mysqli_query($con,$get_reports);
  $counter = 0;
  while($row_reports = mysqli_fetch_array($run_reports)){
  $del_date = $row_reports['delivery_assign_updated_at'];
  $delivery_date = date('Y-m-d',strtotime($del_date));
  $display_delivery_date = date('d-M-Y',strtotime($del_date));

  $counter = ++$counter;
  
  $get_orders_count = "SELECT * from orders_delivery_assign where CAST(delivery_assign_updated_at as DATE)='$delivery_date' and delivery_partner_id='$del_partner_id'";
  $run_orders_count = mysqli_query($con,$get_orders_count);
  $orders_count = mysqli_num_rows($run_orders_count);

  $get_orders_charges = "select sum(delivery_charges) as orders_charges from orders_delivery_assign where CAST(delivery_assign_updated_at as DATE)='$delivery_date' and delivery_partner_id='$del_partner_id'";
  $run_orders_charges = mysqli_query($con,$get_orders_charges);
  $row_orders_charges = mysqli_fetch_array($run_orders_charges);

  $orders_charges = $row_orders_charges['orders_charges'];

?>
<div id="accordion">
<div class="card">
  <div class="card-header" id="headingOne">
    <h5 class="mb-0 text-center">
      <button class="btn btn-link btn-block" data-toggle="collapse" data-target="#collapse<?php echo $counter; ?>" aria-expanded="true" aria-controls="collapseOne">
        <h6 class="mb-0">Order Report <br><?php echo $display_delivery_date; ?></h6>
        <h6 class="mb-0"><small>( Orders <?php $orders_count; ?></small></h6>
        <h6 class="mb-0"><small>( Earnings ₹<?php if($orders_charges>0){echo $orders_charges;}else{ echo 0;} ?>/- )</small></h6>
        <i class="now-ui-icons arrows-1_minimal-down"></i>
      </button>
    </h5>
  </div>
  <div id="collapse<?php echo $counter; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
  <div class="card-body">
    <div class="table-responsive">
        <table class="table text-center">
          <thead class=" text-primary">
            <th>
              Name
            </th>
            <th>
              AMT
            </th>
            <th>
              DLC
            </th>
          </thead>
          <tbody class="text-center">
            <?php 
            
            $get_orders = "select * from orders_delivery_assign where CAST(delivery_assign_created_at as DATE)='$delivery_date' and delivery_partner_id='$del_partner_id'";
            $run_orders = mysqli_query($con,$get_orders);
            while($row_orders=mysqli_fetch_array($run_orders)){
                $invoice_no = $row_orders['invoice_no'];
                $delivery_charges = $row_orders['delivery_charges'];

                $get_orders_details = "SELECT * from customer_orders where invoice_no='$invoice_no'";
                $run_orders_details = mysqli_query($con,$get_orders_details);
                $row_orders_details=mysqli_fetch_array($run_orders_details);

                $customer_id = $row_orders_details['customer_id'];

                $get_customer = "select * from customers where customer_id='$customer_id'";
                $run_customer = mysqli_query($con,$get_customer);
                $row_customer = mysqli_fetch_array($run_customer);
                $customer_name = $row_customer['customer_name'];

                $get_order_total = "select sum(due_amount) as order_total from customer_orders where invoice_no='$invoice_no' and order_status='Delivered' and product_status='Deliver'";
                $run_order_total = mysqli_query($con,$get_order_total);
                $row_order_total = mysqli_fetch_array($run_order_total);

                $order_total = $row_order_total['order_total'];

            ?>
            <tr>
              <td>
                <?php echo $customer_name."</br>".$invoice_no; ?>
              </td>
              <td>
                <?php echo $order_total; ?>
              </td>
              <td>
                <?php echo $delivery_charges; ?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<?php } }?>
