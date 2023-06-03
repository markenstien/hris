<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo COMPANY_NAME?></title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo _path_tmp('bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo _path_tmp('assets/css/plugins.css')?>" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
     <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('plugins/table/datatable/datatables.css')?>">
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('plugins/table/datatable/dt-global_style.css')?>">
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('plugins/table/datatable/custom_dt_html5.css')?>">
    <!-- END PAGE LEVEL CUSTOM STYLES -->
    <style>
        /*
            The below code is for DEMO purpose --- Use it if you are using this demo otherwise Remove it
        */
        .navbar .navbar-item.navbar-dropdown {
            margin-left: auto;
        }
        .layout-px-spacing {
            min-height: calc(100vh - 96px)!important;
        }

        .page-command-container{
            text-align: right;
            padding: 10px;
            box-sizing: border-box;
            padding-right: 0px;;
            margin-bottom: 10px;
        }

        .page-command-container > * {
            display: inline;
            margin-right: 5px;
        }

        .page-command-container > *:last-child{
            margin-right: 5px;
        }
        
        .widget-header{
            padding: 20px !important;
        }

        .input-box {
            border: 1px solid #eee;;
            padding: 10px;
            display: inline-block;
            cursor: pointer;
        }

        .widget-content-area{
            padding: 20px !important;
        }

        @media print {
            .noprint {
                visibility: hidden;
            }
        }
    </style>

    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <?php produce('headers')?>
    <?php produce('styles')?>
</head>
<body class="sidebar-noneoverflow">
    
    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>
            
            <ul class="navbar-item flex-row">
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header">
                        <div class="page-title">
                            <h3 style="text-transform:uppercase;"><?php echo $_global['pageTitle'] ?? COMPANY_NAME_ABBR?></h3>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-item flex-row navbar-dropdown">
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo whoIs('profile') ?? _path_tmp('assets/img/90x90.jpg')?>" alt="avatar">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <img src="<?php echo whoIs('profile') ?? _path_tmp('assets/img/90x90.jpg')?>" class="img-fluid mr-2" alt="avatar">
                                <div class="media-body">
                                    <h5><?php echo whoIs('first_name')?></h5>
                                    <p><?php echo whoIs('position_name')?></p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="<?php echo _route('user:show', whoIs('id'))?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span> Profile</span>
                            </a>
                        </div>
                        <!-- <div class="dropdown-item">
                            <a href="apps_mailbox.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span> Inbox</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="auth_lockscreen.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Lock Screen</span>
                            </a>
                        </div> -->
                        <div class="dropdown-item">
                            <a href="<?php echo _route('auth:logout')?>">
                                <i data-feather="log-out"></i>
                                <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            
            <nav id="sidebar">

                <ul class="navbar-nav theme-brand flex-row  text-center">
                    <li class="nav-item theme-text">
                        <a href="<?php echo _route('user:dashboard')?>" class="nav-link">
                        <img src="<?php echo _path_upload_get('logo.png')?>" alt="" style="width: 30px;"> <?php echo APP_NAME?> </a>
                    </li>
                    <li class="nav-item toggle-sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather sidebarCollapse feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                    </li>
                </ul>

                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">

                    <li class="menu"  aria-expanded="true">
                        <a href="<?php echo _route('user:dashboard')?>" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span> Dashboard </span>
                            </div>
                        </a>
                    </li>

                    <?php if(isManagement()) :?>
                    <li class="menu"  aria-expanded="true">
                        <a href="<?php echo _route('user:index', null, [
                            'user_type' => 'staff_and_admin'
                        ])?>" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span>
                                    <?php if(whoIs('user_type',[USER_ADMIN,USER_SUB_ADMIN])) :?>
                                        Admin Info
                                    <?php else:?>
                                        Staff Info
                                    <?php endif?>
                                </span>
                            </div>
                        </a>
                    </li>
                    <?php endif?>

                    <?php if(isManagement()) : ?>
                    <li class="menu"  aria-expanded="true">
                        <a href="<?php echo _route('user:index', null, [
                            'user_type' => 'Employee'
                        ])?>" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span> Employees </span>
                            </div>
                        </a>
                    </li>
                    <?php endif?>

                    <?php if(isManagement()) :?>
                    <li class="menu">
                        <a href="<?php echo _route('leave-point:index')?>" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="calendar"></i>
                                <span> Leave Credits </span>
                            </div>
                        </a>
                    </li>

                    <?php endif?>

                    <li class="menu">
                        <a href="<?php echo _route('leave:index')?>" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="calendar"></i>
                                <span> Leave Request</span>
                            </div>
                        </a>
                    </li>
                    
                    
                    <li class="menu">
                        <a href="<?php echo _route('tk:index')?>" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="clock"></i>
                                <span> Attendance </span>
                            </div>
                        </a>
                    </li>
                    
                    <li class="menu">
                        <a href="<?php echo _route('requirement:index')?>" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="aperture"></i>
                                <span> Training & Seminars </span>
                            </div>
                        </a>
                    </li>

                    <?php if(isAdmin()) :?>
                    <li class="menu">
                        <a href="<?php echo _route('setting:guard-manage')?>" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="settings"></i>
                                <span> Settings  </span>
                            </div>
                        </a>
                    </li>
                    <?php endif?>

                    <li class="menu">
                        <a href="<?php echo _route('auth:logout')?>" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="log-out"></i>
                                <span> Logout </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
        <!--  END SIDEBAR  -->
        
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="layout-top-spacing"></div>
                <!-- CONTENT AREA -->
                <!-- <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
                        <div class="widget widget-content-area br-4">
                            <div class="widget-one">

                                <h6>Kick Start you new project with ease!</h6>

                                <p class="mb-0 mt-3">With CORK starter kit, you can begin your work without any hassle. The starter page is highly optimized which gives you freedom to start with minimal code and add only the desired components and plugins required for your project.</p>

                            </div>
                        </div>
                    </div>
                </div> -->
                <?php produce('page-control')?>
                <?php produce('content')?>
                <!-- CONTENT AREA -->

            </div>
            <div class="footer-wrapper">
                
            </div>
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo _path_tmp('assets/js/libs/jquery-3.1.1.min.js')?>"></script>
    <script src="<?php echo _path_tmp('bootstrap/js/popper.min.js')?>"></script>
    <script src="<?php echo _path_tmp('bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo _path_tmp('plugins/perfect-scrollbar/perfect-scrollbar.min.js')?>"></script>
    <script src="<?php echo _path_tmp('assets/js/app.js')?>"></script>
    
    <script>
        $(document).ready(function() {
            App.init();

            feather.replace();
        });
    </script>
    <script src="<?php echo _path_tmp('plugins/font-icons/feather/feather.min.js')?>"></script>
    <script src="<?php echo _path_tmp('assets/js/custom.js')?>"></script>
    <script src="<?php echo _path_public('js/core.js')?>"></script>
    <script src="<?php echo _path_public('js/global.js')?>"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <?php echo produce('scripts')?>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="<?php echo _path_tmp('assets/vendors/datatables.net/jquery.dataTables.js')?>"></script>
    <script src="<?php echo _path_tmp('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')?>"></script>

    <script src="<?php echo _path_tmp('plugins/table/datatable/datatables.js')?>"></script>

    <script src="<?php echo _path_tmp('plugins/table/datatable/button-ext/dataTables.buttons.min.js')?>"></script>
    <script src="<?php echo _path_tmp('plugins/table/datatable/button-ext/jszip.min.js')?>"></script>    
    <script src="<?php echo _path_tmp('plugins/table/datatable/button-ext/buttons.html5.min.js')?>"></script>
    <script src="<?php echo _path_tmp('plugins/table/datatable/button-ext/buttons.print.min.js')?>"></script>
    <script>

        $(document).ready(function(){

            if($('.dataTable')) {
                $('.dataTable').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "oLanguage": {
                        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 7 
                });
            }

            if($('.dataTableAction')) {
                $('.dataTableAction').DataTable( {
                    "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    buttons: {
                        buttons: [
                            { extend: 'print', className: 'btn btn-sm' }
                        ]
                    },
                    "oLanguage": {
                        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 7 
                } );
            }
        });
    </script>
</body>
</html>