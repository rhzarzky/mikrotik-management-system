
<?php $__env->startSection('title','Gmedia.Net - Dashboard'); ?>
<?php $__env->startSection('content'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-info text-black bg-gradient mb-4">
                            <div class="card-body">
                                <h4 class="card-title">Router Information</h4>
                                <div class="numbers">
                                    <p class="card-category">| CPU Load: <span id="cpu"></span></p>
                                    <p class="card-category">| UP Time: <span id="uptime"></span></p>
                                    <p class="card-category">| RAM: <?php echo e(formatBytes($freememory)); ?></p>
                                    <p class="card-category">| Storage: <?php echo e(formatBytes($freehdd)); ?></p>
                                    <p class="card-category">| Model: <?php echo e($model); ?></p>
                                    <p class="card-category">| Board: <?php echo e($boardname); ?></p>
                                    <p class="card-category">| OS: <?php echo e($version); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white bg-gradient mb-4">
                            <div class="card-body"> <i class="fa-solid fa-ticket"></i> &nbsp; Total Voucher : <?= $totalhotspotuser ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('voucher')); ?>">Voucher</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <?php if(Auth::check() && Auth::user()->level == 'admin'): ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white bg-gradient mb-4">
                            <div class="card-body"><i class="fas fa-globe"></i> &nbsp; Total Voucher Profile : <?= $totalhotspotprofile ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('profile')); ?>">Voucher Profile</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white bg-gradient mb-4">
                            <div class="card-body"><i class="fas fa-coins"></i> &nbsp; Rp <?php echo e(number_format($totalPrice, 0, ',' , '.')); ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('transaksi')); ?>">Penjualan Voucher</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white bg-gradient mb-4">
                            <div class="card-body"><i class="fas fa-coins"></i> &nbsp; Rp <?php echo e(number_format($total, 0, ',' , '.')); ?> </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('keranjang')); ?>">Pembelian Mitra</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <script type="text/javascript">
        setInterval('cpu();', 1000);
        function cpu() {
            $('#cpu').load('<?php echo e(route('dashboard.cpu')); ?>')
        }

        setInterval('uptime();', 1000);
        function uptime() {
            $('#uptime').load('<?php echo e(route('dashboard.uptime')); ?>')
        }

        <?php
        function formatBytes($bytes, $decimal = null)
        {
            $satuan = ['Bytes', 'Kb', 'Mb', 'Gb', 'Tb'];
            $i = 0;
            while ($bytes > 1024) {
                $bytes /= 1024;
                $i++;
            }
            return round($bytes, $decimal) . '' . $satuan[$i];
        }
        ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\gmedia-pbl\gmedia-project\resources\views/dashboard.blade.php ENDPATH**/ ?>