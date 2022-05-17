 <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/subCategory/add') ?>" method="POST" enctype="multipart/form-data" id="subcatForm">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="cat_id">Category Name</label>
						</div>
						<div class="col-sm-8">
							<select class="form-control" name="cat_id" id="cat_id">
								<option value="">Select Category</option>
								<?php foreach ($cats as $k => $v): ?>
									<option value="<?= $v['id'] ?>" <?= set_select('cat_id', $v['id'], False) ?>><?= ucwords($v['cat_name']) ?></option>
								<?php endforeach ?>
							</select>
							<?=  form_error('cat_id') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="sub_cat">Sub Category Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="sub_cat" id="sub_cat" placeholder="Sub Category Name" value="<?= set_value('sub_cat') ?>">
							<?=  form_error('sub_cat') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="image">Sub Category Icon</label>
						</div>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="image" id="image">
							<?=  (!empty($error)) ? $error : '' ?>
							<?= $this->upload->display_errors('<span class="custom_error">* ', '</span>') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/subCategory'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>