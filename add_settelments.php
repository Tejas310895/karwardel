<div class="col-12 grid-margin form_profile">
<form action="" method="post">
    <div class="row">
        <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><h4 class="mb-0">Settled Amount</h4></label>
            <div class="col-sm-9">
            <input type="number" class="form-control" name="settlement_amt" placeholder="5000"/>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><h4 class="mb-0">Transaction Type</h4></label>
            <div class="col-sm-9">
            <input type="text" class="form-control" name="settlement_type" placeholder="Cash/Gpay/Bank Deposit"/>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><h4 class="mb-0">Ref.no/Remarks</h4></label>
            <div class="col-sm-9">
            <input type="text" class="form-control" name="settlement_ref_id" placeholder="transaction id/bank deposit/cheque no"/>
            </div>
        </div>
        </div>
    </div>
    <button class="btn btn-primary btn-lg btn-block" name="update_settlements">Update</button>
    </form>
</div>

<?php 

if(isset($_POST['update_profile'])){

    $settlement_amt = $_POST['settlement_amt'];
    $settlement_type = $_POST['settlement_type'];
    $settlement_ref_id = $_POST['settlement_ref_id'];

    date_default_timezone_set('Asia/Kolkata');
    $today = date("Y-m-d H:i:s");

    $update_del_settlement = "update del_settlements set settlement_amt='$settlement_amt',
                                                      settlement_type='$settlement_type',
                                                      settlement_ref_id	='$settlement_ref_id',
                                                      settlement_status='inactive',
                                                      updated_date='$today'
                                                      where delivery_partner_id='$del_partner_id'";
    $run_update_del_settlement = mysqli_query($con,$update_del_settlement);

    if($run_update_del_settlement){

        echo "<script>alert('Details Updated')</script>";
        echo "<script>window.open('index.php?profile','_self')</script>";

    }else{

        echo "<script>alert('Update Failed Try Again')</script>";
        echo "<script>window.open('index.php?profile','_self')</script>";

    }
}

?>
