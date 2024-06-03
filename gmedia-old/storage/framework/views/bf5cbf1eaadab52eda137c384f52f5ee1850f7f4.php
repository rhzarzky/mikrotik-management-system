<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $__env->yieldContent('title'); ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">
<!--   <meta http-equiv="Conntent-Security-policy" content="upgrade-insecure-requests"> -->

  <!-- Favicons -->
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/img/favicon.png" rel="icon">
  <!-- <link href="<?php echo e(asset('template-landing-page')); ?>/assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo e(asset('template-landing-page')); ?>/assets/css/style.css" rel="stylesheet">
  <!-- modal -->
  <link rel="stylesheet" href="<?php echo e(asset('template-landing-page')); ?>/assets/modal/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo e(asset('template-landing-page')); ?>/assets/modal/css/style.css">

  <!-- =======================================================
  * Template Name: Arsha
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body>
  <?php echo $__env->make('landing-page.layout.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <!-- Vendor JS Files -->
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/aos/aos.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/js/main.js"></script>

  <!-- modal -->
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/modal/js/jquery.min.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/modal/js/popper.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/modal/js/bootstrap.min.js"></script>
  <script src="<?php echo e(asset('template-landing-page')); ?>/assets/modal/js/main.js"></script>

  <?php echo $__env->yieldPushContent('scripts'); ?>
</body><?php /**PATH D:\gmedia-pbl\gmedia-project\GMEDIA\resources\views/landing-page/layout/master.blade.php ENDPATH**/ ?>