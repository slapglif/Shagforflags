<?php
$view->extend('layout-dashboard.html.php');
?>

<div class="hero-v1 single-page-pad">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Create Sex Story</h1>
                <p>Share your hottest sex story with the world  in three steps</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <?php echo $view->render('Static/alert.html.php')?>

                <?php echo $view->render('Static/onboarding.html.php', array('onboarding' => $onboarding))?>

                <?php echo $view->render('Story/create-form.html.php', array('user' => $user, 'flags_url' => $flags_url))?>
            </div>
        </div>
    </div>
</div>
