<?php $view->extend("layout.html.php"); ?>
<?php echo $view->render('Resetting/reset_content.html.php', array('token' => $token, 'form' => $form)); ?>