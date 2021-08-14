<div class="container-fluid px-0">
        <ul class="nav nav-pills nav-fill my-0" id="pills-tab" role="tablist">
            <li class="nav-item mx-0">
                <a class="nav-link rounded-0 active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">CREDITS</a>
            </li>
            <li class="nav-item mx-0">
                <a class="nav-link rounded-0" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">DEBITS</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
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
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    
                    $get_salary = "select * from del_payroll where delivery_partner_id='$del_partner_id'";
                    $run_salary = mysqli_query($con,$get_salary);
                    while($row_salary=mysqli_fetch_array($run_salary)){
                    
                    $updated_date = $row_salary['updated_date'];
                    $salary_amt = $row_salary['salary_amt'];
                    $salary_type = $row_salary['salary_type'];
                    $salary_ref_id = $row_salary['salary_ref_id'];
                    
                    ?>
                    <tr class="text-center table-success">
                    <td>
                    <?php echo date('d/M/Y',strtotime($updated_date)); ?>
                    </td>
                    <td>
                    ₹ <?php echo number_format($salary_amt,2) ?>
                    </td>
                    <td>
                        <?php echo $salary_type; ?>
                    </td>
                    <td>
                        <?php echo $salary_ref_id; ?>
                    </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
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
                        Remarks
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    
                    $get_debits = "select * from del_debits where delivery_partner_id='$del_partner_id'";
                    $run_debits = mysqli_query($con,$get_debits);
                    while($row_debits=mysqli_fetch_array($run_debits)){

                        $debit_updated_date = $row_debits['updated_date'];
                        $del_debit_amt = $row_debits['del_debit_amt'];
                        $del_debit_comment = $row_debits['del_debit_comment'];
                    
                    ?>
                    <tr class="text-center table-danger">
                        <td>
                        <?php echo date('d/M/y',strtotime($debit_updated_date)); ?>
                        </td>
                        <td>
                        ₹ <?php echo number_format($del_debit_amt,2); ?>
                        </td>
                        <td>
                        <?php echo $del_debit_comment; ?>
                        </td>
                    </tr>
                    <tr>
                        
                    </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>