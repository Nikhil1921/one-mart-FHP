<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<div class="row card-block">
			<h4 class="sub form-control-info"><?= ucfirst($name) ?> List</h4>
		</div>
		<div class="table table-responsive">
			<table class="table table-striped table-hover table-bordered nowrap" id="dataTable">
				<thead>
					<tr>
						<th class="target">Sr No.</th>
						<th>Name</th>
						<th>Meeting Type</th>
						<th>Mobile</th>
						<th>Remarks</th>
						<th>Date</th>
						<th>Time</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
<input type="hidden" id="url" value="<?= base_url('admin/staff/meetings-get?u_id='.$u_id)?>">