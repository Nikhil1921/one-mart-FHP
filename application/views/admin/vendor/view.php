<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">view <?= ucwords($name) ?></h2>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="cat_id">Vendor Service</label>
					</div>
					<div class="col-sm-8">
						<select class="js-example-placeholder-multiple col-sm-12" multiple="multiple" name="cat_id[]" disabled>
							<?php foreach ($cats as $k => $v): ?>
							<option value="<?= $v['id'] ?>" <?= (strpos($vendor['cat_id'], $v['id']) !== false) ? 'selected' : '' ?>><?= ucwords($v['cat_name']) ?></option>
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
						<input readonly type="text" class="form-control" value="<?= $vendor['username'] ?>">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="com_name">Company Name</label>
					</div>
					<div class="col-sm-8">
						<input readonly type="text" class="form-control" name="com_name" id="com_name" placeholder="Company Name" value="<?= $vendor['com_name'] ?>">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="image">Vendor Image</label>
					</div>
					<div class="col-sm-8">
						<img src="<?= base_url('assets/images/users/').$vendor['image'] ?>" height="70" width="70">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row location">
					<div class="col-sm-4">
						<label class="col-form-label" for="address">Vendor Address</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control geocomplete" name="address" id="address" placeholder="Vendor Address" value="<?= $vendor['address'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="email">Vendor Mail</label>
					</div>
					<div class="col-sm-8">
						<input readonly type="email" class="form-control" name="email" id="email" placeholder="Vendor Mail" value="<?= $vendor['email'] ?>">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="mobile">Vendor Mobile</label>
					</div>
					<div class="col-sm-8">
						<input readonly type="text" class="form-control" name="mobile" id="mobile" placeholder="Vendor Mobile" value="<?= $vendor['mobile'] ?>" pattern="[0-9]{10}" maxlength="10">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="gst">Vendor GST</label>
					</div>
					<div class="col-sm-8">
						<input readonly type="text" class="form-control" value="<?= $vendor['gst'] ?>">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label" for="gst_image">GST Image</label>
					</div>
					<div class="col-sm-8">
						<?php if ($vendor['gst_image'] != "No Image"): ?>
						<img src="<?= base_url('assets/images/gst/').$vendor['gst_image'] ?>"  height="70" width="70">
						<?php else: ?>
						<input readonly type="text" class="form-control" value="<?= $vendor['gst_image'] ?>">
						<?php endif ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">Vendor Photo/Address ID</label>
					</div>
					<div class="col-sm-8">
						<input readonly type="text" class="form-control" value="<?= $vendor['photo'] ?>">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">Photo/Address ID Image</label>
					</div>
					<div class="col-sm-8">
						<?php if ($vendor['photo_image'] != "No Image"): ?>
						<img src="<?= base_url('assets/images/photo/').$vendor['photo_image'] ?>"  height="70" width="70">
						<?php else: ?>
						<input readonly type="text" class="form-control" value="<?= $vendor['photo_image'] ?>">
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/vendor'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
			</div>
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/vendor'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
			</div>
		</div>
	</div>
</div>