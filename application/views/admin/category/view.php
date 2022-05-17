<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/category/add') ?>" method="POST" enctype="multipart/form-data" id="catForm">
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
							<img src="<?= base_url('assets/images/category/').$cat['icon'] ?>" class="table-image" />
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="for_vendor">For Contract?</label>
						</div>
						<div class="col-sm-8 form-radio">
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="for_vendor" value="1" <?= ($cat['for_vendor'] == 1) ? 'checked' : '' ?> disabled>
									<i class="helper"></i>Yes
								</label>
							</div>
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="for_vendor" value="0" <?= ($cat['for_vendor'] == 0) ? 'checked' : '' ?> disabled>
									<i class="helper"></i>No
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="number_hide">Hide Number?</label>
						</div>
						<div class="col-sm-8 form-radio">
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="number_hide" value="1" <?= ($cat['number_hide'] == 1) ? 'checked' : '' ?> disabled>
									<i class="helper"></i>Yes
								</label>
							</div>
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="number_hide" value="0" <?= ($cat['number_hide'] == 0) ? 'checked' : '' ?> disabled>
									<i class="helper"></i>No
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="from_time">Service Timings</label>
						</div>
						<div class="col-sm-4">
							<input class="form-control time-picker" value="<?= $cat['from_time'] ?>" disabled>
							<?=  form_error('from_time') ?>
						</div>
						<div class="col-sm-4">
							<input class="form-control time-picker" value="<?= $cat['to_time'] ?>" disabled>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="price">Conract/Hide No. Price</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?= $cat['price'] ?>" disabled>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/category'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/category'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>