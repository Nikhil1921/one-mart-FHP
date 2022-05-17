<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">View <?= ucwords($name) ?></h2>
		<div class="form-group row">
			<div class="col-sm-2 offset-3">
				<label class="col-form-label">Operation Type</label>
			</div>
			<div class="col-sm-4">
				<input class="form-control" value="<?= $op['type'] ?>" readonly>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2 offset-4">
				<a href="<?= base_url('admin/operation'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
			</div>
			<div class="col-sm-2">
				<a href="<?= base_url('admin/operation'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
			</div>
		</div>
	</div>
</div>