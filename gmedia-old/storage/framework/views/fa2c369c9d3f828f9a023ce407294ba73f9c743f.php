 
 <?php $__env->startSection('title','Gmedia.Net - Active Voucher'); ?>
 <?php $__env->startSection('content'); ?>

<div id="layoutSidenav_content">
 	<main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Voucher Active</h1>
             	<ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Hotspot</li>
                    <li class="breadcrumb-item active">Status</li>
                </ol>
                 <div class="card mb-4">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addvoucher">
                            <i class="fa-solid fa-user-plus"></i> &nbsp; Voucher
                        </button>&nbsp;
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addvoucher">
                            <i class="fa-sharp fa-solid fa-circle-plus"></i> &nbsp; Generate
                        </button> 
                    </div>
                </div>

               <!--  Data Voucher/user -->

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Voucher Active
                    </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
	                            <thead>
								    <tr align="center">
								        <th>No</th>
								        <th>Server</th>
								        <th>Voucher</th>
								        <th>Address</th>
                                        <th>Session Time</th>
								    </tr>
								</thead>
								<tbody >
									<?php $__currentLoopData = $hotspotactive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr align="center">
                                        <div hidden><?php echo e($id = str_replace('*', '', $data['.id'])); ?></div>
                                        <td><?php echo e($no + 1); ?></td>
                                        <td><?php echo e($data['server']); ?></td>
                                        <td><?php echo e($data['user']); ?></td>
                                        <td><?php echo e($data['address']); ?></td>
                                        <td><?php echo e($data['session-time-left'] ?? 'unlimited'); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                        	</tbody>
                            </table>
	                     </div>
	                </div>

	              <!--   Akhir Data Voucher -->
	              
	        	</div>
	    	</main>


<script>

            setInterval(function() {
                $.ajax({
                    url: '<?php echo e(route('active')); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#mikrotik-data').empty();
                        $.each(data, function(active, active) {
                            $('#mikrotik-data').append('<tr><td>'+ (no++) + active['server'] + '</td><td>' + address['user'] + '</td><td>' + address['address'] + '</td><td>'+ address['session-time-left'] +'</td></tr>');
                        });
                    }
                });
            }, 1000);
    </script>

<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function() {
            location.reload();
        }, 1000);
    })
</script>




	    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>

 <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\gmedia-pbl\gmedia-project\GMEDIA\resources\views/active.blade.php ENDPATH**/ ?>