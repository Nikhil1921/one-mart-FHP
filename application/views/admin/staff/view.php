<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<div class="form-group row">
				<div class="col-sm-2">
					<label class="col-form-label">User Role</label>
				</div>
				<div class="col-sm-4">
					<input class="form-control" value="<?= $staff['role'] ?>" readonly>
				</div>
			</div>
		<div class="form-group row">
			<div class="col-sm-2">
				<label class="col-form-label" >User Name</label>
			</div>
			<div class="col-sm-4">
				<input class="form-control" value="<?= $staff['username'] ?>" readonly>
			</div>
			<div class="col-sm-2">
				<label class="col-form-label" for="image">User Image</label>
			</div>
			<div class="col-sm-4">
				<img src="<?= base_url('assets/images/users/').$staff['image'] ?>" style="height: 75px; width: 75px;" >
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2">
				<label class="col-form-label">User Mail</label>
			</div>
			<div class="col-sm-4">
				<input class="form-control" value="<?= $staff['email'] ?>" readonly>
			</div>
			<div class="col-sm-2">
				<label class="col-form-label">User Mobile</label>
			</div>
			<div class="col-sm-4">
				<input class="form-control" value="<?= $staff['mobile'] ?>" readonly>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/staff'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
			</div>
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/staff'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
			</div>
		</div>
	</div>
</div>