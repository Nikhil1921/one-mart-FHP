<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-header">
    <h5><?= $operation ?></h5>
</div>
<div class="card-body">
    <?= form_open_multipart(''); ?>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <?= form_label('Upload images', 'cat_id', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "file",
                        'id' => "image",
                        'name' => "image[]",
                        'accept' => "image/png, image/jpeg, image/jpg",
                        'onchange' => 'this.form.submit()',
                        'multiple' => 'multiple'
                    ]); ?>
                </div>
            </div>
        </div>
    <?= form_close(); ?>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <?php foreach($imgs as $i => $img): $i++ ?>
                    <div class="col-3">
                        <?= img($this->path.$img) ?>
                        <?= form_open("$url/remove_image", 'id="'.($i+$id).'"', ['id' => $id, 'img' => $img]).
                        '<a class="btn btn-outline-danger col-12" onclick="script.delete('.($i+$id).'); return false;" href="javascript:;">Click to delete</a>'.
                        form_close(); ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="col-3 mt-4">
            <?= anchor("$url", 'Go Back', 'class="btn btn-outline-danger col-12"'); ?>
        </div>
    </div>
</div>