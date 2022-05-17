<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="product__modal-inner">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="product__modal-box">
                <div class="tab-content" id="modalTabContent">
                    <?php if ($prod->multi_image): ?>
                    <?php foreach (explode(', ', $prod->multi_image) as $k => $img): ?>
                    <div class="tab-pane fade <?= $k === 0 ? 'active show' : '' ?>" id="thumb<?= $k ?>" role="tabpanel" aria-labelledby="thumb<?= $k ?>-tab">
                        <div class="product__modal-img w-img">
                            <?= img($prod->base.$img); ?>
                        </div>
                    </div>
                    <?php endforeach ?>
                    <?php else: ?>
                        <div class="product__modal-img w-img">
                            <?= img(['src' => $prod->image, 'height' => 420]); ?>
                        </div>
                    <?php endif ?>
                </div>
                <ul class="nav nav-tabs" id="modalTab" role="tablist">
                    <?php if ($prod->multi_image): ?>
                    <?php foreach (explode(', ', $prod->multi_image) as $k => $img): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $k === 0 ? 'active' : '' ?>" id="thumb<?= $k ?>-tab" data-bs-toggle="tab" data-bs-target="#thumb<?= $k ?>" type="button" role="tab" aria-controls="thumb<?= $k ?>" aria-selected="true">
                            <?= img($prod->base."thumb/".$img); ?>
                        </button>
                    </li>
                    <?php endforeach ?>
                    <?php else: ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="thumb-tab" data-bs-toggle="tab" data-bs-target="#thumb" type="button" role="tab" aria-controls="thumb" aria-selected="true">
                                <?= img(['src' => $prod->image, 'height' => 85]); ?>
                            </button>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="product__modal-content">
                <h4><?= anchor("$prod->cat_slug/$prod->sc_slug/$prod->p_slug", $prod->p_title); ?></h4>
                <div class="product__review d-sm-flex">
                    <div class="rating rating__shop mb-10 mr-30"></div>
                    <div class="product__add-review mb-15"></div>
                </div>
                <div class="product__price">
                    <span>₹ <?= $prod->p_price ?></span>
                </div>
                <div class="product__modal-des mt-20 mb-15">
                    <p><?= $prod->short_desc ?></p>
                </div>
                <div class="product__modal-form">
                    <div class="cart-option mb-15">
                        <div class="product-quantity mr-20">
                            <div class="cart-plus-minus p-relative">
                                <input type="text" value="1" readonly id="input-quantity"><div class="dec qtybutton">-</div><div class="inc qtybutton">+</div>
                            </div>
                        </div>
                        <a href="javascript:;" class="cart-btn" onclick="cart.add('<?= e_id($prod->id) ?>')">Add to Cart</a>
                    </div>
                </div>
                <div class="product__stock mb-30">
                    <ul>
                        <li>
                            <span class="title">SKU:</span>
                            <span class="sku"><?= $prod->sku_code ?></span>
                        </li>
                        <li>
                            <span class="title">Category:</span>
                            <a><?= $prod->cat_name ?></a>
                        </li>
                        <li>
                            <span class="title">Sub Category:</span>
                            <a><?= $prod->sub_cat ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>