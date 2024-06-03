 
 <?php $__env->startSection('title','Gmedia.Net - Pemesanan'); ?>
 <?php $__env->startSection('content'); ?>

<div id="layoutSidenav_content">
 	<main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Pemesanan Voucher</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Pemesanan</li>
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
                                <a onclick="this.href='/pemesananPDF/'+document.getElementById('tglawal').value+'/'+document.getElementById('tglakhir').value" data-toggle="tooltip" target="_blank" class="btn btn-secondary">
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
                        Data Pemesanan
                    </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
	                            <thead>
								    <tr align="center">
								        <th>No</th>
								        <th>Mitra</th>
                                        <th>Paket</th>
                                        <th>Limit</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Bukti Bayar</th>
                                        <th>Status</th>
                                        <th>Action</th>
								    </tr>
								</thead>
    							<tbody>
                                    <?php
                                        $kounter = 1;
                                    ?>
                                     <?php $__currentLoopData = $pemesanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <?php if(Auth::check() && Auth::user()->level == 'admin'): ?>
                                        <tr>
                                            <div hidden> <?php echo e($item->id); ?> </div>
                                            <td> <?php echo e($kounter); ?> </td>  
                                            <td> <?php echo e($item->Router->username); ?> </td>                     
                                            <td> <?php echo e($item->profile); ?> </td>
                                            <td> <?php echo e($item->limit); ?> </td>
                                            <td> <?php echo e($item->jumlah); ?> </td>
                                            <td> Rp <?php echo e(number_format($item->total, 0, ',' , '.')); ?> </td>
                                            <?php if($item->bukti_bayar == ''): ?>
                                                <td>
                                                    <span class="badge text-dark bg-warning">Dalam Proses</span>
                                                </td>
                                            <?php else: ?>
                                                <td>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#image<?php echo e($item->id); ?>">
                                                        <?php echo e($item->bukti_bayar); ?>

                                                    </a>

                                                <!-- Modal Image -->
                                                    <div class="modal fade" id="image<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                      <div class="modal-dialog" style="width: 20rem;">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                          </div>
                                                          <img src="<?php echo e(asset('Upload/bukti_bayar/'. $item->bukti_bayar)); ?>">
                                                        </div>
                                                      </div>
                                                    </div>
                                                <!-- close Modal Image -->
                                                </td>
                                            <?php endif; ?>
                                            <td>
                                                <?php if( $item->status == 'Pending' ): ?>
                                                <span class="badge text-light bg-danger"> <?php echo e($item-> status); ?> </span>
                                                <?php else: ?>
                                                <span class="badge text-light bg-success"> <?php echo e($item-> status); ?> </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button id="get_pes<?php echo e($item->id); ?>" class="btn btn-link btn-lg" >
                                                    <a href="<?php echo e(route('getpemesanan', $item->id)); ?>">
                                                        <i class="fa-sharp fa-solid fa-circle-plus"></i>
                                                    </a>
                                                </button>
                                   
                                                <a href="<?php echo e(route('destroy_', $item->id)); ?>" class="btn btn-link btn-lg" id="del_pemesanan" 
                                                    data-nama="<?php echo e($item->User->username); ?>">
                                                    <i class="fa fa-times"></i>
                                                </a>

                                                 <!--   Disable Button -->
                                                <script type="text/javascript">
                                                    <?php if($item->status == 'Selesai'): ?>
                                                        document.getElementById('get_pes<?php echo e($item->id); ?>').disabled = true;
                                                    <?php else: ?>
                                                        document.getElementById('get_pes<?php echo e($item->id); ?>').disabled = false;
                                                    <?php endif; ?>
                                                </script>
                                                <!--   Disable Button -->
                                            </td>
                                        </tr>
                                        <?php
                                            $kounter++;
                                        ?>
                                        <?php endif; ?>

                                        <?php if(Auth::check() && Auth::user()->level == 'mitra'): ?>
                                        <tr>
                                            <div hidden> <?php echo e($item->id); ?> </div>
                                            <td> <?php echo e($kounter); ?> </td>  
                                            <td> <?php echo e($item->Router->username); ?> </td>                     
                                            <td> <?php echo e($item->profile); ?> </td>
                                            <td> <?php echo e($item->limit); ?> </td>
                                            <td> <?php echo e($item->jumlah); ?> </td>
                                            <td> Rp <?php echo e(number_format($item->total, 0, ',' , '.')); ?> </td>
                                            <?php if($item->bukti_bayar == ''): ?>
                                                <td>
                                                    <a class="btn btn-link btn-lg" data-bs-toggle="modal" data-bs-target="#test<?php echo e($item->id); ?>">
                                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                                    </a>

                                                <!--  close modal upload-->
                                                     <div class="modal fade" id="test<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" 
                                                        aria-hidden="true">
                                                          <div class="modal-dialog">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Bukti</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                              </div>
                                                              <div class="modal-body">

                                                        <!--  Form add -->

                                                                <form action="<?php echo e(route('upload', $item->id)); ?>" method="POST" enctype="multipart/form-data">
                                                                <?php echo csrf_field(); ?> 
                                                                    <div class="form-floating mb-3">
                                                                        <input class="form-control" type="file" name="bukti" required>
                                                                        <label class="form-label">Upload File</label>
                                                                    </div><br>

                                                                    <!-- Warning ---->
                                                                    <b class="form-text">PERHATIAN !!
                                                                      <ul>
                                                                          <li>Pembayaran Ovo/Dana Ke (085712058763)</li>
                                                                          <li>No.Rekening 764585649 (BCA)</li>
                                                                      </ul>
                                                                    </b>
                                                                    <!-- Warning ---->

                                                                  <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                  </div>
                                                                </form>
                                                            <!-- Akhir Form -->
                                                            </div>
                                                          </div>
                                                        </div>
                                                <!--  close modal upload-->
                                                </td>
                                            <?php else: ?>
                                                <td>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#image<?php echo e($item->id); ?>">
                                                        <?php echo e($item->bukti_bayar); ?>

                                                    </a>

                                                <!-- Modal Image -->
                                                    <div class="modal fade" id="image<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                      <div class="modal-dialog" style="width: 21rem;">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                          </div>
                                                          <img src="<?php echo e(asset('Upload/bukti_bayar/'. $item->bukti_bayar)); ?>">
                                                        </div>
                                                      </div>
                                                    </div>
                                                <!-- close Modal Image -->
                                                </td>
                                            <?php endif; ?>
                                            <td>
                                                <?php if( $item->status == 'Pending' ): ?>
                                                <span class="badge text-light bg-danger"> <?php echo e($item-> status); ?> </span>
                                                <?php else: ?>
                                                <span class="badge text-light bg-success"> <?php echo e($item-> status); ?> </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-link btn-lg" data-bs-toggle="modal" data-bs-target="#edit<?php echo e($item->id); ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                   
                                                <a href="<?php echo e(route('destroy_', $item->id)); ?>" class="btn btn-link btn-lg" id="del_pemesanan" 
                                                    data-nama="<?php echo e($item->User->username); ?>">
                                                    <i class="fa fa-times"></i>
                                                </a>

                                                 <!--   Disable Button -->
                                                <script type="text/javascript">
                                                    <?php if($item->status == 'Selesai'): ?>
                                                        document.getElementById('get_pes<?php echo e($item->id); ?>').disabled = true;
                                                    <?php else: ?>
                                                        document.getElementById('get_pes<?php echo e($item->id); ?>').disabled = false;
                                                    <?php endif; ?>
                                                </script>
                                                <!--   Disable Button -->
                                            </td>
                                            <!-- Modal Edit Pemesanan -->
                                            <div class="modal fade" id="edit<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pemesanan</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Edit -->
                                                            <form action="<?php echo e(route('pemesanan.edit', $item->id)); ?>" method="POST">
                                                                <?php echo csrf_field(); ?> 
                                                                <!-- Profile -->
                                                                <div class="form-floating mb-3">
                                                                    <select class="form-control" name="profile" placeholder="Masukkan profile" required>
                                                                        <option value="">--Pilih Paket--</option>
                                                                        <option value="Streaming" <?php echo e($item->profile == 'Streaming' ? 'selected' : ''); ?>>Streaming</option>
                                                                        <option value="Social Media" <?php echo e($item->profile == 'Social Media' ? 'selected' : ''); ?>>Social Media</option>
                                                                        <option value="Lainnya" <?php echo e($item->profile == 'Lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                                                                    </select>
                                                                    <label class="form-label">Paket</label>
                                                                </div>
                                                                <!-- Limit -->
                                                                <div class="form-floating mb-3">
                                                                    <select class="form-control" name="limit" placeholder="Masukkan timelimit" required>
                                                                        <option value="">--Pilih Waktu--</option>
                                                                        <option value="6h" <?php echo e($item->limit == '6h' ? 'selected' : ''); ?>>6 Jam</option>
                                                                        <option value="12h" <?php echo e($item->limit == '12h' ? 'selected' : ''); ?>>12 Jam</option>
                                                                        <option value="1d" <?php echo e($item->limit == '1d' ? 'selected' : ''); ?>>1 Hari</option>
                                                                    </select>
                                                                    <label class="form-label">Durasi</label>
                                                                </div>
                                                                <!-- Jumlah -->
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" class="form-control" name="jumlah" value="<?php echo e($item->jumlah); ?>" placeholder="Masukkan Qty" required>
                                                                    <label class="form-label" for="jumlah">Qty</label>
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
                                            <!-- Modal Edit Pemesanan -->

                                        </tr> 
                                    <?php
                                        $kounter++;
                                    ?>

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


 
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\gmedia-pbl\GMEDIA SERVER\GMEDIA\resources\views/pemesanan.blade.php ENDPATH**/ ?>