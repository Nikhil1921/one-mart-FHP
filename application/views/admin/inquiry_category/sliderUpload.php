<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-block">
		<h2 class="sub-title form-control-info">Upload Images</h2>
		<form action="<?= base_url('admin/inquiryCategory/sliderUpload/'.$id) ?>" class="dropzone">
			<div class="fallback">
				<input name="image" type="file" multiple accept="image/jpg,image/jpeg,image/png"/>
			</div>
		</form>
		<br>
		<div class="col-md-12">
			<a href="<?= base_url('admin/inquiryCategory'); ?>" class="btn btn-info btn-round waves-effect waves-light fa fa-check"></a>
		</div>
		<br>
		<?php if ($slider_images != 'No Image'): ?>
		<div class="row">
			<?php foreach (json_decode($slider_images) as $k => $img): ?>
			<div class="col-md-4 mb-4" id="<?= $k ?>_remove">
				<img src="<?= base_url('assets/images/inquiry_category/'.$img) ?>" alt="" class="col-md-8">
				<button type="button" class="btn btn-danger btn-round waves-effect waves-light fa fa-trash col-md-2 remove-image" data-id="<?= $img ?>" data-remove="<?= $k ?>_remove"></button>
			</div>
			<?php endforeach ?>
		</div>
		<?php endif ?>
		<input type="hidden" id="cat-id" value="<?= $id ?>">
		<input type="hidden" id="slider-url" value="<?= base_url('admin/inquiryCategory/removeSlider') ?>">
	</div>
</div>