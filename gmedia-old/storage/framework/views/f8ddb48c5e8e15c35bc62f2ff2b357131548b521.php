<!DOCTYPE html>
<html>
<head>
	<title>Cetak PDF</title>
</head>
<body>
	<style type="text/css">
		.table{
			font-family: sans-serif;
			color: #232323;
			border-collapse: collapse;
		}
		.table, th,td{
			border: 1px solid #999;
			padding: 8px 20px;
		}
	</style>
	<h4 align="center">Laporan Pembelian Mitra</h4>
	<div class="form-group">
	<table class="table">
		<thead>
			<tr>
				<th style="width: 5%">No.</th>
				<th style="width: 7%">Mitra</th>
				<th style="width: 12%">Paket</th>
				<th style="width: 10%">Limit</th>
				<th style="width: 14%">Qty</th>
				<th style="width: 14%">Total</th>
				<th style="width: 10%">Waktu</th>
			</tr>
		</thead>
		<tbody>
			<?php $__currentLoopData = $PDFPemesanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(Auth::check() && Auth::user()->level == 'admin'): ?>
			<tr>
				<td> <?php echo e($no + 1); ?> </td>                      
                <td> <?php echo e($item->User->username); ?> </td>
                <td> <?php echo e($item->profile); ?> </td>
                <td> <?php echo e($item->limit); ?> </td>
                <td> <?php echo e($item->jumlah); ?> </td>
                <td> Rp <?php echo e(number_format($item->total, 0, ',' , '.')); ?></td>
                <td> <?php echo e(Carbon\Carbon::parse($item->created_at)->format("d/m/Y")); ?> </td>
			</tr>
				<?php endif; ?>

				<?php if($item->User->username == auth()->user()->username): ?>
			<tr>
				<td> <?php echo e($no + 1); ?> </td>                      
                <td> <?php echo e($item->User->username); ?> </td>
                <td> <?php echo e($item->profile); ?> </td>
                <td> <?php echo e($item->limit); ?> </td>
                <td> <?php echo e($item->jumlah); ?> </td>
                <td> Rp <?php echo e(number_format($item->total, 0, ',' , '.')); ?></td>
                <td> <?php echo e(Carbon\Carbon::parse($item->created_at)->format("d/m/Y")); ?> </td>
			</tr>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
		<br>
			<b>Total Penjualan : Rp <?php echo e(number_format($total, 0, ',' , '.')); ?></b>
	</div>
	<script type="text/javascript">
		window.print();
	</script>
</body>
</html><?php /**PATH D:\gmedia-pbl\GMEDIA SERVER\GMEDIA\resources\views/pemesananPDF.blade.php ENDPATH**/ ?>