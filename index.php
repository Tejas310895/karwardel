<?php

if(!isset($_COOKIE['wrn_del_user'])){

  echo "<script>window.open('login.php','_self')</script>";

}else{

include("includes/db.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Karwars Team</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="RoyalUI/template/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="RoyalUI/template/vendors/base/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Expletus+Sans">
  <script type="text/javascript" src="js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="RoyalUI/template/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/karwarslogo.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="./?dashboard"><img src="images/karwarslogo.png" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="./?dashboard"><img src="images/karwarslogo.png" alt="logo"/></a>
        <?php 
        
        $del_partner_id = $_COOKIE['wrn_del_user'];
        $get_del_boy = "select * from delivery_partner where  delivery_partner_id='$del_partner_id'";
        $run_del_boy = mysqli_query($con,$get_del_boy);
        $row_del_boy = mysqli_fetch_array($run_del_boy);

        $del_boy_code = $row_del_boy['delivery_partner_code'];
        
        ?>
        <h3 class="text-dark text-center text-uppercase mb-0"><?php echo $del_boy_code; ?></h3>
        <img src="images/valet.png" alt="" class="img-fluid border-0" style="background-color:transparent;" width="40px">
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>
        <!-- <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="ti-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul> -->
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown mr-1">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
              <i class="ti-bell mx-0"></i>
                <!-- <span class="badge badge-primary bell-badge rounded-circle px-2 py-1">
                  <h6 class="mb-0">4</h6>
                </span> -->
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notification</p>
              <?php 

              $get_instant_noti = "select * from del_notifications where delivery_partner_id='$del_partner_id'";
              $run_instant_noti = mysqli_query($con,$get_instant_noti);
              $noti_count = mysqli_num_rows($run_instant_noti);
              while($row_instant_noti=mysqli_fetch_array($run_instant_noti)){

                  $noti_subject = $row_instant_noti['notification_subject'];
                  $noti_content = $row_instant_noti['notification_content'];
                  $noti_status = $row_instant_noti['notification_status'];

              ?>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                    <h4><i class="ti-bell bg-secondary rounded-circle p-2 mr-0"></i></h4>
                </div>
                <div class="item-content flex-grow">
                  <h6 class="ellipsis font-weight-normal"><?php echo $noti_subject; ?>
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                  <?php echo substr($noti_content,0,36).'...'; ?>
                  </p>
                </div>
              </a>
              <?php } ?>
              <a class="btn btn-link btn-block btn-lg p-1 text-center <?php if($noti_count<=0){echo"d-none";}?>" href="index?notification"><h4>see all</h4></a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-view-list"></span>
        </button>
      </div>
    </nav>
<?php 

include 'includes/sidebar.php';

?>

<?php 

if(isset($_GET['dashboard'])){
                    
  include("dashboard.php");
  
}

if(isset($_GET['clients'])){
                    
  include("clients.php");
  
}

if(isset($_GET['earnings'])){
                    
  include("earnings.php");
  
}

if(isset($_GET['bonus'])){
                    
  include("bonus.php");
  
}

if(isset($_GET['settelments'])){
                    
  include("settelments.php");
  
}

if(isset($_GET['profile'])){
                    
  include("profile.php");
  
}

if(isset($_GET['notification'])){
                    
  include("notification.php");
  
}

if(isset($_GET['ledger'])){
                    
  include("ledger.php");
  
}

if(isset($_GET['change_pass'])){
                    
  include("change_pass.php");
  
}

?>

<?php 

include 'includes/footer.php';

?>

        <!-- partial:partials/_footer.html -->
        <!-- <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">© wernear.com 2020</span>
          </div>
        </footer> -->
        <!-- partial -->
        </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- plugins:js -->
  <script src="RoyalUI/template/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="RoyalUI/template/vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="RoyalUI/template/js/off-canvas.js"></script>
  <script src="RoyalUI/template/js/hoverable-collapse.js"></script>
  <script src="RoyalUI/template/js/template.js"></script>
  <script src="RoyalUI/template/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="RoyalUI/template/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php } ?>
