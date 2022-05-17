<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/forSingle/add') ?>" method="POST" id="promoForm">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="code">Promo Code</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="code" id="code" placeholder="Promo Code" value="<?= set_value('code') ?>">
							<?=  form_error('code') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="discount">Discount %</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="discount" id="discount" placeholder="Discount %" value="<?= set_value('discount') ?>">
							<?=  form_error('discount') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="details">Promo Code Details</label>
						</div>
						<div class="col-sm-8">
							<textarea class="form-control" name="details" id="details" placeholder="Promo Code Details" rows="6"><?= set_value('details') ?></textarea>
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
									<input type="radio" name="active" value="1" <?= set_radio('active', '1', TRUE); ?>>
									<i class="helper"></i>Yes
								</label>
							</div>
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="active" value="0" <?= set_radio('active', '0', TRUE); ?>>
									<i class="helper"></i>No
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="cat_id">Category Name</label>
						</div>
						<div class="col-sm-8">
							<select class="form-control category" name="cat_id" id="cat_id" data-dependent="sub_cat_id" data-value="<?= set_value('sub_cat_id') ?>">
								<option value="">Select Category</option>
								<?php foreach ($cats as $k => $v): ?>
								<option value="<?= $v['id'] ?>" <?= set_select('cat_id', $v['id'], False) ?>><?= ucwords($v['cat_name']) ?></option>
								<?php endforeach ?>
							</select>
							<?=  form_error('ser_id[][][]') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="sub_cat_id">Sub Category Name</label>
						</div>
						<div class="col-sm-8">
							<select name="sub_cat_id" class="form-control sub_cat_id" id="sub_cat_id">
								<option value="">Select Sub Category</option>
							</select>
							<?=  form_error('sub_cat_id') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="view-service"></div>
			<div class="add-service"></div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/forSingle'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>
<input type="hidden" id="caturl" value="<?= base_url('admin/services/subCats') ?>">
<input type="hidden" id="serviceurl" value="<?= base_url('admin/services/services') ?>">