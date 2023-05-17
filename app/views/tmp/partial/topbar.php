
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form
        class="sr-only d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <?php if( $auth = auth() ):?>
    <?php $notifications = _notify_pull_items( whoIs('id')) ?>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow sr-only">
            <a class="nav-link" href="<?php echo _route('appointment:index')?>" aria-expanded="false">
                <span class="text-primary">Back to panel</span>
            </a>
        </li>
        <!-- <div class="topbar-divider d-none d-sm-block"></div> -->
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1 sr-only ">
            <a class="nav-link dropdown-toggle " href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter"><?php echo !empty($notifications) ? count($notifications).'+' : ''?></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                <?php foreach($notifications as  $key => $row) :?>
                    <?php if( $key > 5 ) break?>
                    <a class="dropdown-item d-flex align-items-center" href="<?php echo empty($row->href) ? '#' : $row->href?>">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500"><?php echo date_long($row->created_at)?></div>
                            <span class="font-weight-bold"><?php echo $row->message?></span>
                        </div>
                    </a>
                <?php endforeach?>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
        </li>
        
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php echo $auth->first_name?>(<?php echo $auth->user_type?>)
                </span>
                <img class="img-profile rounded-circle"
                    src="<?php echo _path_tmp('img/undraw_profile.svg')?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo _route('user:profile')?>">
                    <i class="fas fa-address-altUserController fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="<?php echo _route('auth:logout')?>">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>

    <?php else:?>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link" href="<?php echo _route('user:register')?>" aria-expanded="false">
                <span class="text-primary">Register</span>
            </a>
        </li>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link" href="<?php echo _route('auth:login')?>" aria-expanded="false">
                <span class="text-primary">Login</span>
            </a>
        </li>
    </ul>
    <?php endif?>
</nav>
<!-- End of Topbar -->