<?php $view->extend('layout.html.php') ?>

<div class="hero-v1" style="padding: 4rem 0 4rem 0 !important;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Access Denied!</h1>
                <a class="mt-5 btn btn-primary" href="<?php echo $view['router']->path('frontend_homepage'); ?>">Back to Homepage</a>
            </div>
        </div>
    </div>
</div>