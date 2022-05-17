<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="code">Promo Code</label>
					</div>
					<div class="col-sm-8">
						<input class="form-control" value="<?= $promo['code'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="discount">Discount %</label>
					</div>
					<div class="col-sm-8">
						<input class="form-control" value="<?= $promo['discount'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="details">Promo Code Details</label>
					</div>
					<div class="col-sm-8">
						<textarea class="form-control" disabled><?= $promo['details'] ?></textarea>
						<?=  form_error('details') ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="active">Active Promocode?</label>
					</div>
					<div class="col-sm-8 form-radio">
						<div class="radio radio-outline radio-inline">
							<label>
								<input type="radio" name="active" value="1" <?= ($promo['active'] == "1") ? 'checked' : '' ?> disabled>
								<i class="helper"></i>Yes
							</label>
						</div>
						<div class="radio radio-outline radio-inline">
							<label>
								<input type="radio" name="active" value="0" <?= ($promo['active'] == "0") ? 'checked' : '' ?> disabled>
								<i class="helper"></i>No
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="add-promocode row">
			<?php foreach (explode(',', $promo['mem_id']) as $k => $v): ?>
			<div class="col-md-6 remove-ser"><div class="form-group row"><div class="col-sm-4"><label class="col-form-label">Membership Name</label></div><div class="col-sm-8"><input type="text" value="<?= ucwords($this->main->check('membership',['id'=>$v], 'plan'))  ?>" class="form-control" disabled=""></div></div></div>
			<?php endforeach ?>
		</div>
		<div class="form-group row">
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/forMembership'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
			</div>
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/forMembership'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
			</div>
		</div>
	</div>
</div>