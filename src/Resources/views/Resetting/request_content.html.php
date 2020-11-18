
<div class="hero-v1" style="padding: 4rem 0 4rem 0 !important;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Forgot Password</h1>
                <p class="mb-5">Please enter your email to receive one time link to your email address</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section" style="padding-top: 25px !important;">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-6">
                <?php echo $view->render('Static/alert.html.php')?>

                <form name="user_registration_form" method="post" action="<?php echo $view['router']->path('fos_user_resetting_send_email'); ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-3">
                                <label for="user_registration_form_email">Email</label>
                                <input type="email" id="user_registration_form_email" name="username" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-3">
                                <input type="submit" class="btn btn-primary btn-block" value="Reset Password"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
