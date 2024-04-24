 
 <?php $__env->startSection('title','Gmedia.Net - Active Scheduler'); ?>
 <?php $__env->startSection('content'); ?>

<div id="layoutSidenav_content">
 	<main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Voucher Scheduler</h1>
             	<ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Hotspot</li>
                    <li class="breadcrumb-item active">Scheduler</li>
                </ol>

               <!--  Data Scheduler -->

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Voucher Scheduler
                    </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
	                            <thead>
								    <tr align="center">
								        <th>No</th>
								        <th>Name</th>
								        <th>Start Date</th>
								        <th>Start Time</th>
                                        <th>Interval</th>
                                        <th>Run</th>
								    </tr>
								</thead>
								<tbody >
									<?php $__currentLoopData = $scheduler; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr align="center">
                                        <div hidden><?php echo e($id = str_replace('*', '', $data['.id'])); ?></div>
                                        <td><?php echo e($no + 1); ?></td>
                                        <td><?php echo e($data['name']); ?></td>
                                        <td><?php echo e($data['start-date']); ?></td>
                                        <td><?php echo e($data['start-time']); ?></td>
                                        <td><?php echo e($data['interval']); ?></td>
                                        <td><?php echo e($data['next-run']); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                        	</tbody>
                            </table>
	                     </div>
	                </div>

	              <!--   Akhir Data Voucher -->
	              
	        	</div>
	    	</main>


<!-- <script>

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
    </script> -->

    <!-- <script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function() {
            location.reload();
        }, 1000);
    })
</script> -->




	    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>

 <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\File Rheza\gmedia-project\GMEDIA\resources\views/scheduler.blade.php ENDPATH**/ ?>