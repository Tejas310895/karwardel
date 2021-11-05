<div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
        -->
      <div class="logo bg-white">
        <a href="#" class="simple-text logo-normal">
            <img src="images/karwarslogo.png" class="mx-auto d-block" width="100" height="60" alt="">
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="<?php if(isset($_GET['dashboard'])){echo "active";} ?>">
            <a href="index.php?dashboard">
              <i class="now-ui-icons design_app"></i>
              <p>Orders</p>
            </a>
          </li>
          <li class="<?php if(isset($_GET['earnings'])){echo "active";} ?>">
            <a href="index.php?earnings">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Earnings</p>
            </a>
          </li>
          <li class="<?php if(isset($_GET['bonus'])){echo "active";} ?>">
            <a href="index.php?bonus">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Bonus</p>
            </a>
          </li>
          <li class="<?php if(isset($_GET['settlements'])){echo "active";} ?>">
            <a href="index.php?settelments">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Settlements</p>
            </a>
          </li>
          <li class="<?php if(isset($_GET['ledger'])){echo "active";} ?>">
            <a href="index.php?ledger">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Ledger</p>
            </a>
          </li>
          <li class="<?php if(isset($_GET['profile'])){echo "active";} ?>">
            <a href="index.php?profile">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Profile</p>
            </a>
          </li>
          <li class="<?php if(isset($_GET['change_pass'])){echo "active";} ?>">
            <a href="index.php?change_pass">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Change Password</p>
            </a>
          </li>
          <li class="<?php if(isset($_GET['notifications'])){echo "active";} ?>">
            <a href="index.php?notification">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Notifications</p>
            </a>
          </li>
          <li class="">
            <a href="logout.php" onclick="return confirm('Are you sure?')">
              <i class="now-ui-icons media-1_button-power"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </div>
    </div>