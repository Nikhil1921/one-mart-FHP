<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="login-block">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="md-float-material form-material" action="<?= base_url('login') ?>" method="POST">
          <div class="text-center">
            <img src="<?php echo base_url()?>assets/assets/images/logo.png" alt="logo.png">
          </div>
          <div class="auth-box card">
            <div class="card-block">
              <div class="row m-b-20">
                <div class="col-md-12">
                  <h3 class="text-center txt-primary"><?= $heading ?></h3>
                </div>
                <div><br><br>
                  <div class="col-md-12">
                    <div class="text-success">
                      <strong>
                      <?= $message ?>
                      </strong>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="forgot-phone text-right float-right">
                    <a href="<?= base_url('admin/login') ?>" class="text-right btn btn-primary f-w-600">Login Here</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>