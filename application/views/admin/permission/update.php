<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<div class="row card-block">
			<h4 class="sub form-control-info"><?= ucfirst($name) ?> Access</h4>
		</div>
		<div class="table table-responsive">
			<table class="table table-hover table-bordered nowrap">
				<thead>
					<tr>
						<th>Menu</th>
						<?php foreach ($roles as $k => $r): ?>
							<th><?= ucwords($r['role']) ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
					<?php foreach($_SESSION['menu'] as $m): ?>
					<tr>
						<td><?= ucwords($m['name']) ?></td>
						<?php if (!empty($m['sub_menu'])): ?>
						<td>
							<div class="dc">
								<?php foreach ($m['sub_menu'] as $k => $v): ?>
								<label><?= ucwords($k) ?></label>
								<form action="<?= base_url('admin/permission/add') ?>" method="POST" class="access">
									<input type="hidden" name="menu" value="<?= str_replace('admin/', '', $k) ?>">
									<input type="hidden" name="role" value="superadmin">
									<?php foreach (explode(',', $m['permissions']) as $ke => $va): ?>
									<div class="checkbox-zoom zoom-warning">
										<label>
											<input type="checkbox" <?= (strpos($access, '"role":"staff","menu":"'.$k.'","operation":"'.$va.'"') !== false) ? 'checked' : '' ?> value="<?= $va ?>" name="operation[]">
											<span class="cr">
												<i class="cr-icon icofont icofont-ui-check txt-warning"></i>
											</span>
											<span> <?= ucwords($va) ?></span>
										</label>
									</div>
									<?php endforeach ?>
									<div class="checkbox-zoom zoom-warning">
										<button class="btn btn-info btn-round waves-effect waves-light fa fa-save" ></button>
									</div>
								</form>
								<?php endforeach ?>
							</div>
						</td>
						<?php else: ?>
						<td>
							<form action="<?= base_url('admin/permission/add') ?>" method="POST" class="access">
								<input type="hidden" name="menu" value="<?= str_replace('admin/', '', $m['name']) ?>">
								<input type="hidden" name="role" value="superadmin">
								<?php foreach (explode(',', $m['permissions']) as $ke => $va): ?>
								<div class="checkbox-zoom zoom-warning">
									<label>
										<input type="checkbox" <?= (strpos($access, '"role":"staff","menu":"'.$m['name'].'","operation":"'.$va.'"') !== false) ? 'checked' : '' ?> value="<?= $va ?>" name="operation[]" >
										<span class="cr">
											<i class="cr-icon icofont icofont-ui-check txt-warning"></i>
										</span>
										<span> <?= ucwords($va) ?></span>
									</label>
								</div>
								<?php endforeach ?>
								<div class="checkbox-zoom zoom-warning">
									<button class="btn btn-info btn-round waves-effect waves-light fa fa-save" ></button>
								</div>
							</form>
						</td>
						<?php endif ?>
					</tr>
					<?php endforeach ?>
			</table>
		</div>
		<input type="hidden" id="url" value="<?= base_url('admin/permission/get')?>">
	</div>
</div>


<!-- <input type="checkbox" <?= (strpos($access, '{"role":"'.$role['role'].'","menu":"'.$k.'","operation":"'.$va.'"}') !== false) ? 'checked' : '' ?> value="<?= $va ?>" name="operation[]"> -->

<?= (in_array($role['role'], $access) && in_array($k, $access) && in_array($va, $access) !== false) ? 'checked' : '' ?>

<input type="checkbox" <?= (strpos($access, '"role":'.$role['role'].',"menu":"'.$m['name'].'","operation":"'.$va.'"') !== false) ? 'checked' : '' ?> value="<?= $va ?>" name="operation[]" >