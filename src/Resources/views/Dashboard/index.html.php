<?php
$view->extend('layout-dashboard.html.php');

$user_helper = $this->get("user");
$user_role = $user_helper->getActiveUserRole();
?>

<div class="hero-v1 single-page-pad">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="site-section pt-5">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-12">
                <?php echo $view->render('Static/alert.html.php')?>

                <?php if($user_role != "ROLE_USER") {?>
                    <div class="row">
                        <div class="col-md-3 mt-md-5">
                            <div class="media-v1 bg-1">
                                <div class="icon-wrap">
                                    <span class="icomoon icon-note_add"></span>
                                </div>
                                <a class="body d-block" href="<?php echo $view['router']->path('story_create'); ?>">
                                    <h3 class="text-center">Create Story</h3>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 mt-md-5">
                            <div class="media-v1 bg-1">
                                <div class="icon-wrap">
                                    <span class="icomoon icon-library_books"></span>
                                </div>
                                <a class="body d-block" href="<?php echo $view['router']->path('story_feed'); ?>">
                                    <h3 class="text-center">Stories</h3>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 mt-md-5">
                            <div class="media-v1 bg-1">
                                <div class="icon-wrap">
                                    <span class="icomoon icon-group"></span>
                                </div>
                                <a class="body d-block" href="<?php echo $view['router']->path('dashboard_homepage'); ?>">
                                    <h3 class="text-center">Groups</h3>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 mt-md-5">
                            <div class="media-v1 bg-1">
                                <div class="icon-wrap">
                                    <span class="icomoon icon-user"></span>
                                </div>
                                <a class="body d-block" href="<?php echo $view['router']->path('profile_view'); ?>">
                                    <h3 class="text-center">Profile</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php }else {?>
                    <div class="row">
                        <div class="col-md-3 mt-md-5">
                            <div class="media-v1 bg-1">
                                <div class="icon-wrap">
                                    <span class="icomoon icon-edit"></span>
                                </div>
                                <a class="body d-block" href="<?php echo $view['router']->path('profile_edit'); ?>">
                                    <h3 class="text-center">Edit Profile</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
