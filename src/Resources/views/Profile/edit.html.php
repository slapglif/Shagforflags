<?php
$view->extend('layout-dashboard.html.php');
$user_profile_confirmed = $user->getProfileConfirmed();
$user_photo = $user->getProfilePhoto();

$show_upload_photo = 'style="display: none;"';
if ($user_profile_confirmed) {
    $show_upload_photo = '';
}
?>

<div class="modal" id="loading_spinner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 20px;">
            <p class="fs-title text-center mb-0">Loading</p>
            <div class="spinner-border text-primary" role="status" style="margin: auto !important;">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-5 mb-0">Depending on the size of the image and your internet-speed, it can take up to a few minutes</p>
        </div>
    </div>
</div>

<div class="hero-v1 single-page-pad">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Edit Profile</h1>
            </div>
        </div>
    </div>
</div>

<div class="site-section pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="dz-warning" class="alert alert-danger alert-dismissable" style="display: none;">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <div id="dz-warning-message"></div>
                </div>
            </div>
        </div>
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
                            <div class="profile-header mb-0">
                                <?php
                                if ($user_photo) {
                                    $photo = 'build/files/upload/user/thumb-265/'.$user_photo;
                                }else {
                                    $photo = 'build/images/profile/placeholder.png';
                                }
                                ?>

                                <img src="<?php echo $view['assets']->getUrl($photo); ?>" class="img-fluid">


                                <div id="profile-img-btn" <?php echo $show_upload_photo; ?>>
                                    <?php
                                    if ($user_photo) {
                                        echo '<a class="profile-img-btn-delete"><i class="fa fa-trash"></i></a>';
                                    }else {
                                        echo '<a class="profile-img-btn-photo"><i class="fa fa-camera"></i></a>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="profile-body">
                                <form name="user_registration_form" method="post" action="<?php echo $view['router']->path('profile_edit'); ?>">
                                    <div class="row mt-5">
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <label for="form_alias">Alias</label>
                                                <div class="inner-addon right-addon">
                                                    <?php
                                                    $readonly = "";
                                                    $tooltip = "";
                                                    if(!$user->getAlias()) {
                                                        $tooltip = "You can not change alias after saving!";
                                                    }else {
                                                        $tooltip = "You can not change your alias!";
                                                        $readonly = 'readonly="readonly"';
                                                    }
                                                    ?>
                                                    <i class="icomoon icon-check alias-check d-none" data-toggle="tooltip" data-placement="bottom"></i>
                                                    <input type="text" id="form_alias" name="form_alias" class="form-control" value="<?php echo $user->getAlias(); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip; ?>" <?php echo $readonly; ?>>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <label for="form_name">Name</label>
                                                <input type="text" id="form_name" name="form_name" class="form-control" value="<?php echo $user->getName(); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <label for="form_birth">Date of Birth</label>
                                                <input type="text" id="form_birth" name="form_birth" class="datepicker-birth form-control" data-provide="datepicker" value="<?php echo $user->getBirthdate(); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mt-3">
                                                <label for="form_country">Country of Birth</label>
                                                <select id="form_country" name="form_country" class="country-selector countrypicker form-control" data-live-search="true" data-flag="true" title="&nbsp;"></select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mt-3">
                                                <label for="form_location">Where do you live?</label>
                                                <input type="text" id="form_location" name="form_location" class="form-control" value="<?php echo $user->getLocation(); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mt-3">
                                                <label for="form_gender">Gender</label>
                                                <select id="form_gender" name="form_gender" class="form-control">
                                                    <option value="Male" <?php if($user->getGender() == "Male") {echo 'selected="selected"';} ?>>Male</option>
                                                    <option value="Female" <?php if($user->getGender() == "Female") {echo 'selected="selected"';} ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mt-3">
                                                <label for="form_sexorient">Sexual Orientation</label>
                                                <select id="form_sexorient" name="form_sexorient" class="form-control">
                                                    <option value="Heterosexual" <?php if($user->getSexorient() == "Heterosexual") {echo 'selected="selected"';} ?>>Heterosexual</option>
                                                    <option value="Bisexual" <?php if($user->getSexorient() == "Bisexual") {echo 'selected="selected"';} ?>>Bisexual</option>
                                                    <option value="Homosexual" <?php if($user->getSexorient() == "Homosexual") {echo 'selected="selected"';} ?>>Homosexual</option>
                                                    <option value="Asexual" <?php if($user->getSexorient() == "Asexual") {echo 'selected="selected"';} ?>>Asexual</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mt-3">
                                                <input type="submit" class="btn btn-primary btn-block" value="Save"/>
                                            </div>
                                        </div>


                                        <?php if($user_profile_confirmed) {?>
                                            <div class="col-md-6">
                                                <div class="mt-3">
                                                    <a class="btn btn-outline-primary btn-block" href="<?php echo $view['router']->path('profile_view'); ?>">Back To Profile</a>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="<?php echo $view['router']->path('media_upload_photo'); ?>" class="dropzone hide" id="myAwesomeDropzone"></form>
<div class="modal" id="crop-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="bootstrap-modal-cropper"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="cropper_done" style="font-weight: bold;">Save</button>
                <button class="btn btn-danger" data-dismiss="modal" style="font-weight: bold;">Cancel</button>
            </div>
        </div>
    </div>

    <div id="crop_data" class="hide">
        <div id="crop_x"></div>
        <div id="crop_y"></div>
        <div id="crop_size"></div>
    </div>
</div>

<script>
    var user_photo = '/build/files/upload/user/thumb-265/<?php echo $user_photo; ?>';
    <?php
    if($user_photo){
        echo 'var dropclick = true;';
    }else {
        echo 'var dropclick = false;';
    }
    ?>
    <?php if($flags_url) {?>
        var flags_url = "<?php echo $flags_url; ?>";
    <?php }?>

    var selected_country = "<?php echo $selected_country; ?>";
</script>

<script src="<?php echo $view['assets']->getUrl('build/js/dropzone.min.js'); ?>"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/cropper.js'); ?>"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/user-photo-upload.js'); ?>"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/countrypicker.min.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWlp-9h4vvJc3dSAN1Puma7vlttV1ysTQ&libraries=places"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/jquery.geocomplete.min.js'); ?>"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/pedit.js'); ?>"></script>