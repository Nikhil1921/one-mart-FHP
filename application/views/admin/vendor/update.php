<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Add <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/vendor/update/').$vendor['id'] ?>" method="POST" enctype="multipart/form-data" id="vendorForm">
			<div class="row">
				<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="cat_id">Vendor Service</label>
					</div>
					<div class="col-sm-8">
						
						<select class="js-example-placeholder-multiple col-sm-12" multiple="multiple" name="cat_id[]">
							<?php foreach ($cats as $k => $v): ?>
							<option value="<?= $v['id'] ?>" <?= ( set_select('cat_id', $v['id']) || (strpos($vendor['cat_id'], $v['id']) !== false)) ? 'selected' : '' ?>><?= ucwords($v['cat_name']) ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6"></div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="username">Vendor Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="username" id="username" placeholder="Vendor Name" value="<?= (!empty(set_value('username'))) ? set_value('username') : $vendor['username'] ?>">
							<?=  form_error('username') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="com_name">Company Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="com_name" id="com_name" placeholder="Company Name" value="<?= (!empty(set_value('com_name'))) ? set_value('com_name') : $vendor['com_name'] ?>">
							<?=  form_error('com_name') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="image">Vendor Image</label>
						</div>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="image" id="image">
							<input type="hidden" name="image" value="<?= $vendor['image']?> ">
							<?= $this->upload->display_errors('<span class="custom_error">* ', '</span>') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row location">
						<div class="col-sm-4">
							<label class="col-form-label" for="address">Vendor Address</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control geocomplete" name="address" id="address" placeholder="Vendor Address" value="<?= (!empty(set_value('address'))) ? set_value('address') : $vendor['address'] ?>">
							<fieldset class="details" style="display: none;">
								<input class="form-control" name="lat" type="text" value="<?= set_value('lat') ? set_value('lat') : $vendor['lat'] ?>" />
								<input class="form-control" name="lng" type="text" value="<?= set_value('lng') ? set_value('lng') : $vendor['lng'] ?>" />
			                    <input class="form-control" name="sublocality" type="text" value="<?= (!empty(set_value('sublocality'))) ? set_value('sublocality') : $vendor['area'] ?>"/>
			                    <input class="form-control" name="locality" id="locality" type="text" value="<?= (!empty(set_value('locality'))) ? set_value('locality') : $vendor['city'] ?>" >
			                    <input class="form-control" name="administrative_area_level_1" id="administrative_area_level_1" type="text" value="<?= (!empty(set_value('administrative_area_level_1'))) ? set_value('administrative_area_level_1') : $vendor['state'] ?>">
			                </fieldset>
							<?=  form_error('address') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="email">Vendor Mail</label>
						</div>
						<div class="col-sm-8">
							<input type="email" class="form-control" name="email" id="email" placeholder="Vendor Mail" value="<?= (!empty(set_value('email'))) ? set_value('email') : $vendor['email'] ?>">
							<?=  form_error('email') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="mobile">Vendor Mobile</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Vendor Mobile" value="<?= (!empty(set_value('mobile'))) ? set_value('mobile') : $vendor['mobile'] ?>" pattern="[0-9]{10}" maxlength="10">
							<?=  form_error('mobile') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="password">Vendor Password</label>
						</div>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="password" id="password" placeholder="Vendor Password">
							<?=  form_error('password') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="c_password">Confirm Password</label>
						</div>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="c_password" id="c_password" placeholder="Confirm Password">
							<?=  form_error('c_password') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/vendor'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>