<?php
$user_gender = $user->getGender();
$user_sexual_orientation = $user->getSexorient();

$pre_selection_gender = "";
$pre_selection_sexorient = "";
if ($user_gender == "Male") {
    if ($user_sexual_orientation == "Heterosexual") {
        $pre_selection_gender = "Female";
        $pre_selection_sexorient = "Heterosexual";
    }else if ($user_sexual_orientation == "Homosexual") {
        $pre_selection_gender = "Male";
        $pre_selection_sexorient = "Homosexual";
    }
}else if ($user_gender == "Female") {
    if ($user_sexual_orientation == "Heterosexual") {
        $pre_selection_gender = "Male";
        $pre_selection_sexorient = "Heterosexual";
    }else if ($user_sexual_orientation == "Homosexual") {
        $pre_selection_gender = "Female";
        $pre_selection_sexorient = "Homosexual";
    }
}
?>

<div id="msform" autocomplete="off">
    <ul id="progressbar">
        <li id="wizar-prog-1" class="active wizard-prog-1">
            <strong>Where</strong>
        </li>
        <li id="wizar-prog-2" class="wizard-prog-2">
            <strong>Partners</strong>
        </li>
        <li id="wizar-prog-3" class="wizard-prog-3">
            <strong>Story</strong>
        </li>
    </ul>

    <fieldset id="progress-form-1">
        <div class="form-card">
            <h2 class="fs-title">Where Did The Sex Happen?</h2>

            <div class="row">
                <div class="col-lg-12">
                    <div class="wizard-error-1 alert alert-danger">
                        <p class="error-message">Please fill all fields</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-addon left-addon">
                        <i class="icomoon icon-map-marker"></i>
                        <input id="step-1-location" class="form-control mb-3" name="step-1-location" type="text" placeholder="Location" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="inner-addon left-addon">
                        <i class="icomoon icon-flag-o"></i>
                        <input id="step-1-country" class="form-control mb-3" name="step-1-country" type="text" placeholder="Country" readonly="readonly" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="inner-addon left-addon">
                        <i class="icomoon icon-date_range"></i>
                        <input id="step-1-date" class="datepicker-std form-control mb-3" name="step-1-date" type="text" placeholder="Date" onkeydown="return false" autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-right">
                    <input class="next-1 wizard-btn-next" name="next" type="button" value="Next">
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset id="progress-form-2">
        <div class="form-card">
            <h2 class="fs-title">Sex Partners <i class="icomoon icon-add_circle add-sex-partner"></i></h2>

            <div class="row">
                <div class="col-lg-12">
                    <div class="wizard-error-2 alert alert-danger">
                        <p class="error-message">Please fill all fields and make at least one selection for each section</p>
                    </div>
                </div>
            </div>

            <div id="wizard-accordion">
                <div id="partner-1" class="card">
                    <p class="fs-subtitle card-link" data-toggle="collapse" href="#c-1"><i class="icomoon icon-caret-up"></i> Partner 1</p>
                    <div id="c-1" class="collapse show" data-parent="#wizard-accordion">
                        <div class="card-body">
                            <div class="sex-partners">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="inner-addon left-addon">
                                            <i class="icomoon icon-user-o"></i>
                                            <input class="step-2-partner-name form-control mb-3" name="step-2-partner-name" type="text" placeholder="Name" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="inner-addon left-addon">
                                            <select name="step-2-country" class="country-selector countrypicker step-2-country form-control mb-3" data-live-search="true" data-flag="true" title="Country" autocomplete="off"></select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-left">
                                        <div class="custom-cr cr-form-gender">
                                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-38_b.png'); ?>">Gender</label>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-custom-cr mr-2 mb-2 <?php if($pre_selection_gender == "Male"){echo "active";} ?>">
                                                    <input class="step-2-gender" type="radio" name="step-2-gender" autocomplete="off" value="male">

                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/male_b.png'); ?>">
                                                    <span>Male</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2 <?php if($pre_selection_gender == "Female"){echo "active";} ?>">
                                                    <input class="step-2-gender" type="radio" name="step-2-gender" autocomplete="off" value="female">

                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/female_b.png'); ?>">
                                                    <span>Female</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-left mt-3">
                                        <div class="custom-cr cr-form-ages">
                                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-29_g.png'); ?>">Interval of ages</label>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="18-20">
                                                    <span>18-20</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="20-25">
                                                    <span>20-25</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="25-35">
                                                    <span>25-35</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="35-50">
                                                    <span>35-50</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="50-65">
                                                    <span>50-65</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="+65">
                                                    <span>+65</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-left mt-3">
                                        <div class="custom-cr cr-form-bodyshape">
                                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-30_b.png'); ?>">Body Shape</label>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Chubby">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-5_b.png'); ?>">
                                                    <span>Chubby</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Average">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-6_b.png'); ?>">
                                                    <span>Average</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Fitness">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-7_b.png'); ?>">
                                                    <span>Fitness</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Athlete">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-8_b.png'); ?>">
                                                    <span>Athlete</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Out of this world">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-9_b.png'); ?>">
                                                    <span>Out of this world</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-left mt-3">
                                        <div class="custom-cr cr-form-birthcontrol">
                                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-10_b.png'); ?>">Birth Control</label>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-birthcontrol" type="radio" name="step-2-birthcontrol" autocomplete="off" value="Yes">
                                                    <span>Yes</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-birthcontrol" type="radio" name="step-2-birthcontrol" autocomplete="off" value="No">
                                                    <span>No</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-left mt-3">
                                        <div class="custom-cr cr-form-howmet">
                                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-32_b.png'); ?>">How did you've met</label>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Dating Apps">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-11_b.png'); ?>">
                                                    <span>Dating Apps</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Disco">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-12_b.png'); ?>">
                                                    <span>Disco</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Common Friends">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-13_b.png'); ?>">
                                                    <span>Common Friends</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Social Networks">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-14_b.png'); ?>">
                                                    <span>Social Networks</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Street">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-15_b.png'); ?>">
                                                    <span>Street</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>

                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Other">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-35_b.png'); ?>">
                                                    <span>Other</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-left mt-3">
                                        <div class="custom-cr cr-form-sexorient">
                                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-33_b.png'); ?>">Sexual Orientation</label>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-sexorient" type="radio" name="step-2-sexorient" autocomplete="off" value="Bisexual">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-3_b.png'); ?>">
                                                    <span>Bisexual</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2 <?php if($pre_selection_sexorient == "Heterosexual"){echo "active";} ?>">
                                                    <input class="step-2-sexorient" type="radio" name="step-2-sexorient" autocomplete="off" value="Heterosexual">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-37_b.png'); ?>">
                                                    <span>Heterosexual</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2 <?php if($pre_selection_sexorient == "Homosexual"){echo "active";} ?>">
                                                    <input class="step-2-sexorient" type="radio" name="step-2-sexorient" autocomplete="off" value="Homosexual">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-4_b.png'); ?>">
                                                    <span>Homosexual</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-sexorient" type="radio" name="step-2-sexorient" autocomplete="off" value="Asexual">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-36_b.png'); ?>">
                                                    <span>Asexual</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-left mt-3">
                                        <div class="custom-cr cr-form-actionchip">
                                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-34_b.png'); ?>">Action Chips</label>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Vaginal">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-16_b.png'); ?>" style="width: 25px;">
                                                    <span>Vaginal</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Oral">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-17_b.png'); ?>">
                                                    <span>Oral</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Anal">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-18_b.png'); ?>" style="height: 15px;">
                                                    <span>Anal</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Blowjob">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-20_b.png'); ?>">
                                                    <span>Blowjob</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Handjob">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-19_b.png'); ?>" style="width: 20px;">
                                                    <span>Handjob</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="BDSM">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-21_b.png'); ?>" style="width: 20px;">
                                                    <span>BDSM</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Outdoor">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-22_b.png'); ?>" style="width: 22px;">
                                                    <span>Outdoor</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Doggystyle">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-23_b.png'); ?>">
                                                    <span>Doggystyle</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Ass licking">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-24_b.png'); ?>">
                                                    <span>Ass Licking</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Cunnilingus">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-25_b.png'); ?>" style="height: 12px; width: 35px; position: relative;top: 4px;">
                                                    <span>Cunnilingus</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Orgasm">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-26_b.png'); ?>">
                                                    <span>Orgasm</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Cum in mouth">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-27_b.png'); ?>" style="height: 15px; width: 25px; position: relative; top: 2px;">
                                                    <span>Cum in mouth</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                                <label class="btn btn-custom-cr mr-2 mb-2">
                                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Cum in face">
                                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-28_b.png'); ?>">
                                                    <span>Cum in face</span>
                                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6 text-left">
                    <input class="previous wizard-btn-prev" name="previous" type="button" value="Previous">
                </div>
                <div class="col-sm-6 text-right">
                    <input class="next-2 wizard-btn-next" name="next" type="button" value="Next">
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset id="progress-form-3">
        <div class="form-card text-left">
            <h2 class="fs-title">Story</h2>

            <div class="row">
                <div class="col-lg-12">
                    <div class="wizard-error-3 alert alert-danger">
                        <p class="error-message">Please insert your story</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <textarea id="step-3-story" class="form-control mb-3" name="step-3-story" placeholder="Write your story" style="min-height: 150px;" autocomplete="off"></textarea>
                    <span class="custom-btn-emoji">&#x1f60b;</span>
                    <span class="custom-btn-emoji">&#x1f60d;</span>
                    <span class="custom-btn-emoji">&#x1F642;</span>
                    <span class="custom-btn-open-emoji fa fa-plus-circle"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="subtitle-normal">Upload Image</p>
                    <div id="story-photos">
                        <form action="<?php echo $view['router']->path('media_upload_story_photo'); ?>" class="dropzone" id="my-awesome-dropzone"></form>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6 text-left">
                    <input class="previous wizard-btn-prev" name="previous" type="button" value="Previous">
                </div>
                <div class="col-sm-6 text-right">
                    <input class="save wizard-btn-next" name="save" type="button" value="Save">
                </div>

                <div class="col-sm-12 text-center">
                    <div class="btn btn-primary cs-loading-btn">
                        <span class="spinner-border spinner-border-sm"></span>
                        Saving
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset id="progress-success" style="display: none;">
        <div class="form-card">
            <h2 class="fs-title text-center">You have successfully added your story!</h2>

            <div class="row">
                <div class="col-lg-12">
                    <span class="story-success icomoon icon-check-circle"></span>
                </div>
            </div>
        </div>
    </fieldset>
</div>


<div id="partner-0" class="card d-none">
    <p class="fs-subtitle card-link" data-toggle="collapse" href="#c-0"><i class="icomoon icon-caret-up"></i> Partner 0</p>
    <div id="c-0" class="collapse show" data-parent="#wizard-accordion">
        <div class="card-body">
            <div class="sex-partners">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="inner-addon left-addon">
                            <i class="icomoon icon-user-o"></i>
                            <input class="step-2-partner-name form-control mb-3" name="step-2-partner-name" type="text" placeholder="Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="inner-addon left-addon">
                            <select class="countrypicker step-2-country form-control mb-3" name="step-2-country" data-live-search="true" data-flag="true" title="Country" autocomplete="off"></select>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left">
                        <div class="custom-cr cr-form-gender">
                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-38_b.png'); ?>">Gender</label>
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-custom-cr mr-2 mb-2 <?php if($pre_selection_gender == "Male"){echo "active";} ?>">
                                    <input class="step-2-gender" type="radio" name="step-2-gender" autocomplete="off" value="male">

                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/male_b.png'); ?>">
                                    <span>Male</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2 <?php if($pre_selection_gender == "Female"){echo "active";} ?>">
                                    <input class="step-2-gender" type="radio" name="step-2-gender" autocomplete="off" value="female">

                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/female_b.png'); ?>">
                                    <span>Female</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left mt-3">
                        <div class="custom-cr cr-form-ages">
                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-29_g.png'); ?>">Interval of ages</label>
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="18-20">
                                    <span>18-20</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="20-25">
                                    <span>20-25</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="25-35">
                                    <span>25-35</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="35-50">
                                    <span>35-50</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="50-65">
                                    <span>50-65</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-intages" type="radio" name="step-2-intages" autocomplete="off" value="+65">
                                    <span>+65</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left mt-3">
                        <div class="custom-cr cr-form-bodyshape">
                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-30_b.png'); ?>">Body Shape</label>
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Chubby">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-5_b.png'); ?>">
                                    <span>Chubby</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Average">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-6_b.png'); ?>">
                                    <span>Average</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Fitness">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-7_b.png'); ?>">
                                    <span>Fitness</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Athlete">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-8_b.png'); ?>">
                                    <span>Athlete</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-bodyshape" type="radio" name="step-2-bodyshape" autocomplete="off" value="Out of this world">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-9_b.png'); ?>">
                                    <span>Out of this world</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left mt-3">
                        <div class="custom-cr cr-form-birthcontrol">
                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-10_b.png'); ?>">Birth Control</label>
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-birthcontrol" type="radio" name="step-2-birthcontrol" autocomplete="off" value="Yes">
                                    <span>Yes</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-birthcontrol" type="radio" name="step-2-birthcontrol" autocomplete="off" value="No">
                                    <span>No</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left mt-3">
                        <div class="custom-cr cr-form-howmet">
                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-32_b.png'); ?>">How did you've met</label>
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Dating Apps">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-11_b.png'); ?>">
                                    <span>Dating Apps</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Disco">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-12_b.png'); ?>">
                                    <span>Disco</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Common Friends">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-13_b.png'); ?>">
                                    <span>Common Friends</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Social Networks">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-14_b.png'); ?>">
                                    <span>Social Networks</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Street">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-15_b.png'); ?>">
                                    <span>Street</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>

                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-met" type="radio" name="step-2-met" autocomplete="off" value="Other">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-35_b.png'); ?>">
                                    <span>Other</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left mt-3">
                        <div class="custom-cr cr-form-sexorient">
                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-33_b.png'); ?>">Sexual Orientation</label>
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-sexorient" type="radio" name="step-2-sexorient" autocomplete="off" value="Bisexual">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-3_b.png'); ?>">
                                    <span>Bisexual</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2 <?php if($pre_selection_sexorient == "Heterosexual"){echo "active";} ?>">
                                    <input class="step-2-sexorient" type="radio" name="step-2-sexorient" autocomplete="off" value="Heterosexual">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-37_b.png'); ?>">
                                    <span>Heterosexual</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2 <?php if($pre_selection_sexorient == "Homosexual"){echo "active";} ?>">
                                    <input class="step-2-sexorient" type="radio" name="step-2-sexorient" autocomplete="off" value="Homosexual">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-4_b.png'); ?>">
                                    <span>Homosexual</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-sexorient" type="radio" name="step-2-sexorient" autocomplete="off" value="Asexual">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-36_b.png'); ?>">
                                    <span>Asexual</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-left mt-3">
                        <div class="custom-cr cr-form-actionchip">
                            <label class="group-label"><img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-34_b.png'); ?>">Action Chips</label>
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Vaginal">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-16_b.png'); ?>" style="width: 25px;">
                                    <span>Vaginal</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Oral">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-17_b.png'); ?>">
                                    <span>Oral</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Anal">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-18_b.png'); ?>" style="height: 15px;">
                                    <span>Anal</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Blowjob">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-20_b.png'); ?>">
                                    <span>Blowjob</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Handjob">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-19_b.png'); ?>" style="width: 20px;">
                                    <span>Handjob</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="BDSM">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-21_b.png'); ?>" style="width: 20px;">
                                    <span>BDSM</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Outdoor">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-22_b.png'); ?>" style="width: 22px;">
                                    <span>Outdoor</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Doggystyle">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-23_b.png'); ?>">
                                    <span>Doggystyle</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Ass licking">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-24_b.png'); ?>">
                                    <span>Ass Licking</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Cunnilingus">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-25_b.png'); ?>" style="height: 12px; width: 35px; position: relative;top: 4px;">
                                    <span>Cunnilingus</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Orgasm">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-26_b.png'); ?>">
                                    <span>Orgasm</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Cum in mouth">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-27_b.png'); ?>" style="height: 15px; width: 25px; position: relative; top: 2px;">
                                    <span>Cum in mouth</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                                <label class="btn btn-custom-cr mr-2 mb-2">
                                    <input class="step-2-achips" type="checkbox" name="step-2-achips" autocomplete="off" value="Cum in face">
                                    <img class="custom-icon" src="<?php echo $view['assets']->getUrl('build/images/icons/set-28_b.png'); ?>">
                                    <span>Cum in face</span>
                                    <span class="cr-btn-check icomoon icon-check-circle"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    <?php if($flags_url) {?>
    var flags_url = "<?php echo $flags_url; ?>";
    <?php }?>

    var selected_country = "";
</script>
<script src="<?php echo $view['assets']->getUrl('build/js/dropzone.min.js'); ?>"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/story-photo-upload.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWlp-9h4vvJc3dSAN1Puma7vlttV1ysTQ&libraries=places&language=en"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/jquery.geocomplete.min.js'); ?>"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/countrypicker.min.js'); ?>"></script>
<script src="<?php echo $view['assets']->getUrl('build/js/wizard.js'); ?>"></script>
