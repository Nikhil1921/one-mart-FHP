<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<?php foreach ($roles as $k => $v): ?>
	<div class="col-xl-3 col-md-6">
		<div class="card prod-p-card card-red">
			<a href="<?= base_url('admin/permission/create/').$v['id'] ?>">
				<div class="card-body">
					<div class="row align-items-center m-b-30">
						<div class="col">
							<h6 class="m-b-5 text-white"><?= ucwords($v['role']) ?></h6>
							<h3 class="m-b-0 f-w-700 text-white"></h3>
						</div>
						<div class="col-auto">
							<i class="fa fa-users text-c-red f-18"></i>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<?php endforeach ?>
</div>