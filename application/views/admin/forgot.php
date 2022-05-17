<section class="login-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <form class="md-float-material form-material" action="<?= base_url('admin/forgotPassword') ?>" method="POST">
                    <div class="text-center">
                        <img src="<?php echo base_url()?>assets/assets/images/logo.png" alt="logo.png">
                    </div>
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-left">Recover your password</h3>
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
                                <input type="text" name="mobile" value="<?= set_value('mobile') ?>" class="form-control" >
                                <span class="form-bar"></span>
                                <label class="float-label">Your Mobile Number</label>
                                <?=  form_error('mobile'); ?>
                            </div>
                            <!-- <div class="form-group">
                                <div class="form-radio">
                                    <div class="radio radiofill radio-inline ">
                                        <label>
                                            <input <?= (set_value('role') == 'admin') ? 'checked' : '' ?> type="radio" name="role" checked="checked" value="admin">
                                            <i class="helper"></i>Admin
                                        </label>
                                    </div>
                                    <div class="radio radiofill radio-inline ">
                                        <label>
                                            <input <?= (set_value('role') == 'staff') ? 'checked' : '' ?> type="radio" name="role" value="staff">
                                            <i class="helper"></i>Staff
                                        </label>
                                    </div>
                                    <div class="radio radio-inline"></div>
                                    <div class="radio radiofill radio-inline">
                                        <label>
                                            <input <?= (set_value('role') == 'manufacturer') ? 'checked' : '' ?> type="radio" name="role" value="manufacturer">
                                            <i class="helper"></i>Manufacturer
                                        </label>
                                    </div>
                                </div>
                                <?=  form_error('role'); ?>
                            </div> -->
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Reset Password</button>
                                </div>
                            </div>
                            <p class="f-w-600 text-right">Back to <a href="<?= base_url('admin/')?>">Login.</a></p>
                            <div class="row">
                                <div class="col-md-10">
                                    <p class="text-inverse text-left m-b-0">Thank you.</p>
                                    <p class="text-inverse text-left"><a href="<?= base_url()?>"><b>Back to website</b></a></p>
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