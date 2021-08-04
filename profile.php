<?php 

$get_user_details = "select * from delivery_partner where delivery_partner_id='$del_partner_id'";
$run_user_details = mysqli_query($con,$get_user_details);
$row_user_details = mysqli_fetch_array($run_user_details);

$delivery_partner_name = $row_user_details['delivery_partner_name'];
$delivery_partner_email = $row_user_details['delivery_partner_email'];
$delivery_partner_contact = $row_user_details['delivery_partner_contact'];


?>
<div class="col-12 grid-margin form_profile">
<form action="" method="post">
    <div class="row">
        <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><h4 class="mb-0">Your Name</h4></label>
            <div class="col-sm-9">
            <input type="text" class="form-control" name="del_name" value="<?php echo $delivery_partner_name; ?>"/>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><h4 class="mb-0">Mobile No.</h4></label>
            <div class="col-sm-9">
            <input type="text" class="form-control" name="del_contact" value="<?php echo $delivery_partner_contact; ?>"/>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><h4 class="mb-0">Your Email</h4></label>
            <div class="col-sm-9">
            <input type="text" class="form-control" name="del_email" value="<?php echo $delivery_partner_email; ?>"/>
            </div>
        </div>
        </div>
    </div>
    <button class="btn btn-primary btn-lg btn-block" name="update_profile">Update</button>
    </form>
</div>

<?php 

if(isset($_POST['update_profile'])){

    $del_name = $_POST['del_name'];
    $del_contact = $_POST['del_contact'];
    $del_email = $_POST['del_email'];

    $update_del_profile = "update delivery_partner set delivery_partner_name='$del_name',
                                                        delivery_partner_email='$del_email',
                                                        delivery_partner_contact='$del_contact'
                                                        where delivery_partner_id='$del_partner_id'";
    $run_update_del_profile = mysqli_query($con,$update_del_profile);

    if($run_update_del_profile){

        echo "<script>alert('Details Updated')</script>";
        echo "<script>window.open('index.php?profile','_self')</script>";

    }else{

        echo "<script>alert('Update Failed Try Again')</script>";
        echo "<script>window.open('index.php?profile','_self')</script>";

    }
}

?>
