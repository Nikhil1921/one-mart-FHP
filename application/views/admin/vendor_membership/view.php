<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">View <?= ucwords($name) ?></h2>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">Plan Name</label>
					</div>
					<div class="col-sm-8">
						<input class="form-control" value="<?= $member['plan'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">Plan Price</label>
					</div>
					<div class="col-sm-8">
						<input class="form-control" value="<?= $member['price'] ?>" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">Plan Details</label>
					</div>
					<div class="col-sm-8">
						<textarea class="form-control" disabled><?= $member['details'] ?></textarea>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">Active Membership?</label>
					</div>
					<div class="col-sm-8 form-radio">
						<div class="radio radio-outline radio-inline">
							<label>
								<input type="radio" value="1" <?= ($member['active'] == '1') ? 'checked' : '' ?> disabled>
								<i class="helper"></i>Yes
							</label>
						</div>
						<div class="radio radio-outline radio-inline">
							<label>
								<input type="radio" value="0" <?= ($member['active'] == '0') ? 'checked' : '' ?> disabled>
								<i class="helper"></i>No
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">Membership Image</label>
					</div>
					<div class="col-sm-8 view-image">
						<img src="<?= base_url('assets/images/membership/').$member['image'] ?>">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-sm-4">
						<label class="col-form-label">Time Period(In Months)</label>
					</div>
					<div class="col-sm-8">
						<input class="form-control" value="<?= $member['time_period'] ?> (Months)" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-2">
						<label class="col-form-label" for="ser_id[]">Categories</label>
					</div>
					<div class="col-md-10">
						<?php foreach (explode(',', $member['ser_id']) as $k => $v): ?>
						<div class="checkbox-zoom zoom-warning col-md-3">
							<label>
								<input type="checkbox" checked="" disabled="">
								<span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-warning"></i>
								</span>
								<span> <?= ucwords($this->main->check("categories", ['id'=>$v], 'cat_name')) ?></span>
							</label>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/vendorMembership'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
			</div>
			<div class="col-sm-2 offset-3">
				<a href="<?= base_url('admin/vendorMembership'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
			</div>
		</div>
	</div>
</div>