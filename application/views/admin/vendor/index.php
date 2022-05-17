<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<div class="row card-block">
			<h4 class="sub form-control-info"><?= ucfirst($name) ?> List</h4>
			<div class="col-12 row">
				<div class="col-9"></div>
				<div class="col-2">
					<select class="form-control" id="cust-status">
						<option value="no">Active</option>
						<option value="yes">Blocked</option>
					</select>
				</div>
				<div class="col-1">
					<a href="<?= base_url('admin/vendor/add'); ?>" class="btn btn-success btn-round waves-effect waves-light fa fa-plus"></a>
				</div>
			</div>
		</div>
		<div class="table table-responsive">
			<table class="table table-striped table-hover table-bordered nowrap" id="dataTable">
				<thead>
					<tr>
						<th class="target">Sr No.</th>
						<th>Vendor</th>
						<th>Company</th>
						<th>Mobile</th>
						<th>Email</th>
						<th>GST</th>
						<th class="target">Approval</th>
						<th class="target">Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<input type="hidden" id="url" value="<?= base_url('admin/vendor/get')?>">
	</div>
</div>