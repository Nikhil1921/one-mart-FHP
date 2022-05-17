<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">View <?= ucwords($name) ?></h2>
		<div class="form-group row">
			<div class="col-sm-2">
				<label class="col-form-label">Menu Name</label>
			</div>
			<div class="col-sm-4">
				<input class="form-control" value="<?= $menu_detail['name'] ?>" readonly>
			</div>
			<div class="col-sm-2">
				<label class="col-form-label">Menu URL</label>
			</div>
			<div class="col-sm-4">
				<input class="form-control" value="<?= $menu_detail['menu_url'] ?>" readonly>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2">
				<label class="col-form-label">Menu Icon</label>
			</div>
			<div class="col-sm-4">
				<a href=""><i class="feather icon-<?= ($menu_detail['icon']) ? $menu_detail['icon'] : 'menu' ?>"></i></a>
			</div>
		</div>
		<?php if ($menu_detail['sub_menu']): ?>
		<?php foreach ($menu_detail['sub_menu'] as $k => $v): ?>
		<div class="form-group row">
			<div class="col-sm-2">
				<label class="col-form-label">Sub Menu Name</label>
			</div>
			<div class="col-sm-4">
				<input class="form-control" value="<?= $k ?>" readonly>
			</div>
			<div class="col-sm-2">
				<label class="col-form-label">Sub Menu URL</label>
			</div>
			<div class="col-sm-4">
				<input class="form-control" value="<?= $v ?>" readonly>
			</div>
		</div>
		<?php endforeach ?>
		<?php endif ?>
		<div class="form-group row">
			<div class="col-sm-2">
				<label class="col-form-label" for="password">Permissions</label>
			</div>
			<div class="col-sm-10">
				<?php foreach ($menu_detail['permissions'] as $k => $v): ?>
				<div class="checkbox-zoom zoom-warning">
					<label>
						<input type="checkbox" value="<?= $v ?>" name="permissions[]" <?= (!empty(set_checkbox('permissions[]', $v))) ? set_checkbox('permissions[]', $v) : $v ? 'checked' : '' ?> disabled>
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
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/menu'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
			</div>
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/menu'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
			</div>
		</div>
	</div>
</div>