<div class="container-fluid px-0">
    <div class="table-responsive">
        <table class="table table">
            <thead>
            <tr class="text-center">
                <th>
                Date
                </th>
                <th>
                Amount
                </th>
                <th>
                Type
                </th>
                <th>
                Remarks
                </th>
                <th>
                Status
                </th>
            </tr>
            </thead>
            <tbody>
            <?php 
            
            $get_settlement = "select * from del_settlements where delivery_partner_id='$del_partner_id'";
            $run_settlement = mysqli_query($con,$get_settlement);
            while($row_settlement=mysqli_fetch_array($run_settlement)){
            
            $updated_date = $row_settlement['updated_date'];
            $settlement_amt = $row_settlement['settlement_amt'];
            $settlement_type = $row_settlement['settlement_type'];
            $settlement_ref_id = $row_settlement['settlement_ref_id'];
            $settlement_status = $row_settlement['settlement_status'];

            ?>
            <tr class="text-center table-info">
                <td>
                <?php echo date('d/M/Y',strtotime($updated_date)); ?>
                </td>
                <td>
                ₹ <?php echo number_format($settlement_amt,2) ?>
                </td>
                <td>
                    <?php echo $settlement_type; ?>
                </td>
                <td>
                    <?php echo $settlement_ref_id; ?>
                </td>
                <td>
                    <?php echo $settlement_status; ?>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <a href="index.php?add_settelments" class="float">
            <i class="now-ui-icons ui-1_simple-add my-float"></i>
        </a>
    </div>
</div>

