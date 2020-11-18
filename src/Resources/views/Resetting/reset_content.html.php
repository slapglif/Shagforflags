
<div class="hero-v1" style="padding: 4rem 0 4rem 0 !important;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Create New Password</h1>
                <p class="mb-5"></p>
            </div>
        </div>
    </div>
</div>

<div class="site-section" style="padding-top: 25px !important;">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-6">
                <?php echo $view->render('Static/alert.html.php')?>

                <?php echo $view['form']->start($form); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="user_registration_form_plainPassword_first">New Password</label>
                            <?php echo $view['form']->widget($form['plainPassword']['first']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="user_registration_form_plainPassword_second">Confirm New Password</label>
                            <?php echo $view['form']->widget($form['plainPassword']['second']) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-3">
                            <input type="submit" class="btn btn-primary btn-block" value="Submit"/>
                        </div>
                    </div>
                </div>

                <?php echo $view['form']->end($form) ?>
            </div>
        </div>
    </div>
</div>






