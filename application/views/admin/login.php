<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="login-block">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="md-float-material form-material" action="<?= base_url('admin/login') ?>" method="POST" id="loginForm">
          <div class="text-center">
            <img src="<?php echo base_url()?>assets/assets/images/logo.png" alt="logo.png">
          </div>
          <div class="auth-box card">
            <div class="card-block">
              <div class="row m-b-20">
                <div class="col-md-12">
                  <h3 class="text-center txt-primary">Sign In</h3>
                  <?php if (!empty($error)): ?>
                  <div class="alert alert-danger border-danger danger">
                    <strong>
                    <?= $error ?>
                    </strong>
                  </div>
                  <?php endif ?>
                </div>
              </div>
              <div class="form-group form-primary">
                <input type="text" name="mobile" class="form-control single" value="<?= set_value('mobile') ?>" pattern="[0-9]{10}" maxlength="10">
                <span class="form-bar"></span>
                <label class="float-label" >Mobile</label>
                <?=  form_error('mobile'); ?>
              </div>
              <div class="form-group form-primary">
                <input type="password" name="password" class="form-control single" >
                <span class="form-bar"></span>
                <label class="float-label">Password</label>
                <?=  form_error('password') ?>
              </div>
              <div class="row m-t-25 text-left">
                <div class="col-12">
                  <div class="forgot-phone text-right float-right">
                    <a href="<?= base_url('admin/forgotPassword') ?>" class="text-right f-w-600"> Forgot Password?</a>
                  </div>
                </div>
              </div>
              <div class="row m-t-30">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">LOGIN</button>
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