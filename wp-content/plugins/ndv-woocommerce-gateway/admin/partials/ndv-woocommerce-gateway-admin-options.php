<form action="options.php" method="post">
    <?php
    settings_fields( 'ndv_woo_settings' );
    do_settings_sections( 'ndv_woo_settings' );
    submit_button();
    ?>

</form>