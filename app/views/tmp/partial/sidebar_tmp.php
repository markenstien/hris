
<?php $auth = auth()?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="<?php echo GET_PATH_UPLOAD.'/logo_main.JPG'?>" style="width: 50px">
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo COMPANY_NAME_ABBR?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
  <!--   <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
 -->
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Main
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('user:index')?>">
            <i class="fas fa-user"></i>
            <span>User</span></a>
    </li>   

    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('category:index')?>">
            <i class="fas fa-sort-alpha-down"></i>
            <span>Categories</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#module-service-items"
            aria-expanded="true" aria-controls="module-service-items">
            <i class="fas fa-fw fa-store"></i>
            <span>Products</span>
        </a>
        <div id="module-service-items" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Modules</h6>
                <a class="collapse-item" href="<?php echo _route('service:index')?>">List</a>
                <a class="collapse-item" href="<?php echo _route('stock:index')?>">Inventory</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('appointment:index')?>">
            <i class="fas fa-calendar-check"></i>
            <span>Appointments</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('session:index')?>">
            <i class="fas fa-calendar-check"></i>
            <span>Sessions</span></a>
    </li>
    

    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('user:profile')?>">
            <i class="fas fa-calendar-check"></i>
            <span>Profile</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('auth:logout')?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>
</ul>