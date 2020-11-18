<?php
$user_helper = $this->get("user");
$is_logged_in = $user_helper->isUserLoggedIn();
$user_role = $user_helper->getActiveUserRole();

if ($is_logged_in) {
    $user = $user_helper->getActiveUser();
    $user_photo = $user->getProfilePhoto();
    if ($user_photo) {
        $photo = '/build/files/upload/user/thumb-265/'.$user_photo;
    }else {
        $photo = '/build/images/profile/placeholder.png';
    }
}
?>
<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<header class="site-navbar light js-sticky-header site-navbar-target" role="banner">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-6 col-xl-2">
                <div class="mb-0 site-logo"><a href="<?php echo $view['router']->path('frontend_homepage'); ?>" class="mb-0">ShagForFlags</a></div>
            </div>

            <div class="col-12 col-md-10 d-none d-xl-block">
                <nav class="site-navigation position-relative text-right" role="navigation">

                    <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                        <?php if($is_logged_in == FALSE) {?>
                            <li>
                                <a href="<?php echo $view['router']->path('frontend_homepage'); ?>" class="nav-link">Homepage</a>
                            </li>
                            <li>
                                <a href="<?php echo $view['router']->path('fos_user_security_login'); ?>" class="nav-link">Login</a>
                            </li>
                            <li>
                                <a href="<?php echo $view['router']->path('fos_user_registration_register'); ?>" class="nav-link">Register</a>
                            </li>
                        <?php }else {?>
                            <li>
                                <a href="<?php echo $view['router']->path('dashboard_homepage'); ?>" class="nav-link">Dashboard</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $view['assets']->getUrl($photo); ?>" width="40" height="40" class="rounded-circle">
                                    agencer
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <?php if($user_role != "ROLE_USER") {?>
                                        <a class="dropdown-item" href="<?php echo $view['router']->path('profile_view'); ?>">Profile</a>
                                    <?php }?>

                                    <a href="<?php echo $view['router']->path('fos_user_security_logout'); ?>" class="dropdown-item">Logout</a>
                                </div>
                            </li>
                        <?php }?>
                    </ul>
                </nav>
            </div>
            <div class="col-6 d-inline-block d-xl-none ml-md-0 py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3 text-orange-c"></span></a></div>
        </div>
    </div>
</header>
