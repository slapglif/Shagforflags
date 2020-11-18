<?php
$alert = $this->get("quick")->showAlert();
?>

<?php if ($alert) {?>
    <div class="row">
        <div class="col-md-12">
            <?php echo $alert; ?>
        </div>
    </div>
<?php } ?>
