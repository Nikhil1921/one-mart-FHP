<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-wrapper">
	<div class="page-body">
		<div class="row">
			<div id="txt"></div>
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
<input type="hidden" id="url" value="<?= base_url('admin/orders/get')?>">
<input type="hidden" id="for_vendor" value="1">
<input type="hidden" id="number_hide" value="1">