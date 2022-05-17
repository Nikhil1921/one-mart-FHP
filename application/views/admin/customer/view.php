<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">View <?= ucwords($name) ?></h2>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="cat_name">Customer Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $cust['name'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="cat_name">Customer Mobile</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $cust['mobile'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="cat_name">Customer Email</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $cust['email'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="cat_name">Customer Balance</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?= $cust['balance'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="cat_name">Customer Home Address</label>
					</div>
					<div class="col-sm-8">
						<textarea class="form-control" rows="5" disabled><?= $cust['home_address'] ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/customers'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
			</div>
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/customers'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
			</div>
		</div>
	</div>
</div>