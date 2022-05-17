<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Update <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/category/update/').$cat['id'] ?>" method="POST" enctype="multipart/form-data" id="catForm">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="cat_name">Category Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="Category Name" value="<?= (!empty(set_value('cat_name'))) ? set_value('cat_name') : $cat['cat_name'] ?>">
							<?=  form_error('cat_name') ?>
						</div>
					</div>
				</div>
				<!-- <div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="details">Category Details</label>
						</div>
						<div class="col-sm-8">
							<textarea class="form-control" name="details" id="details" placeholder="Category Details"><?= (!empty(set_value('details'))) ? set_value('details') : $cat['details'] ?></textarea>
							<?=  form_error('details') ?>
						</div>
					</div>
				</div> -->
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="image">Category Image</label>
						</div>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="image" id="image">
							<input type="hidden" class="form-control" name="icon" value="<?= $cat['icon'] ?>">
							<?= $this->upload->display_errors('<span class="custom_error">* ', '</span>') ?>
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
									<input type="radio" name="for_vendor" value="1" <?= (set_value('for_vendor') == '1' || $cat['for_vendor'] == '1') ? "checked" : "" ?>>
									<i class="helper"></i>Yes
								</label>
							</div>
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="for_vendor" value="0" <?= (set_value('for_vendor') == '0' || $cat['for_vendor'] == '0') ? "checked" : "" ?>>
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
									<input type="radio" name="number_hide" value="1" <?= (set_value('number_hide') == '1' || $cat['number_hide'] == '1') ? "checked" : "" ?>>
									<i class="helper"></i>Yes
								</label>
							</div>
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="number_hide" value="0" <?= (set_value('number_hide') == '0' || $cat['number_hide'] == '0') ? "checked" : "" ?>>
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
							<input type="text" class="form-control time-picker" name="from_time" id="from_time" data-format="hh:mm" placeholder="From" value="<?= (!empty(set_value('from_time'))) ? set_value('from_time') : $cat['from_time'] ?>">
							<?=  form_error('from_time') ?>
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control time-picker" name="to_time" id="to_time" data-format="hh:mm" placeholder="To" value="<?= (!empty(set_value('to_time'))) ? set_value('to_time') : $cat['to_time'] ?>">
							<?=  form_error('to_time') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="price">Conract/Hide No. Price</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="price" id="price" placeholder="Category Name" value="<?= (!empty(set_value('price'))) ? set_value('price') : $cat['price'] ?>">
							<?=  form_error('price') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/category'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>