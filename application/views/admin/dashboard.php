<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-wrapper">
	<div class="page-body">
		<div class="row">
			<div id="txt"></div>
			<?php if (access('services', 'index')): ?>
			<div class="col-md-12 col-xl-3">
				<a href="<?= base_url('admin/services') ?>">
					<div class="card comp-card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="m-b-25 dash-green">Services</h6>
									<h3 class="f-w-700 dash-green"><?= $this->main->count('services',['is_delete' => 'no']) ?></h3>
								</div>
								<div class="col-auto">
									<i class="fa fa-gear dash-green-icon"></i>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php endif ?>
			<?php if (access('inquiry', 'index')): ?>
			<div class="col-md-12 col-xl-3">
				<a href="<?= base_url('admin/inquiry') ?>">
					<div class="card comp-card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="m-b-25 dash-green">Inquiry</h6>
									<h3 class="f-w-700 dash-green"><?= $this->main->count('inquiry',['is_delete' => 'no']) ?></h3>
								</div>
								<div class="col-auto">
									<i class="fa fa-gear dash-green-icon"></i>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php endif ?>
			<?php if (access('vendors', 'index')): ?>
			<div class="col-md-12 col-xl-3">
				<a href="<?= base_url('admin/vendor') ?>">
					<div class="card comp-card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="m-b-25 dash-info">Vendors</h6>
									<h3 class="f-w-700 dash-info"><?= $this->main->count('vendor',['is_delete' => 'no']) ?></h3>
								</div>
								<div class="col-auto">
									<i class="fa fa-users dash-info-icon"></i>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php endif ?>
			<?php if (access('customers', 'index')): ?>
			<div class="col-md-12 col-xl-3">
				<a href="<?= base_url('admin/customers') ?>">
					<div class="card comp-card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="m-b-25 dash-warning">Customers</h6>
									<h3 class="f-w-700 dash-warning"><?= $this->main->count('customer',['is_delete' => 'no']) ?></h3>
								</div>
								<div class="col-auto">
									<i class="fa fa-users dash-warning-icon"></i>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php endif ?>
			<?php if (access('dashboard', 'index')): ?>
			<div class="col-md-12 col-xl-3">
				<a href="<?= base_url('admin') ?>">
					<div class="card comp-card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="m-b-25 dash-warning-dark">Orders</h6>
									<h3 class="f-w-700 dash-warning-dark"><?= $this->main->count('bookings',['is_delete' => 'no', 'status'=>'completed']) ?></h3>
								</div>
								<div class="col-auto">
									<i class="fa fa-file-text-o dash-warning-dark-icon"></i>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php endif ?>
			<div class="col-md-12">
				<div class="card table-card">
					<div class="card-header">
					</div>
					<div class="col-md-12 tab-table">
						<ul class="nav nav-pills row" role="tablist">
							<li class="nav-item col">
								<a class="nav-link active btn-1" data-toggle="pill" href="#home">Pending</a>
							</li>
							<li class="nav-item col">
								<a class="nav-link btn-2" data-toggle="pill" href="#menu1">Ongoing</a>
							</li>
							<li class="nav-item col">
								<a class="nav-link btn-3" data-toggle="pill" href="#menu2">In Process</a>
							</li>
							<li class="nav-item col">
								<a class="nav-link btn-4" data-toggle="pill" href="#menu3">Completed</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="home" class="container tab-pane active"><br>
								<div class="card-block p-b-0">
									<div class="dt-responsive table-responsive card-block icon-btn">
										<table class="table table-striped table-bordered nowrap dom-table" data-status="pending">
											<input type="hidden" id="status" value="pending">
											<thead>
												<tr>
													<th>Name</th>
													<th>Book ID</th>
													<th>Mobile</th>
													<th class="target">Status</th>
													<th class="target">Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div id="menu1" class="container tab-pane fade"><br>
								<div class="card-block p-b-0">
									<div class="dt-responsive table-responsive card-block icon-btn">
										<table class="table table-striped table-bordered nowrap dom-table" data-status="ongoing">
											<thead>
												<tr>
													<th>Name</th>
													<th>Book ID</th>
													<th>Mobile</th>
													<th class="target">Status</th>
													<th class="target">Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div id="menu2" class="container tab-pane fade"><br>
								<div class="card-block p-b-0">
									<div class="dt-responsive table-responsive card-block icon-btn">
										<table class="table table-striped table-bordered nowrap dom-table" data-status="in process">
											<thead>
												<tr>
													<th>Name</th>
													<th>Book ID</th>
													<th>Mobile</th>
													<th class="target">Status</th>
													<th class="target">Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div id="menu3" class="container tab-pane fade"><br>
								<div class="card-block p-b-0">
									<div class="dt-responsive table-responsive card-block icon-btn">
										<table class="table table-striped table-bordered nowrap dom-table" data-status="completed">
											<thead>
												<tr>
													<th>Name</th>
													<th>Book ID</th>
													<th>Mobile</th>
													<th class="target">Status</th>
													<th class="target">Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="url" value="<?= base_url('admin/home/get')?>">
<input type="hidden" id="dashboard" value="dashboard">
<input type="hidden" id="for_vendor" value="0">
<input type="hidden" id="number_hide" value="0">