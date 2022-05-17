<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/menu/store') ?>" method="POST" id="menu_form">
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="name">Menu Name</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="name" id="name" placeholder="Menu Name" value="<?= set_value('name') ?>">
					<?=  form_error('name') ?>
				</div>
				<div class="col-sm-2">
					<label class="col-form-label" for="menu_url">Menu URL</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="menu_url" id="menu_url" placeholder="Menu URL" value="<?= set_value('menu_url') ?>">
					<?=  form_error('menu_url') ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="icon">Menu Icon</label>
				</div>
				<div class="col-sm-4">
					<select class="selectpicker" name="icon">
						<?php foreach ($feather as $k => $v): ?>
						<option data-content="<i class='feather icon-<?= $v['icon'] ?>' aria-hidden='true'></i><?= ucwords($v['icon']) ?>" <?= set_value('icon') ?> value="<?= $v['icon'] ?>"></option>
						<?php endforeach ?>
					</select>
					<?=  form_error('icon') ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="sub_menu">Sub Menu Name</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="sub_menu" id="sub_menu" placeholder="Sub Menu Name">
				</div>
				<div class="col-sm-2">
					<label class="col-form-label" for="sub_url">Sub Menu URL</label>
				</div>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="sub_url" id="sub_url" placeholder="Sub Menu URL">
				</div>
				<div class="col-sm-1">
					<button type="button" class="btn btn-primary btn-round waves-effect waves-light fa fa-plus" id="add-sub_menu"></button>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="permissions[]">Permissions</label>
				</div>
				<div class="col-sm-10">
					<?php foreach ($ope as $k => $v): ?>
						<div class="checkbox-zoom zoom-warning">
							<label>
								<input type="checkbox" value="<?= $v['type'] ?>" name="permissions[]" <?= set_checkbox('permissions[]', $v['type'], false) ?> >
								<span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-warning"></i>
								</span>
								<span> <?= ucwords($v['type']) ?></span>
							</label>
						</div>							
					<?php endforeach ?>
					<?=  form_error('permissions[]') ?>
				</div>
			</div>
			<div class="add-sub_menu"></div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/menu'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>