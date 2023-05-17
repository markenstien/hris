
<?php $auth = auth()?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo COMPANY_NAME?></div>
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

    <?php if(isEqual($auth->user_type , 'admin')):?>
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
    <?php endif?>
    <?php if(isEqual($auth->user_type , ['admin' , 'doctor'])):?>
        <li class="nav-item">
            <a class="nav-link" href="/CalendarController/index">
                <i class="fas fa-calendar"></i>
                <span>Calendar</span></a>
        </li>
    <?php endif?>
    
    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('appointment:index')?>">
            <i class="fas fa-calendar-check"></i>
            <span>Appointments</span></a>
    </li>
    <?php if(isEqual($auth->user_type , 'admin')):?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('bill:index')?>">
            <i class="fas fa-file-alt"></i>
            <span>Bills</span></a>
    </li>
    <?php endif?>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('session:index')?>">
            <i class="fas fa-calendar-check"></i>
            <span>Sessions</span></a>
    </li>

    <?php if(isEqual($auth->user_type , ['admin' , 'doctor'])):?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('payment:index')?>">
            <i class="fas fa-money-check"></i>
            <span>Payments</span></a>
    </li>
    <?php endif?>
    <?php if(isEqual($auth->user_type , 'admin')):?>
    <li class="nav-item">
        <a class="nav-link" href="/ReportController/create">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Reports</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#module-service-items"
            aria-expanded="true" aria-controls="module-service-items">
            <i class="fas fa-fw fa-cog"></i>
            <span>Services</span>
        </a>
        <div id="module-service-items" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Modules</h6>
                <a class="collapse-item" href="<?php echo _route('service:index')?>">Service</a>
                <a class="collapse-item" href="<?php echo _route('service-bundle:index')?>">Packages</a>
            </div>
        </div>
    </li>
    <?php endif?>
    
    <?php if(isEqual($auth->user_type , ['admin' , 'doctor'])):?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('specialty:index')?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Specialties</span></a>
    </li>
    <?php endif?>

    <?php if(isEqual($auth->user_type , 'admin')):?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo _route('schedule:update')?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Schedule Settings</span></a>
    </li>
    <?php endif?>

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