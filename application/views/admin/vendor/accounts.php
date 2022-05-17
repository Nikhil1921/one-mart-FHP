<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<div class="row card-block">
			<h4 class="sub form-control-info"><?= ucfirst($name) ?> List</h4>
		</div>
		<div class="table table-responsive">
			<table class="table table-striped table-hover table-bordered nowrap">
				<thead>
					<tr>
						<th>Sr No.</th>
						<th>Order ID</th>
						<th>Payment Type</th>
						<th>Payment</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($accounts): ?>
					<?php $total = 0; foreach ($accounts as $k => $v):
						if($v['payment_type'] === 'Liability') $total += $v['payment'];
					else $total -= $v['payment']?>
					<tr>
						<td><?= $k + 1 ?></td>
						<td><?= $v['book_id'] ?></td>
						<td><?= $v['payment_type'] ?></td>
						<td><?= $v['payment'] ?></td>
					</tr>
					<?php endforeach ?>
					<?php else: ?>
					<tr>
						<td colspan="4" class="text-center">No Accounts History</td>
					</tr>
					<?php endif ?>
				</tbody>
				<tfoot>
				<?php if ($accounts): ?>
				<tr>
					<th>
						<form action="<?= base_url('admin/vendor/clear') ?>" method="POST" >
							<input type="hidden" name="id" value="<?= $id ?>">
							<button class="btn btn-outline-primary btn-round waves-effect waves-light">Clear Account</button>
						</form>
					</th>
					<th><a href="<?= base_url('admin/vendor'); ?>" class="btn btn-outline-danger btn-round waves-effect waves-light">Back</a></th>
					<th>Total</th>
					<th><?= $total ?></th>
				</tr>
				<?php else: ?>
				<tr>
					<th colspan="4" class="text-center"><a href="<?= base_url('admin/vendor'); ?>" class="btn btn-outline-danger btn-round waves-effect waves-light">Go Back</a></th>
				</tr>
				<?php endif ?>
				
				</tfoot>
			</table>
		</div>
		<div class="row card-block">
			<h4 class="sub form-control-info"><?= ucfirst($name) ?> History</h4>
		</div>
		<div class="table table-responsive">
			<table class="table table-striped table-hover table-bordered nowrap">
				<thead>
					<tr>
						<th>Sr No.</th>
						<th>Order ID</th>
						<th>Payment Type</th>
						<th>Payment</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($history): ?>
					<?php $hTotal = 0; foreach ($history as $ke => $va):
						if($va['payment_type'] === 'Liability') $hTotal += $va['payment'];
					else $hTotal -= $va['payment']?>
					<tr>
						<td><?= $ke + 1 ?></td>
						<td><?= $va['book_id'] ?></td>
						<td><?= $va['payment_type'] ?></td>
						<td><?= $va['payment'] ?></td>
					</tr>
					<?php endforeach ?>
					<?php else: ?>
					<tr>
						<td colspan="4" class="text-center">No Accounts History</td>
					</tr>
					<?php endif ?>
				</tbody>
				<tfoot>
				<?php if ($history): ?>
				<tr>
					<th colspan="2" class="text-center"><a href="<?= base_url('admin/vendor'); ?>" class="btn btn-outline-danger btn-round waves-effect waves-light">Go Back</a></th>
					<th>Total</th>
					<th><?= $hTotal ?></th>
				</tr>
				<?php else: ?>
				<tr>
					<th colspan="4" class="text-center"><a href="<?= base_url('admin/vendor'); ?>" class="btn btn-outline-danger btn-round waves-effect waves-light">Go Back</a></th>
				</tr>
				<?php endif ?>
				</tfoot>
			</table>
		</div>
	</div>
</div>