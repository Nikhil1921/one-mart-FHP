<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($_SESSION['username'])) {
  return redirect('/');
} ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Lottery | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="<?= base_url()?>assets/assets/images/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/bower_components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- feather icon --> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/assets/icon/feather/css/feather.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/assets/icon/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/assets/css/style.css"><link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/assets/css/pages.css">
  </head>
  <body themebg-pattern="theme4">
    <div class="theme-loader">
      <div class="loader-track">
        <div class="preloader-wrapper">
          <div class="spinner-layer spinner-blue">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="gap-patch">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          <div class="spinner-layer spinner-red">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="gap-patch">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          
          <div class="spinner-layer spinner-yellow">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="gap-patch">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          
          <div class="spinner-layer spinner-green">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="gap-patch">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
                    <input type="text" name="mobile" class="form-control" value="<?= set_value('mobile') ?>">
                    <span class="form-bar"></span>
                    <label class="float-label" >Mobile</label>
                    <?=  form_error('mobile'); ?>
                  </div>
                  <div class="form-group form-primary">
                    <input type="password" name="password" class="form-control" >
                    <span class="form-bar"></span>
                    <label class="float-label">Password</label>
                    <?=  form_error('password') ?>
                  </div>
                  <div class="form-group form-primary">
                    <select class="form-control">
                      <option value="">Sign As</option>
                      <option value="admin">Admin</option>
                      <option value="manufacturer">Manufacturer</option>
                      <option value="customer">Customer</option>
                    </select>
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
  <script type="text/javascript" src="<?php echo base_url()?>assets/bower_components/jquery/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/bower_components/popper.js/js/popper.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
  <!-- waves js -->
  <script src="<?php echo base_url()?>assets/assets/pages/waves/js/waves.min.js" type="text/javascript"></script>
  <!-- jquery slimscroll js -->
  <script type="text/javascript" src="<?php echo base_url()?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
  <!-- modernizr js -->
  <script type="text/javascript" src="<?php echo base_url()?>assets/bower_components/modernizr/js/modernizr.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/bower_components/modernizr/js/css-scrollbars.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/assets/js/common-pages.js"></script>
  <script src="<?php echo base_url()?>assets/assets/js/rocket-loader.min.js" ></script></body>
</html>