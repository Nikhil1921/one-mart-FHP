<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/membership/add') ?>" method="POST" id="membershipForm" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="plan">Plan Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="plan" id="plan" placeholder="Plan Name" value="<?= set_value('plan') ?>">
							<?=  form_error('plan') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="price">Plan Price</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="price" id="price" placeholder="Plan Price" value="<?= set_value('price') ?>">
							<?=  form_error('price') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="details">Plan Details</label>
						</div>
						<div class="col-sm-8">
							<textarea class="form-control" name="details" id="details" placeholder="Plan Details" rows="6"><?= set_value('details') ?></textarea>
							<?=  form_error('details') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="active">Active Membership?</label>
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
							<label class="col-form-label" for="image">Membership Image</label>
						</div>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="image" id="image">
							<?= $this->upload->display_errors('<span class="text-danger">* ', '</span>') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="time_period">Time Period (In Months)</label>
						</div>
						<div class="col-sm-8">
							<input type="number" class="form-control" name="time_period" id="time_period" placeholder="Time Period (In Months)" value="<?= set_value('time_period') ?>">
							<?=  form_error('time_period') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="use_count">Use Count</label>
						</div>
						<div class="col-sm-8">
							<input type="number" class="form-control" name="use_count" id="use_count" placeholder="Use Count" value="<?= set_value('use_count') ?>">
							<?=  form_error('use_count') ?>
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
					<a href="<?= base_url('admin/membership'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>
<input type="hidden" id="caturl" value="<?= base_url('admin/services/subCats') ?>">
<input type="hidden" id="serviceurl" value="<?= base_url('admin/services/services') ?>">