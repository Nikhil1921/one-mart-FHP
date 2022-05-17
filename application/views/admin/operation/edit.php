<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Update <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/operation/update/').$op['id'] ?>" method="POST" id="operation_form">
			<div class="form-group row offset-3">
				<div class="col-sm-2">
					<label class="col-form-label" for="type">Operation Type</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="type" id="type" placeholder="Operation Type" value="<?= (!empty(set_value('type'))) ? set_value('type') : $op['type'] ?>">
					<?=  form_error('type') ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-4">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2">
					<a href="<?= base_url('admin/operation'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>