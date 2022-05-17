<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Update <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/role/update/').$role['id'] ?>" method="POST" enctype="multipart/form-data" id="role_form">
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="role">Role Name</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="role" id="role" placeholder="Role Name" value="<?= (!empty(set_value('role'))) ? set_value('role') : $role['role'] ?>">
					<?=  form_error('role') ?>
				</div>
			</div>
			<div class="form-group row">
			<div class="col-sm-2">
				<label class="col-form-label" for="password">Permissions</label>
			</div>
			<div class="col-sm-10">
				<?php $menu = explode(',', $permissions); foreach ($menu as $k => $v): ?>
				<div class="checkbox-zoom zoom-warning">
					<label>
						<input type="checkbox" value="<?= $v ?>" name="permissions[]" <?= (!empty(set_checkbox('permissions[]', $v))) ? set_checkbox('permissions[]', $v) : (in_array($v, explode(',', $role['permissions']))) ? 'checked' : '' ?>>
						<span class="cr">
							<i class="cr-icon icofont icofont-ui-check txt-warning"></i>
						</span>
						<span> <?= ucwords($v) ?></span>
					</label>
				</div>
				<?php endforeach ?>
			</div>
		</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-4">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2">
					<a href="<?= base_url('admin/role'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>