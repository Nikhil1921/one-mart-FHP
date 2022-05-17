<section class="login-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <form class="md-float-material form-material" action="<?= base_url('admin/forgotPassword/change') ?>" method="POST">
                    <div class="text-center">
                        <img src="<?php echo base_url()?>assets/assets/images/logo.png" alt="logo.png">
                    </div>
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-left">Create your new password</h3>
                                    <?php if (!empty($success)): ?>
                                    <div class="alert alert-success border-success success">
                                        <strong>
                                        <?= $success ?>
                                        </strong>
                                    </div>
                                    <?php elseif (!empty($error)): ?>
                                    <div class="alert alert-danger border-danger danger">
                                        <strong>
                                        <?= $error ?>
                                        </strong>
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="form-group form-primary">
                                <input type="password" name="password" value="<?= set_value('password') ?>" class="form-control" >
                                <span class="form-bar"></span>
                                <label class="float-label">New Password</label>
                                <?=  form_error('password'); ?>
                            </div>
                            <div class="form-group form-primary">
                                <input type="password" name="c_password" value="<?= set_value('c_password') ?>" class="form-control" >
                                <span class="form-bar"></span>
                                <label class="float-label">Confirm Password</label>
                                <?=  form_error('c_password'); ?>
                            </div>
                            <input type="hidden" name="email" value="<?= $valid['email']?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Reset Password</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <p class="text-inverse text-left m-b-0">Thank you.</p>
                                </div>
                                <div class="col-md-2">
                                    <img src="<?= base_url()?>assets/assets/images/favicon.png" alt="small-logo.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>