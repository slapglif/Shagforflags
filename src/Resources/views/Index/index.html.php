<?php $view->extend('layout.html.php') ?>

<div class="hero-v1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mr-auto text-center text-lg-left">
                <span class="d-block subheading">Welcome To</span>
                <h1 class="heading mb-3">Shag For Flags</h1>
                <p class="mb-5">Here you can record your stories and share them with the worldwide community</p>
            </div>
            <div class="col-lg-6">
                <figure class="illustration">
                    <img src="<?php echo $view['assets']->getUrl('build/images/illustration.png'); ?>" alt="Image" class="img-fluid">
                </figure>
            </div>
            <div class="col-lg-6"></div>
        </div>
    </div>
</div>

<div class="site-section stats">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="data">
              <span class="icon text-primary">
                <span class="icomoon icon-user"></span>
              </span>
                    <strong class="d-block number">14.112.077</strong>
                    <span class="label">Users</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="data">
              <span class="icon text-primary">
                <span class="icomoon icon-bullhorn"></span>
              </span>
                    <strong class="d-block number">595.685</strong>
                    <span class="label">Groups</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="data">
              <span class="icon text-primary">
                <span class="icomoon icon-gift"></span>
              </span>
                    <strong class="d-block number">8.397.665</strong>
                    <span class="label">Stories</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section bg-primary-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="mb-4 section-heading">How Does It Work?</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="post-entry">
                    <img src="<?php echo $view['assets']->getUrl('build/images/event_1.jpg'); ?>" class="img-fluid">
                    <h3 class="text-primary mt-2">Places Where You Had Good Time</h3>
                    <p>Keep track and collect your flags.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="post-entry">
                    <img src="<?php echo $view['assets']->getUrl('build/images/event_2.jpg'); ?>" class="img-fluid">
                    <h3 class="text-primary mt-2">Collect Sex Flags</h3>
                    <p>Record foreign partners you had sex with and tell us your sex story.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="post-entry">
                    <img src="<?php echo $view['assets']->getUrl('build/images/event_3.jpg'); ?>" class="img-fluid">
                    <h3 class="text-primary mt-2">Share Your Story</h3>
                    <p>Write real sex stories, share them with the community and create group competitions to get more flags.</p>
                </div>
            </div>
        </div>
    </div>
</div>

