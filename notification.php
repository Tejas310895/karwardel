<div class="row p-1">
<?php 

$get_notification = "select * from del_notifications where delivery_partner_id='$del_partner_id'";
$run_notification = mysqli_query($con,$get_notification);
while($row_notification=mysqli_fetch_array($run_notification)){

    $notification_subject = $row_notification['notification_subject'];
    $notification_content = $row_notification['notification_content'];
    $notification_status = $row_notification['notification_status'];
    $notification_updated_date = $row_notification['updated_date'];

?>
    <div class="col-12 grid-margin">
        <div class="card p-3 bg-light">
            <div class="row">
                <div class="col-2 pt-2">
                    <i class="ti-bell mx-0 p-2 bg-success text-white rounded-circle"></i>
                </div>
                <div class="col-10 text-left px-0">
                    <h5><?php echo $notification_subject; ?> <br><small><?php echo date('d/M/Y,h:i:s a',strtotime($notification_updated_date)); ?></small></h5>
                    <h6><?php echo $notification_content; ?></h6>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>