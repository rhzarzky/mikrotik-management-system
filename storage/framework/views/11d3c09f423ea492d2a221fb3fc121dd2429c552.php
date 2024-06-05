 
 <?php $__env->startSection('title','Gmedia.Net - Router'); ?>
 <?php $__env->startSection('content'); ?>

 <div id="layoutSidenav_content">
     <main>
         <div class="container-fluid px-4">
             <h1 class="mt-4">Router</h1>
             <ol class="breadcrumb mb-4">
                 <li class="breadcrumb-item active">Router</li>
             </ol>
             <div class="card mb-4">
                 <div class="card-body">
                     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addrouter">
                         <i class="fa-solid fa-user-plus"></i> &nbsp; Router
                     </button>
                 </div>
             </div>

             <!-- Modal add-->

             <div class="modal fade" id="addrouter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                 <div class="modal-dialog">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Router</h1>
                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">

                             <!--  Form add -->
                             <form action="<?php echo e(route('addrouter.post')); ?>" method="POST">
                                 <?php echo csrf_field(); ?>
                                 <div class="form-floating mb-3">
                                     <input type="text" class="form-control" name="name" placeholder="Masukkan name" required>
                                     <label class="form-label">Name</label>
                                 </div>
                                 <div class="form-floating mb-3">
                                     <input type="text" class="form-control" name="address" placeholder="Masukkan ip_address" required>
                                     <label class="form-label">Address</label>
                                 </div>
                                 <div class="form-floating mb-3">
                                     <input type="text" class="form-control" name="username" placeholder="Masukkan user" required>
                                     <label class="form-label">Username</label>
                                 </div>
                                 <div class="form-floating mb-3">
                                     <input type="text" class="form-control" name="password" placeholder="Masukkan password" required>
                                     <label class="form-label">Password</label>
                                 </div>
                         </div>
                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Tambah</button>
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                         </div>
                         </form>
                         <!-- Akhir Form -->
                     </div>
                 </div>
             </div>
             <!--  close modal add-->

             <!--  Data Router -->

             <div class="card mb-4">
                 <div class="card-header">
                     <i class="fas fa-table me-1"></i>
                     Data Router
                 </div>
                 <div class="card-body">
                     <table id="datatablesSimple">
                         <thead>
                             <tr align="center">
                                 <th>No</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>IP Address</th>
                                 <th>Username</th>
                                 <th>Password</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php $__currentLoopData = $datausers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <tr>
                                 <div hidden> <?php echo e($item->id); ?> </div>
                                 <td> <?php echo e($no + 1); ?> </td>
                                 <td> <?php echo e($item->name); ?> </td>
                                 <td> <?php echo e($item->user->email); ?> </td>
                                 <td> <?php echo e($item->address); ?> </td>
                                 <td> <?php echo e($item->username); ?> </td>
                                 <td> <?php echo e($item->password); ?> </td>
                                 <td>
                                     <div class="form-button-action">
                                         <!-- Button login -->
                                         <a class="btn btn-link btn-lg" href="<?php echo e(route('loginAuth', ['ip' => $item->address, 'user' => $item->username, 'password' => $item->password])); ?>">
                                             <i class="fa fa-sign-in-alt"></i>
                                         </a>

                                         <!-- Button edit -->
                                         <a class="btn btn-link btn-lg" data-bs-toggle="modal" data-bs-target="#edit<?php echo e($item->id); ?>">
                                             <i class="fa fa-edit"></i>
                                         </a>

                                         <!-- Button hapus -->
                                         <a href="<?php echo e(route('deleteRouter', $item->id)); ?>" class="btn btn-link btn-lg" id="deleterouter" data-nama="<?php echo e($item->username); ?>">
                                             <i class="fa fa-times"></i>
                                         </a>
                                     </div>
                                 </td>

                                 <!-- Modal edit -->
                                 <div class="modal fade" id="edit<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                     <div class="modal-dialog">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Router</h1>
                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                             </div>
                                             <!-- Form Edit -->
                                             <div class="modal-body">
                                                 <form action="<?php echo e(route('router.edit', $item->id)); ?>" method="POST">
                                                     <?php echo csrf_field(); ?>
                                                     <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" name="address" value="<?php echo e($item->address); ?>" placeholder="Masukkan address" required>
                                                         <label class="form-label" for="address">Address</label>
                                                     </div>
                                                     <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" name="username" value="<?php echo e($item->username); ?>" placeholder="Masukkan username" required>
                                                         <label class="form-label">Username</label>
                                                     </div>
                                                     <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" name="password" placeholder="Masukkan password baru">
                                                         <label class="form-label">Password</label>
                                                     </div>
                                                     <div class="modal-footer">
                                                         <button type="submit" class="btn btn-primary">Ubah</button>
                                                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                     </div>
                                                 </form>
                                                 <!-- Akhir Form -->
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- Modal Edit -->
                                 <!-- Modal login-->

                                 <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                     <div class="modal-dialog">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Login Router</h1>
                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                             </div>

                                             <!--  Form Login -->

                                             <div class="modal-body">
                                                 <form action="<?php echo e(route('login.post')); ?>" method="POST">
                                                     <?php echo csrf_field(); ?>
                                                     <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" name="address" value="<?php echo e($item -> address); ?>" placeholder="Masukkan user" required>
                                                         <label class="form-label" for="user">Address</label>
                                                     </div>
                                                     <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" name="username" value="<?php echo e($item -> username); ?>" placeholder="Masukkan username" required>
                                                         <label class="form-label">Username</label>
                                                     </div>
                                                     <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" name="username" value="<?php echo e($item -> username); ?>" placeholder="Masukkan username" required>
                                                         <label class="form-label">Password</label>
                                                     </div>
                                                     <div class="modal-footer">
                                                         <button type="submit" class="btn btn-primary">Login</button>
                                                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                     </div>
                                                 </form>
                                                 <!-- Akhir Form -->

                                             </div>
                                         </div>
                                     </div>
                                     <!--  close modal edit -->

                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </tbody>
                     </table>
                 </div>
             </div>

             <!--   Akhir Data Voucher -->

         </div>
     </main>
     <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 </div>
 <!-- 
 <script src="https://cdn.jsdelivr.net/npm/laravel-echo@^1.11.4/dist/echo.min.js"></script>
<script>
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '<?php echo e(env('PUSHER_APP_KEY')); ?>',
        cluster: '<?php echo e(env('PUSHER_APP_CLUSTER')); ?>',
        forceTLS: true
    });
</script> -->
 <?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.supermaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\File Rheza\gmedia-project\resources\views/router.blade.php ENDPATH**/ ?>