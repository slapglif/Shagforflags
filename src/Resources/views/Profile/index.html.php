<?php
$view->extend('layout-dashboard.html.php');
$user_profile_confirmed = $user->getProfileConfirmed();
$user_photo = $user->getProfilePhoto();
?>

<div class="hero-v1 single-page-pad">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Profile</h1>
            </div>
        </div>
    </div>
</div>

<div class="site-section pt-5">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-12">
                <div class="row">
                    <div class="col-md-9 mx-auto">
                        <?php if(!$user_profile_confirmed) {?>
                            <div class="alert alert-warning alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                Please complete your profile to continue!
                            </div>
                        <?php }?>

                        <?php echo $view->render('Static/alert.html.php')?>

                        <div class="profile">
                            <div class="profile-header">
                                <?php
                                if ($user_photo) {
                                    $photo = 'build/files/upload/user/thumb-265/'.$user_photo;
                                }else {
                                    $photo = 'build/images/profile/placeholder.png';
                                }
                                ?>

                                <img src="<?php echo $view['assets']->getUrl($photo); ?>" class="img-fluid">
                            </div>
                            <div class="profile-header-sub">
                                <h3><?php if(!empty($user->getName())) {echo $user->getName();}?> (<?php if(!empty($user->getAlias())) {echo $user->getAlias();}?>)</h3>

                                <?php if(!empty($user->getLocation())) {?>
                                    <p><i class="fa fa-map-marker-alt"></i> <?php echo $user->getLocation(); ?></p>
                                <?php }?>
                            </div>

                            <div class="profile-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <p class="title">Date of Birth</p>
                                        <p class="content"><?php if(!empty($user->getBirthdate())) {echo $user->getBirthdate();}else {echo '-';} ?></p>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <p class="title">Country of Birth</p>
                                        <p class="content"><?php if(!empty($user->getCountry())) {echo $user->getCountry();}else {echo '-';} ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <p class="title">Gender</p>
                                        <p class="content"><?php if(!empty($user->getGender())) {echo $user->getGender();}else {echo '-';} ?></p>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <p class="title">Sexual Orientation</p>
                                        <p class="content"><?php if(!empty($user->getSexorient())) {echo $user->getSexorient();}else {echo '-';} ?></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-3">
                                            <a class="btn btn-outline-primary btn-block" href="<?php echo $view['router']->path('profile_edit'); ?>">Edit Profile</a>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mt-3">
                                            <a class="btn btn-outline-primary btn-block" href="<?php echo $view['router']->path('profile_change_password'); ?>">Change Password</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
