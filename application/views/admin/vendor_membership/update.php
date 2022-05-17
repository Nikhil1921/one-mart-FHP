<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Update <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/vendorMembership/update/').$member['id'] ?>" method="POST" id="membershipForm" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="plan">Plan Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="plan" id="plan" placeholder="Plan Name" value="<?= (!empty(set_value('plan'))) ? set_value('plan') : $member['plan'] ?>">
							<?=  form_error('plan') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="price">Plan Price</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="price" id="price" placeholder="Plan Price" value="<?= (!empty(set_value('price'))) ? set_value('price') : $member['price'] ?>">
							<?=  form_error('price') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="details">Plan Details</label>
						</div>
						<div class="col-sm-8">
							<textarea class="form-control" name="details" id="details" placeholder="Plan Details" rows="6"><?= (!empty(set_value('details'))) ? set_value('details') : $member['details'] ?></textarea>
							<?=  form_error('details') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="active">Active Membership?</label>
						</div>
						<div class="col-sm-8 form-radio">
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="active" value="1" <?= (set_value('active') == '1' || $member['active'] == '1') ? 'checked' : '' ?>>
									<i class="helper"></i>Yes
								</label>
							</div>
							<div class="radio radio-outline radio-inline">
								<label>
									<input type="radio" name="active" value="0" <?= (set_value('active') == '0' || $member['active'] == '0') ? 'checked' : '' ?>>
									<i class="helper"></i>No
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="image">Membership Image</label>
						</div>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="image" id="image">
							<input type="hidden" class="form-control" name="image" value="<?= $member['image'] ?>">
							<?= $this->upload->display_errors('<span class="text-danger">* ', '</span>') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label">Current Image</label>
						</div>
						<div class="col-sm-8 view-image">
							<img src="<?= base_url('assets/images/membership/').$member['image'] ?>">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="time_period">Time Period(In Months)</label>
						</div>
						<div class="col-sm-8">
							<input type="number" class="form-control" name="time_period" id="time_period" placeholder="Time Period (In Months)" value="<?= (!empty(set_value('time_period'))) ? set_value('time_period') : $member['time_period'] ?>">
							<?=  form_error('time_period') ?>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group row">
						<div class="col-md-2">
							<label class="col-form-label" for="ser_id[]">Categories</label>
						</div>
						<div class="col-md-10">
							<?php foreach ($cats as $k => $v): ?>
							<div class="checkbox-zoom zoom-warning col-md-3">
								<label>
									<input type="checkbox" value="<?= $v['id'] ?>" name="ser_id[]" <?= (!empty(set_checkbox('ser_id[]', $v['id']))) ? set_checkbox('ser_id[]', $v['id']) : (in_array($v['id'], explode(',', $member['ser_id']))) ? 'checked' : '' ?> >
									<span class="cr">
										<i class="cr-icon icofont icofont-ui-check txt-warning"></i>
									</span>
									<span> <?= ucwords($v['cat_name']) ?></span>
								</label>
							</div>
							<?php endforeach ?>
							<?=  form_error('ser_id[]') ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin/vendorMembership'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>