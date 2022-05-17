<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/inquiryCategory/add') ?>" method="POST" enctype="multipart/form-data" id="catForm">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="cat_name">Category Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="Category Name" value="<?= set_value('cat_name') ?>">
							<?=  form_error('cat_name') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="cat_price">Category Price</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="cat_price" id="cat_price" placeholder="Category Price" value="<?= set_value('cat_price') ?>">
							<?=  form_error('cat_price') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="image">Category Icon</label>
						</div>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="image" id="image">
							<?=  (!empty($error)) ? $error : '' ?>
							<?= $this->upload->display_errors('<span class="custom_error">* ', '</span>') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/inquiryCategory'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>