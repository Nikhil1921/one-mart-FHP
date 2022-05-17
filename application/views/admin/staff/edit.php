<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Update <?= ucwords($name) ?></h2>
		<form action="<?= base_url('admin/staff/update/').$staff['id'] ?>" method="POST" enctype="multipart/form-data" id="userForm">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="role">User Role</label>
						</div>
						<div class="col-sm-8">
							<select name="role" class="form-control" id="role">
								<option value="">User Role</option>
								<?php foreach($role as $role): ?>
									<option <?= ( $role['role'] == set_value('role') || $role['role'] == $staff['role']) ? 'selected' : '' ?> value="<?= $role['role'] ?>" ><?= ucwords($role['role']) ?></option>
								<?php endforeach ?>
							</select>
							<?=  form_error('role') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6"></div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="username">User Name</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="username" id="username" placeholder="User Name" value="<?= (!empty(set_value('username'))) ? set_value('username') : $staff['username'] ?>">
							<?=  form_error('username') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="image">User Image</label>
						</div>
						<div class="col-sm-6">
							<input type="file" class="form-control" name="image" id="image">
							<?= $this->upload->display_errors('<span class="custom_error">* ', '</span>') ?>
						</div>
						<div class="col-sm-2">
							<img src="<?= base_url('assets/images/users/').$staff['image'] ?>" style="height: 50px; width: 50px;" >
							<input type="hidden" name="image" value="<?= $staff['image'] ?>">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="email">User Mail</label>
						</div>
						<div class="col-sm-8">
							<input type="email" class="form-control" name="email" id="email" placeholder="User Mail" value="<?= (!empty(set_value('email'))) ? set_value('email') : $staff['email'] ?>">
							<?=  form_error('email') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="mobile">User Mobile</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="mobile" id="mobile" placeholder="User Mobile" value="<?= (!empty(set_value('mobile'))) ? set_value('mobile') : $staff['mobile'] ?>" pattern="[0-9]{10}" maxlength="10">
							<?=  form_error('mobile') ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<div class="col-sm-4">
							<label class="col-form-label" for="password">User Password</label>
						</div>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="password" id="password" placeholder="User Password">
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
					<a href="<?= base_url('admin/staff'); ?>" class="btn btn-danger btn-round waves-effect waves-light fa fa-times"></a>
				</div>
			</div>
		</form>
	</div>
</div>