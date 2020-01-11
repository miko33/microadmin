<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/demo/favicon.png" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Error 500</title>
    <!-- CSS -->
    <link href="<?php echo e(url('/assets/vendors/material-icons/material-icons.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('/assets/vendors/linea-icons/styles.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('/assets/vendors/mono-social-icons/monosocialiconsfont.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('/assets/vendors/feather-icons/feather.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.1.3/mediaelementplayer.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.7.0/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,900,900i" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('/assets/css/style.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Head Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body class="body-bg-full error-page error-500" style="background-image: url(<?php echo e(url('/assets/demo/error-page.jpg')); ?>)">;
    <div id="wrapper" class="wrapper">
        <div class="content-wrapper">
            <main class="main-wrapper">
                <div class="page-title">
                    <h1 class="color-white">500</h1>
                </div>
                <h3 class="mr-b-5 color-white">Unexpected Error!</h3>
                <p class="mr-b-30 color-white fs-18 fw-200 heading-font-family"><?php echo e($exception->getMessage() ? $exception->getMessage() : "An error occurred and your request couldn't be completed."); ?></p><a href="javascript: history.back();" class="btn btn-outline-white btn-rounded btn-block fw-700 text-uppercase">Go Back</a>
            </main>
        </div>
        <!-- .content-wrapper -->
    </div>
    <!-- .wrapper -->
</body>

</html>