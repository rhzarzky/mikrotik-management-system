 
 <?php $__env->startSection('title','Gmedia.Net - Transaksi'); ?>
 <?php $__env->startSection('content'); ?>

<div id="layoutSidenav_content">
 	<main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Riwayat Transaksi</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Transaksi</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-0">
                                    <input class="form-control" name="tglawal" id="tglawal" type="date" />
                                    <label for="tglawal">Tanggal Awal</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" name="tglakhir" id="tglakhir" type="date" />
                                    <label for="tglakhir">tanggal Akhir</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a onclick="this.href='/transaksiPDF/'+document.getElementById('tglawal').value+'/'+document.getElementById('tglakhir').value" data-toggle="tooltip" target="_blank" class="btn btn-secondary">
                                    <i class="fa-regular fa-file-pdf"></i>&nbsp; Cetak PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

               <!--  Data Mitra -->

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Transaksi
                    </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
	                            <thead>
								    <tr align="center">
								        <th>No</th>
								        <th>Username</th>
                                        <th>Paket</th>
                                        <th>Harga</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
								        <th>Action</th>
								    </tr>
								</thead>
    							<tbody>
                                    <?php
                                        $kounter = 1;
                                    ?>
                                    <?php $__currentLoopData = $datatransaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($item->User->username == auth()->user()->username): ?>
                                        <tr>
                                            <div hidden> <?php echo e($item->id); ?> </div>
                                            <td> <?php echo e($kounter); ?> </td>                  
                                            <td> <?php echo e($item->username); ?> </td>
                                            <td> <?php echo e($item->profile); ?> </td>
                                            <td> Rp <?php echo e(number_format($item->price, 0, ',' , '.')); ?></td>
                                            <td> <?php echo e(Carbon\Carbon::parse($item->created_at)->format("d/m/Y")); ?> </td>
                                            <td> <?php echo e($item->status); ?> </td>
                                            <td>
                                                <button class=" btn btn-link btn-lg">
                                                    <a href="<?php echo e(route('getrouter', $item->id)); ?>" >
                                                        <i class="fa-solid fa-link"></i>
                                                    </a>
                                                </button>
                                                <a href="<?php echo e(route('destroy', $item->id)); ?>" class="btn btn-link btn-lg" id="deletetransaksi" data-nama="<?php echo e($item->username); ?>">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal Image -->

                                        <div class="modal fade" id="imagemodal<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                          <div class="modal-dialog" style="width: 21rem;">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <img src="<?php echo e(asset('Upload/bukti_bayar/'. $item->bukti_bayar)); ?>">
                                            </div>
                                          </div>
                                        </div>
                                        <?php
                                            $kounter++;
                                        ?>
                                   <!--  close modal edit --> 
                                        <?php endif; ?>
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
 <?php $__env->stopSection(); ?>


 
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\File Rheza\gmedia-project\GMEDIA\resources\views/transaksi.blade.php ENDPATH**/ ?>