<!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      
      <!-- Uncomment below if you prefer to use an image logo -->
      <a href="" class="logo me-auto"><img src="<?php echo e(asset('template-landing-page')); ?>/assets/img/logo.png" alt="" class="img-fluid"></a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#why-us">Alasan</a></li>
          <li><a class="nav-link scrollto" href="#skills">Performa</a></li>
          <li><a class="nav-link scrollto" href="#pricing">Harga</a></li>
          <li><a class="nav-link scrollto" href="#hotspot">Hotspot</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <?php if(auth()->guard()->check()): ?>
            <!-- Jika pengguna sudah login, tampilkan logo profile -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-person-circle" style="font-size: 36px;"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                        <!-- Tautan untuk Dashboard -->
                        <a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                        <!-- Form untuk Logout -->
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <!-- Tombol untuk Logout -->
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                </div>
            </li>

          <?php else: ?>
            <!-- Jika pengguna belum login, tampilkan tombol login -->
            <li><a class="getstarted scrollto" href="/login">Login</a></li>
          <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <?php echo $__env->yieldContent('content'); ?><?php /**PATH D:\File Rheza\gmedia-project\GMEDIA\resources\views/landing-page/layout/navbar.blade.php ENDPATH**/ ?>