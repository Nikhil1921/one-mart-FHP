<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<div class="row card-block">
			<h4 class="sub form-control-info"><?= ucfirst($name) ?> List</h4>
			<div class="col-12 row">
				<div class="col-8"></div>
				<div class="col-4">
					<form action="<?= base_url('admin/banner/add') ?>" method="POST" enctype="multipart/form-data" id="bannerForm">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-sm-8">
										<input type="file" class="form-control" name="image" id="image" >
										<?= (!empty($error)) ? $error : ''?>
										<?= $this->upload->display_errors('<span class="custom_error">* ', '</span>') ?>
									</div>
									<div class="col-sm-4">
										<button type="submit" class="btn btn-success btn-round waves-effect waves-light fa fa-plus"></button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="table table-responsive">
			<table class="table table-striped table-hover table-bordered nowrap" id="dataTable">
				<thead>
					<tr>
						<th class="target">Sr No.</th>
						<th class="target">Banner</th>
						<th class="target">Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<input type="hidden" id="url" value="<?= base_url('admin/banner/get')?>">
	</div>
</div>