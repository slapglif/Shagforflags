<?php
$view->extend('layout-dashboard.html.php');

$story_helper = $this->get("story");
$user_helper = $this->get("user");
?>

<div class="hero-v1 single-page-pad">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Story</h1>
            </div>
        </div>
    </div>
</div>

<div class="site-section pt-5">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-12">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <?php echo $view->render('Static/alert.html.php')?>

                        <div id="all-feeds">
                            <div id="feed-<?php echo $story->getId(); ?>" class="feed">
                                <div class="bg-white mt-2">
                                    <div class="feed-title-bg">
                                        <div class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
                                            <div class="d-flex flex-row align-items-center feed-text px-2">
                                                <?php
                                                $story_flag = 'build/images/flags-big/' . $story_helper->getFlagFromCountry($story->getCountry()) . '.png';
                                                ?>
                                                <img class="feed-title-flag rounded-circle" src="<?php echo $view['assets']->getUrl($story_flag); ?>">

                                                <div class="d-flex flex-column flex-wrap ml-2">
                                                    <span class="feed-title-location"><?php echo $story->getLocation().' <span class="fs-12">('.$story->getCountry().')</span>'; ?></span>
                                                    <span class="feed-title-time"><?php echo $story->getCreated()->format("Y-m-d"); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="feed-body">
                                        <div class="feed-reporter border mb-3 feed-detail-bg">
                                            <div class="feed-reporter-box text-center">
                                                <?php
                                                $reporter_data = $user_helper->getUserFromId($story->getUserId());
                                                $reporter_flag = 'build/images/flags-big/' . $story_helper->getFlagFromCountry($reporter_data->getCountry()) . '.png';
                                                ?>
                                                <img class="feed-title-flag rounded-circle" src="<?php echo $view['assets']->getUrl($reporter_flag); ?>">
                                                <span class="feed-reporter-name"><?php echo $reporter_data->getAlias(); ?> <span class="fs-12">(Reporter)</span></span>
                                            </div>
                                            <div class="feed-reporter-details-2">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-6 feed-reporter-details-border"><?php echo $reporter_data->getCountry(); ?></div>
                                                    <div class="col-lg-3 col-sm-6 feed-reporter-details-border"><?php echo $reporter_data->getGender(); ?></div>
                                                    <div class="col-lg-3 col-sm-6 feed-reporter-details-border"><?php echo $user_helper->calculateAge($reporter_data->getBirthdate()); ?> Years</div>
                                                    <div class="col-lg-3 col-sm-6"><?php echo $reporter_data->getSexorient(); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $partners = $story_helper->getPartners($story->getId());
                                        foreach ($partners as $partner) {
                                        ?>
                                            <div class="feed-partner border mb-3 feed-detail-bg">
                                                <div class="feed-partner-box">
                                                    <?php
                                                    $partner_flag = 'build/images/flags-big/' . $story_helper->getFlagFromCountry($partner->getCountry()) . '.png';
                                                    ?>
                                                    <img class="feed-title-flag rounded-circle" src="<?php echo $view['assets']->getUrl($partner_flag); ?>">
                                                    <span class="feed-partner-name"><?php echo $partner->getName(); ?> <span class="fs-12">(Partner)</span></span>
                                                </div>
                                                <div class="feed-partner-details">
                                                    <div class="row">
                                                        <div class="col-lg-4 feed-reporter-details-border"><?php echo $partner->getCountry(); ?></div>
                                                        <div class="col-lg-4 feed-reporter-details-border"><?php echo $partner->getAges(); ?> Years</div>
                                                        <div class="col-lg-4"><?php echo ($partner->getGender() == 'male') ? 'Male' : 'Female'; ?> - <?php echo $partner->getSexualOrientation(); ?></div>
                                                    </div>
                                                </div>
                                                <div class="feed-partner-icons">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-2">
                                                            <img class="feed-partner-icon-birth" src="<?php echo $view['assets']->getUrl('build/images/icons/set-40.png'); ?>">
                                                            <span class="font-weight-bold">Birthcontrol:</span> <?php echo $partner->getBirthcontrol(); ?>
                                                        </div>
                                                        <div class="col-lg-12 mb-2">
                                                            <img class="feed-partner-icon-met" src="<?php echo $view['assets']->getUrl('build/images/icons/set-39.png'); ?>">
                                                            <span class="font-weight-bold">How did you meet:</span> <?php echo $partner->getMet(); ?>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <img class="feed-partner-icon-shape" src="<?php echo $view['assets']->getUrl('build/images/icons/set-41.png'); ?>">
                                                            <span class="font-weight-bold">Body Shape:</span> <?php echo $partner->getShape(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="feed-partner-actions">
                                                    <?php
                                                    $actionchips = $story_helper->getActionchips($partner->getId());
                                                    foreach ($actionchips as $actionchip) {
                                                        ?>
                                                        <span><?php echo $actionchip->getChip(); ?></span>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>

                                        <div class="border p-3 pb-4 feed-detail-bg">
                                            <span class="font-weight-bold">Story:</span>
                                            <br />
                                            <span class="feed-story"><?php echo $story->getStory(); ?></span>

                                            <?php
                                            $photos = $story_helper->getPhotos($story->getId());
                                            if ($photos) {?>
                                                <div class="story-photos">
                                                    <?php foreach ($photos as $photo) {?>
                                                        <a data-fancybox="gallery" href="<?php echo $view['assets']->getUrl('build/files/upload/story/' . $photo->getImageName()); ?>">
                                                            <img class="img-thumbnail" src="<?php echo $view['assets']->getUrl('build/files/upload/story/' . $photo->getImageName()); ?>">
                                                        </a>
                                                    <?php }?>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row feed-socials">
                                        <?php
                                        $votes = $story_helper->getVotes($story->getId());
                                        $comments = $story_helper->getCommentCount($story->getId());

                                        $upvote_checked = "";
                                        $downvote_checked = "";
                                        $exists_vote = $story_helper->existsVote($user->getId(), $story->getId());
                                        if ($exists_vote) {
                                            if ($exists_vote->getVote() == 1) {
                                                $upvote_checked = "feed-socials-green-checked";
                                            }else {
                                                $downvote_checked = "feed-socials-red-checked";
                                            }
                                        }
                                        ?>
                                        <div class="feed-socials-left">
                                            <span class="feed-socials-green">
                                                <i class="fa fa-thumbs-up upvote-f <?php echo $upvote_checked; ?>"></i>
                                                <span class="upvote"><?php echo $votes['up']; ?></span>
                                            </span>
                                            <span class="feed-socials-red">
                                                <i class="fa fa-thumbs-down downvote-f <?php echo $downvote_checked; ?>"></i>
                                                <span class="downvote"><?php echo $votes['down']; ?></span>
                                            </span>
                                        </div>
                                        <div class="feed-socials-right">
                                            <span class="feed-socials-comment">
                                                <i class="fa fa-comment-dots comment-f"></i>
                                                <span class="comments"><?php echo $comments; ?></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="border feed-detail-bg feed-detail-comments">
                                        <?php
                                        $all_comments = $story_helper->getStoryComments($story->getId());
                                        if($all_comments) {
                                        ?>
                                            <ul class="commentList">
                                                <?php
                                                foreach ($all_comments as $story_comment) {
                                                    $user_photo = $user_helper->getProfilePhotoById($story_comment->getUserId());
                                                    if ($user_photo) {
                                                        $photo = 'build/files/upload/user/thumb-265/'.$user_photo;
                                                    }else {
                                                        $photo = 'build/images/profile/placeholder.png';
                                                    }
                                                ?>
                                                    <li>
                                                        <div class="commenterImage">
                                                            <img src="<?php echo $view['assets']->getUrl($photo); ?>">
                                                        </div>
                                                        <div class="commentText">
                                                            <p class=""><?php echo $story_comment->getComment(); ?></p>
                                                            <span class="date sub-text"><?php echo $story_comment->getCreated()->format("Y-m-d"); ?></span>
                                                        </div>
                                                    </li>
                                                <?php }?>
                                            </ul>

                                        <?php }?>

                                        <div class="input-group comment-field">
                                            <input type="text" class="form-control add-comment" placeholder="Your comment" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <button class="btn add-comment-btn" type="button">Add</button>
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
</div>

<script src="<?php echo $view['assets']->getUrl('build/js/feed-detail.js'); ?>"></script>