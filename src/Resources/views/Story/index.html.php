<?php
$view->extend('layout-dashboard.html.php');

$story_helper = $this->get("story");
$user_helper = $this->get("user");
?>

<div class="hero-v1 single-page-pad">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="heading mb-3">Sex Stories</h1>
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

                        <div id="feed-filters">
                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <div class="btn btn-feed-filter feed-filter-active" data-filter="worldwide">
                                        <i class="fa fa-globe"></i>
                                        Worldwide
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="btn btn-feed-filter" data-filter="country">
                                        <i class="fa fa-map-marker-alt"></i>
                                        My Country
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="btn btn-feed-filter" data-filter="users">
                                        <i class="fa fa-book-reader"></i>
                                        My Stories
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="all-feeds">
                            <?php foreach ($pagination->getItems() as $feed) { ?>
                                <div id="feed-<?php echo $feed->getId(); ?>" class="feed">
                                    <div class="bg-white border mt-2">
                                        <div class="feed-title-bg cursor-pointer">
                                            <div class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
                                                <div class="d-flex flex-row align-items-center feed-text px-2">
                                                    <?php
                                                    $story_flag = 'build/images/flags-big/' . $story_helper->getFlagFromCountry($feed->getCountry()) . '.png';
                                                    ?>
                                                    <img class="feed-title-flag rounded-circle" src="<?php echo $view['assets']->getUrl($story_flag); ?>">

                                                    <div class="d-flex flex-column flex-wrap ml-2">
                                                        <span class="feed-title-location"><?php echo $feed->getLocation(); ?></span>
                                                        <span class="feed-title-time">(<?php echo $story_helper->getTimeDifference($feed->getCreated()); ?>)</span>
                                                    </div>
                                                </div>

                                                <div class="feed-icon px-2 position-relative">
                                                    <?php
                                                    $partner_flags = $story_helper->getPartnerFlags($feed->getId());
                                                    foreach ($partner_flags['flags'] as $partner_flag) {
                                                        $partner_flag_img = "build/images/flags-big/".$partner_flag.".png";
                                                    ?>
                                                        <span class="feed-icon-flags">
                                                            <img class="feed-title-flag rounded-circle" src="<?php echo $view['assets']->getUrl($partner_flag_img); ?>">
                                                        </span>
                                                    <?php }?>
                                                    <?php if($partner_flags['additional'] > 0) {?>
                                                        <span class="feed-icon-flags feed-icon-flags-additional">
                                                            <span class="feed-title-flag rounded-circle">+<?php echo $partner_flags['additional']; ?></span>
                                                        </span>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="feed-body cursor-pointer">
                                            <div class="feed-reporter">
                                                <div class="feed-reporter-box">
                                                    <?php
                                                    $reporter_data = $user_helper->getUserFromId($feed->getUserId());
                                                    $reporter_flag = 'build/images/flags-big/' . $story_helper->getFlagFromCountry($reporter_data->getCountry()) . '.png';
                                                    ?>
                                                    <img class="feed-title-flag rounded-circle" src="<?php echo $view['assets']->getUrl($reporter_flag); ?>">
                                                    <span class="feed-reporter-name"><?php echo $reporter_data->getAlias(); ?></span>
                                                </div>
                                                <div class="feed-reporter-details">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-6 feed-reporter-details-border"><?php echo $reporter_data->getCountry(); ?></div>
                                                        <div class="col-lg-3 col-sm-6 feed-reporter-details-border"><?php echo $reporter_data->getGender(); ?></div>
                                                        <div class="col-lg-3 col-sm-6 feed-reporter-details-border"><?php echo $user_helper->calculateAge($reporter_data->getBirthdate()); ?> Years</div>
                                                        <div class="col-lg-3 col-sm-6"><?php echo $reporter_data->getSexorient(); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-3 pb-4">
                                                <span class="feed-story"><?php echo $story_helper->cutStoryContent($feed->getStory()); ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row feed-socials">
                                            <?php
                                            $votes = $story_helper->getVotes($feed->getId());
                                            $comments = $story_helper->getCommentCount($feed->getId());

                                            $upvote_checked = "";
                                            $downvote_checked = "";
                                            $exists_vote = $story_helper->existsVote($user->getId(), $feed->getId());
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
                                    </div>
                                </div>
                            <?php }?>
                        </div>

                        <div class="col-md-12 text-center">
                            <button class="btn load-more-btn d-none"><span class="spinner-border spinner-border-sm"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="feed-clone" class="feed d-none">
    <div class="bg-white border mt-2">
        <div class="feed-title-bg cursor-pointer">
            <div class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
                <div class="d-flex flex-row align-items-center feed-text px-2">
                    <img class="clone-story-flag feed-title-flag rounded-circle" src="">

                    <div class="d-flex flex-column flex-wrap ml-2">
                        <span class="feed-title-location"></span>
                        <span class="feed-title-time"></span>
                    </div>
                </div>

                <div class="clone-story-partners feed-icon px-2 position-relative"></div>
            </div>
        </div>
        <div class="feed-body cursor-pointer">
            <div class="feed-reporter">
                <div class="feed-reporter-box">
                    <img class="clone-reporter-flag feed-title-flag rounded-circle" src="">
                    <span class="feed-reporter-name"></span>
                </div>
                <div class="feed-reporter-details">
                    <div class="row">
                        <div class="clone-reporter-country col-lg-3 col-sm-6 feed-reporter-details-border"></div>
                        <div class="clone-reporter-gender col-lg-3 col-sm-6 feed-reporter-details-border"></div>
                        <div class="clone-reporter-age col-lg-3 col-sm-6 feed-reporter-details-border"></div>
                        <div class="clone-reporter-orient col-lg-3 col-sm-6"></div>
                    </div>
                </div>
            </div>

            <div class="p-3 pb-4">
                <span class="feed-story"></span>
            </div>
        </div>
        <div class="d-flex flex-row feed-socials">
            <div class="feed-socials-left">
                <span class="feed-socials-green"><i class="fa fa-thumbs-up upvote-f"></i> <span class="upvote">0</span></span>
                <span class="feed-socials-red"><i class="fa fa-thumbs-down downvote-f"></i> <span class="downvote">0</span></span>
            </div>
            <div class="feed-socials-right">
                <span class="feed-socials-comment"><i class="fa fa-comment-dots comment-f"></i> <span class="comments">0</span></span>
            </div>
        </div>
    </div>
</div>

<script>
    var feed_dir = "<?php echo $view['router']->path('profile_view'); ?>";
</script>
<script src="<?php echo $view['assets']->getUrl('build/js/feed.js'); ?>"></script>
