<?php
$meta_title = "Shag For Flags";
$meta_descr = "Shag For Flags";
$meta_keys = "Shag For Flags";

if (isset($meta_title_controller) && !empty($meta_title_controller)) {
    $meta_title = $meta_title_controller;
}
if (isset($meta_descr_controller) && !empty($meta_descr_controller)) {
    $meta_descr = $meta_descr_controller;
}
if (isset($meta_keys_controller) && !empty($meta_keys_controller)) {
    $meta_keys = $meta_keys_controller;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $meta_title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Description" content="<?php echo $meta_descr; ?>">
    <meta name="Keywords" content="<?php echo $meta_keys; ?>">

    <link rel="icon" href="<?php echo $view['assets']->getUrl('build/images/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('build/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('build/css/jquery-ui.css'); ?>">
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('build/css/bootstrap-datepicker.css'); ?>">
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('build/css/icomon.css'); ?>">
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('build/css/fonts.css'); ?>">
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('build/css/style.css'); ?>">
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="site-wrap">
        <?php echo $view->render('Static/logo_nav.html.php')?>

        <?php $view['slots']->output('_content') ?>

        <?php echo $view->render('Static/footer.html.php')?>

    </div>

    <?php echo $view->render('Static/js.html.php')?>
</body>
</html>