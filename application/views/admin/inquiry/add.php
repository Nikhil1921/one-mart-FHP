<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/inquiry/add') ?>" method="POST" enctype="multipart/form-data" id="serviceForm">
			<div class="row">
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
							<?=  form_error('cat_id') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="sub_cat_id">Sub Category Name</label>
						</div>
						<div class="col-sm-8">
							<select name="sub_cat_id" class="form-control" id="sub_cat_id">
								<option value="">Select Sub Category</option>
							</select>
							<?=  form_error('sub_cat_id') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="name">Service Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="name" id="name" placeholder="Service Name" value="<?= set_value('name') ?>">
							<?=  form_error('name') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="image">Service Image</label>
						</div>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="image" id="image">
							<?=  (!empty($error)) ? $error : '' ?>
							<?= $this->upload->display_errors('<span class="custom_error">* ', '</span>') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="description">Service Description</label>
						</div>
						<div class="col-sm-8">
							<textarea name="description" id="description" class="form-control" placeholder="Service Description"><?= set_value('description') ?></textarea>
							<?=  form_error('description') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="conditions">Service Conditions</label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="conditions" id="conditions" placeholder="Service Condition">
							<?=  form_error('conditions[]') ?>
						</div>
						<div class="col-sm-2">
							<button type="button" class="btn btn-primary btn-round waves-effect waves-light fa fa-plus" id="add-condition"></button>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="row" id="view-condition">
						<!-- <div class="col-md-6" id="'++'">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="col-form-label" for="">Service Conditions</label>
								</div>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="conditions[]" id="'++'" value="'++'" />
								</div>
								<div class="col-sm-2">
									<button type="button" class="btn btn-danger btn-round waves-effect waves-light fa fa-minus remove-condition" data-id="'++'"></button>
								</div>
							</div>
						</div> -->
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/inquiry'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>
<input type="hidden" id="caturl" value="<?= base_url('admin/inquiry/subCats') ?>">