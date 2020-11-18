
<div class="hero-v1" style="padding: 4rem 0 4rem 0 !important;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <span class="d-block subheading">Create Account</span>
                <h1 class="heading mb-3">Almost there!</h1>
                <p class="mb-5">We are excited to see you here.</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section" style="padding-top: 25px !important;">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-6">
                <?php echo $view['form']->start($form); ?>

                <?php echo $view->render('Static/alert.html.php')?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-3">
                            <label for="user_registration_form_email">Email</label>
                            <?php echo $view['form']->widget($form['email']) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="user_registration_form_plainPassword_first">Password</label>
                            <?php echo $view['form']->widget($form['plainPassword']['first']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="user_registration_form_plainPassword_second">Confirm Password</label>
                            <?php echo $view['form']->widget($form['plainPassword']['second']) ?>
                        </div>
                    </div>
                </div>

                <div class="mt-3 form-check">
                    <input class="form-check-input mt-2" type="checkbox" id="policies" name="policies" required="required">
                    <label class="form-check-label" for="policies">By signing up you agree with out <a href="<?php echo $view['router']->path('frontend_terms'); ?>" target="_blank">Terms and Conditions</a> and <a href="<?php echo $view['router']->path('frontend_privacy'); ?>" target="_blank">Privacy Policy</a></label>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-3">
                            <input class="btn btn-primary btn-block" type="submit" value="Create Account" />
                        </div>
                    </div>
                </div>

                <?php echo $view['form']->end($form) ?>
            </div>
        </div>
    </div>
</div>