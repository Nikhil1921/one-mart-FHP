<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="cat_name">Category Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $cat['cat_name'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="icon">Category Icon</label>
					</div>
					<div class="col-sm-8">
						<img src="<?= base_url('assets/images/inquiry_category/').$cat['icon'] ?>" class="table-image" />
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/inquiryCategory'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
			</div>
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/inquiryCategory'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
			</div>
		</div>
	</div>
</div>