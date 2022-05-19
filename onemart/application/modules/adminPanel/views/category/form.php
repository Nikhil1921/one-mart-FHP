<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-header">
    <h5><?= $title ?> <?= $operation ?></h5>
</div>
<div class="card-body">
    <?= form_open_multipart('', '', ['image' => isset($data['image']) ? $data['image'] : '']) ?>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <?= form_label('Category Name', 'cat_name', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "text",
                        'id' => "cat_name",
                        'name' => "cat_name",
                        'maxlength' => 50,
                        'onkeyup' => "document.getElementById('cat_slug').value = this.value.trim().replaceAll(' ', '-')",
                        'required' => "",
                        'value' => set_value('cat_name') ? set_value('cat_name') : (isset($data['cat_name']) ? $data['cat_name'] : '')
                    ]); ?>
                    <?= form_error('cat_name') ?>
                </div>
            </div>
            <div class="col-<?= (isset($data['image'])) ? 4 : 6 ?>">
                <div class="form-group">
                    <?= form_label('Image <span class="text-danger">(Size should be 250*250)</span>', 'image', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "file",
                        'id' => "image",
                        'name' => "image",
                    ]); ?>
                </div>
            </div>
            <?php if (isset($data['image'])): ?>
                <div class="col-2">
                    <?= img(['src' => $this->path.$data['image'], 'width' => '100%', 'height' => '70']); ?>
                </div>
            <?php endif ?>
            <div class="col-12"></div>
            <div class="col-3">
                <?= form_button([
                    'type'    => 'submit',
                    'class'   => 'btn btn-outline-primary btn-block col-12',
                    'content' => 'SAVE'
                ]); ?>
            </div>
            <div class="col-3">
                <?= anchor("$url", 'CANCEL', 'class="btn btn-outline-danger col-12"'); ?>
            </div>
        </div>
    <?= form_close() ?>
</div>