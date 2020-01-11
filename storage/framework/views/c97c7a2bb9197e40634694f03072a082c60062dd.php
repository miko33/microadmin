<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <link href="<?php echo e(url('assets/css/switch.css')); ?>" rel="stylesheet" type="text/css" />

    <title><?php echo e(ucwords(str_replace('_', ' ', request()->segment(count(request()->segments())))) ?: 'Dashboard'); ?> - <?php echo e(config('app.name', 'Laravel')); ?></title>

    <?php echo $__env->make('layouts.template.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</head>
<body class="header-dark sidebar-light sidebar-expand">
    <div id="app">
        <div id="wrapper" class="wrapper">
            <!-- HEADER & TOP NAVIGATION -->
            <nav class="navbar">
                <!-- Logo Area -->
                <div class="navbar-header">
                    <a href="./index.html" class="navbar-brand">
                        <img class="logo-expand" alt="" src="<?php echo e(url('assets/demo/logo-expand.png')); ?>" />
                        <img class="logo-collapse" alt="" src="<?php echo e(url('assets/demo/logo-collapse.png')); ?>" />
                        <!-- <p>BonVue</p> -->
                    </a>
                </div>
                <!-- /.navbar-header -->
                <!-- Left Menu & Sidebar Toggle -->
                <ul class="nav navbar-nav">
                    <li class="sidebar-toggle">
                        <a href="javascript:void(0)" class="ripple"><i class="feather feather-menu list-icon fs-20"></i></a>
                    </li>
                </ul>
                <!-- /.navbar-left -->
                <!-- Search Form -->
                <form class="navbar-search d-none d-sm-block" role="search">
                    <i class="feather feather-search list-icon"></i>
                    <input type="search" class="search-query" placeholder="Search anything..." />
                    <a href="javascript:void(0);" class="remove-focus">
                        <i class="material-icons">clear</i>
                    </a>
                </form>
                <!-- /.navbar-search -->
                <div class="spacer"></div>
                <!-- User Image with Dropdown -->
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle ripple" data-toggle="dropdown">
                            <span class="avatar thumb-xs2">
                                <img src="<?php echo e(url('assets/demo/user-cards/4.jpg')); ?>" class="rounded-circle" alt="" />
                                <i class="feather feather-chevron-down list-icon"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-left dropdown-card dropdown-card-profile animated flipInY">
                            <div class="card">
                                <header class="card-header d-flex mb-0">
                                    <a href="javascript:void(0);" class="col-md-4 text-center">
                                        <i class="feather feather-user-plus align-middle"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="col-md-4 text-center"><i class="feather feather-settings align-middle"></i></a>
                                    <a href="javascript:void(0);" class="col-md-4 text-center"><i class="feather feather-power align-middle"></i></a>
                                </header>
                                <ul class="list-unstyled card-body">
                                    <li>
                                        <a href="#">
                                            <span class="align-middle">Manage Accounts</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="align-middle">Change Password</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <span class="align-middle">Logout</span>
                                        </a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- /.navbar-right -->
            </nav>
            <!-- /.navbar -->
            <div class="content-wrapper">
                <!-- SIDEBAR -->
                <aside class="site-sidebar scrollbar-enabled" data-suppress-scroll-x="true">
                    <!-- User Details -->
                    <div class="side-user">
                        <div class="col-sm-12 text-center p-0 clearfix">
                            <div class="d-inline-block pos-relative mr-b-10">
                                <figure class="thumb-sm mr-b-0 user--online">
                                    <img src="<?php echo e(url('assets/demo/user-cards/4.jpg')); ?>" class="rounded-circle" alt="" />
                                </figure><a href="./page-profile.html" class="text-muted side-user-link"><i class="feather feather-settings list-icon"></i></a>
                            </div>
                            <!-- /.d-inline-block -->
                            <div class="lh-14 mr-t-5">
                                <a href="javascript:void(0);" class="hide-menu mt-3 mb-0 side-user-heading fw-500"><?php echo e(Auth::user()->name); ?></a>
                                <br /><small class="hide-menu">Developer</small>
                            </div>
                        </div>
                        <!-- /.col-sm-12 -->
                    </div>
                    <!-- /.side-user -->
                    <!-- Sidebar Menu -->
                    <nav class="sidebar-nav">

                        <?php echo $module; ?>


                        <!-- /.side-menu -->
                    </nav>
                    <!-- /.sidebar-nav -->
                </aside>
                <!-- /.site-sidebar -->
                <main class="main-wrapper clearfix">
                    <!-- Page Title Area -->
                    <div class="row page-title clearfix">
                        <div class="page-title-left">
                            <h6 class="page-title-heading mr-0 mr-r-5">  <?php echo e(ucwords(str_replace('_', ' ', request()->segment(count(request()->segments())))) ?: 'Dashboard'); ?></h6>
                            <?php if(!isset($microsite_breadcrumb)): ?>
                            <p class="page-title-description mr-0 d-none d-md-inline-block"><?php echo e(App\General::breadcrumb(request()->segment(count(request()->segments())) ?: '')->description); ?></p>
                            <?php else: ?>
                            <p class="page-title-description mr-0 d-none d-md-inline-block"><?php echo e($microsite_breadcrumb); ?></p>
                            <?php endif; ?>
                        </div>
                        <!-- /.page-title-left -->
                        <div class="page-title-right d-inline-flex">
                            <ol class="breadcrumb">
                            <?php $link = '' ?>
                            <?php for($i = 1; $i <= count(Request::segments()); $i++): ?>
                                <?php if($i < count(Request::segments()) & $i > 0): ?>
                                <?php $link .= '/' . Request::segment($i); ?>
                                    <li class="breadcrumb-item"><a href="<?php echo e($link); ?>"><?php echo e(ucwords(str_replace('_',' ',Request::segment($i)))); ?></a></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active"><?php echo e(ucwords(str_replace('_',' ',Request::segment($i)))); ?></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            </ol>
                        </div>
                        <!-- /.page-title-right -->
                    </div>
                    <!-- /.page-title -->
                    <!-- =================================== -->
                    <!-- Different data widgets ============ -->
                    <!-- =================================== -->

                    <?php echo $__env->yieldContent('widget-body'); ?>

                </main>
                <!-- /.main-wrappper -->
            </div>
            <!-- /.content-wrapper -->

            <!-- FOOTER -->
            <footer class="footer">
                <span class="heading-font-family">Copyright @ 2017. All rights reserved BonVue Admin by Unifato</span>
            </footer>
        </div>
        <!--/ #wrapper -->
    </div>

    <!--/ modal -->
    <div class="modal modal-danger fade bs-modal-md" tabindex="-1" role="dialog" aria-labelledby="myMediumModalLabel" aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="general-form">
                        <?php echo e(csrf_field()); ?>

                        <div class="col-lg-12">
                            <div class="form-group mr-b-10">
                                <label for="password1">Delete Confirmation:</label>
                                <input class="form-control" name="inputName" type="text" required">
                            </div>
                        </div>
                        <div class="form-actions btn-list">
                            <button class="btn btn-danger" type="submit">Delete</button>
                            <button class="cancel btn btn-outline-default" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <?php echo $__env->make('layouts.template.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
