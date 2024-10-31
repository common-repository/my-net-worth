<div class="wrap">
<h2>My Net Worth</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<?php settings_fields('wp_my_plugin'); ?>

<table class="form-table">

<tr valign="top">
<th scope="row">NetworthShare username:</th>
<td><input type="text" name="username" value="<?php echo get_option('username'); ?>" /></td>
</tr>
<tr valign="top">
<th scope="row">Number of prior entries to show (minimum 2, maximum 1440):</th>
<td><input type="text" name="entrycount" value="<?php echo get_option('entrycount'); ?>" /></td>
</tr>



</table>

<input type="hidden" name="action" value="update" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>
