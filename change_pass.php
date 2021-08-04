<?php 

$get_user_email = "select * from delivery_partner where delivery_partner_id='$del_partner_id'";
$run_user_email = mysqli_query($con,$get_user_email);
$row_user_email = mysqli_fetch_array($run_user_email);

$delivery_partner_pass = $row_user_email['delivery_partner_pass'];

?>

<div class="col-12 grid-margin form_profile">
<form action="" method="post">
    <div class="row">
        <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><h4 class="mb-0">Old Password</h4></label>
            <div class="col-sm-9">
            <input type="password" class="form-control" name="del_old_pass" placeholder="Enter Old Password" required/>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><h4 class="mb-0">New Password</h4></label>
            <div class="col-sm-9">
            <input type="password" class="form-control" name="del_pass" placeholder="Enter New Password" required/>
            </div>
        </div>
        </div>
    </div>
    <button class="btn btn-primary btn-block" type="submit" name="submit">Update Change</button>
    </form>
</div>
<?php 

if(isset($_POST['submit'])){
    $del_old_pass = $_POST['del_old_pass'];
    $del_new_pass = $_POST['del_pass'];

    $del_hash_pass = password_hash($del_new_pass, PASSWORD_DEFAULT);

    if(!password_verify($del_old_pass, $delivery_partner_pass)){

        echo "<script>alert('Password do not match')</script>";

    }else{
        $update_password = "update delivery_partner set delivery_partner_pass='$del_hash_pass' where delivery_partner_id='$del_partner_id'";
        $run_update_password = mysqli_query($con,$update_password);
    
              echo "<script>alert('Changes Updated')</script>";
              echo "<script>window.open('logout','_self')</script>";
    }
}

?>
