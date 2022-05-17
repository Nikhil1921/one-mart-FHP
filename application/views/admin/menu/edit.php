<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Update <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/menu/update/').$menu_detail['id'] ?>" method="POST" id="menu_form">
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="name">Menu Name</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="name" id="name" placeholder="Menu Name" value="<?= (!empty(set_value('name'))) ? set_value('name') : $menu_detail['name'] ?>">
					<?=  form_error('name') ?>
				</div>
				<div class="col-sm-2">
					<label class="col-form-label" for="menu_url">Menu URL</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="menu_url" id="menu_url" placeholder="Menu URL" value="<?= (!empty(set_value('menu_url'))) ? set_value('menu_url') : $menu_detail['menu_url'] ?>">
					<?=  form_error('menu_url') ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="name">Menu Icon</label>
				</div>
				<div class="col-sm-4">
					<select class="selectpicker" name="icon">
						<?php foreach ($feather as $k => $v): ?>
							<option data-content="<i class='feather icon-<?= $v['icon'] ?>' aria-hidden='true'></i><?= ucwords($v['icon']) ?>" <?= ( $v['icon'] == set_value('icon') || $v['icon'] == $menu_detail['icon']) ? 'selected' : '' ?> value="<?= $v['icon'] ?>"></option>	
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
			
			<?php if ($menu_detail['sub_menu']): ?>
				<?php foreach ($menu_detail['sub_menu'] as $k => $v): ?>
					<div class="form-group row">
						<div class="col-sm-2">
							<label class="col-form-label" for="sub_menu_<?= $k ?>">Sub Menu Name</label>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="sub_menu[]" id="sub_menu_<?= $k ?>" value="<?= $k ?>">
						</div>
						<div class="col-sm-2">
							<label class="col-form-label" for="sub_url_<?= $v ?>">Sub Menu URL</label>
						</div>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="sub_url[]" id="sub_url_<?= $v ?>" value="<?= $v ?>">
						</div>
						<div class="col-sm-1">
							<button type="button" class="btn btn-danger btn-round waves-effect waves-light fa fa-minus remove-button"></button>
						</div>
					</div>
				<?php endforeach ?>				
			<?php endif ?>

			<div class="add-sub_menu"></div>
			<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label" for="permissions">Permissions</label>
				</div>
				<div class="col-sm-10">
					<?php foreach ($ope as $k => $v): ?>
						<div class="checkbox-zoom zoom-warning">
							<label>
								<input type="checkbox" value="<?= $v['type'] ?>" name="permissions[]" <?= (!empty(set_checkbox('permissions[]', $v['type']))) ? set_checkbox('permissions[]', $v['type']) : (in_array($v['type'], explode(',', $menu_detail['permissions']))) ? 'checked' : '' ?>>
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