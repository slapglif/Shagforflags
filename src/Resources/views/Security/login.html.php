<?php
$view->extend("layout.html.php");
?>

<div class="hero-v1" style="padding: 4rem 0 4rem 0 !important;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Welcome</h1>
                <p class="mb-5">Sign in to Continue</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section" style="padding-top: 25px !important;">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-6">
                <?php echo $view->render('Static/alert.html.php')?>

                <form role="form" class="form" action="<?php echo $view['router']->path('fos_user_security_check'); ?>" method="post" name="loginForm" id="loginForm">
                    <input type="hidden" name="_csrf_token" value="<?php echo $csrf_token; ?>" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-3">
                                <label for="username">Email</label>
                                <input type="text" class="form-control" id="username" name="_username" value="<?php echo $view->escape($last_username); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="_password"/>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input type="checkbox" id="remember_me" name="_remember_me" value="on">
                            <label for="remember_me">Remember Me</label>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?php echo $view['router']->path('fos_user_resetting_request'); ?>" id="reset-password-link">Forgot Password?</a><br/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <input type="submit" class="btn btn-primary btn-block" id="_submit" name="_submit" value="Sign in" />
                        </div>

                        <div class="col-md-12 mt-3">
                            <a class="btn btn-secondary btn-block" href="<?php echo $view['router']->path('fos_user_registration_register'); ?>">Don't have an account? Create Account</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>