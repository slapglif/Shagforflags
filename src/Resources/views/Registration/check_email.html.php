<?php $view->extend("layout.html.php"); ?>

<div class="hero-v1" style="padding: 4rem 0 4rem 0 !important;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Hold on almost there!</h1>
                <p class="mb-5">Thank you for getting started with Shag For Flags! You are just one step away. Please activate your account.<br /><br />An activation link has been sent to your e-mail address.</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section" style="padding-top: 25px !important;">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-6">
                <?php echo $view->render('Static/alert.html.php')?>

                <a class="btn btn-outline-danger btn-block" style="color: #000000;" href="<?php echo $view['router']->path('registration_resend_confirmation', array('email' => $user)); ?>">Resend Activation Link To <?php echo $user; ?></a>
            </div>
        </div>
    </div>
</div>