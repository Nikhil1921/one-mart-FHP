<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/role/store') ?>" method="POST" enctype="multipart/form-data" id="role_form">
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="role">Role Name</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="role" id="role" placeholder="Role Name" value="<?= set_value('role') ?>">
					<?=  form_error('role') ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="permissions[]">Permissions</label>
				</div>
				<div class="col-sm-10">
					<?php $menu = explode(',', $permissions); foreach ($menu as $k => $v): ?>
						<div class="checkbox-zoom zoom-warning">
							<label>
								<input type="checkbox" value="<?= $v ?>" name="permissions[]" <?= set_checkbox('permissions[]', $v) ?>>
								<span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-warning"></i>
								</span>
								<span> <?= ucwords($v) ?></span>
							</label>
						</div>							
					<?php endforeach ?>
					<?=  form_error('permissions[]') ?>
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