<?php
$view->extend('layout-dashboard.html.php');
?>

<div class="hero-v1 single-page-pad">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Change Password</h1>
            </div>
        </div>
    </div>
</div>

<div class="site-section pt-5">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-6">
                <div class="row">
                    <div class="col-md-9 mx-auto">
                        <?php echo $view->render('Static/alert.html.php')?>

                        <form name="change_password" method="post" action="<?php echo $view['router']->path('profile_change_password'); ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-3">
                                        <label for="form_email">Email</label>
                                        <input type="text" id="form_email" name="form_email" class="form-control" value="<?php echo $user->getEmail(); ?>" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-3">
                                        <label for="form_old_pw">Old Password</label>
                                        <input type="password" id="form_old_pw" name="form_old_pw" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-3">
                                        <label for="form_new_pw">New Password</label>
                                        <input type="password" id="form_new_pw" name="form_new_pw" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-3">
                                        <label for="form_confirm_new_pw">Confirm New Password</label>
                                        <input type="password" id="form_confirm_new_pw" name="form_confirm_new_pw" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <input type="submit" class="btn btn-primary btn-block" value="Save"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <a class="btn btn-outline-primary btn-block" href="<?php echo $view['router']->path('profile_view'); ?>">Back To Profile</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
