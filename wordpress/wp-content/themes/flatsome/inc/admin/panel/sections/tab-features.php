<?php
/**
 * Flatsome Features
 *
 * @package Flatsome\Admin
 */

?>

<div id="tab-features">
	<div class="col cols panel flatsome-panel">
		<div class="inner-panel">
			<form method="post" action="options.php">
				<?php settings_errors(); ?>
				<?php settings_fields( 'flatsome-features' ); ?>
				<?php do_settings_sections( 'flatsome-features' ); ?>
				<?php submit_button( '', 'primary large' ); ?>
			</form>
		</div>
	</div>
</div>
