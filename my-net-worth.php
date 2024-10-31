<?php
/*
   Plugin Name: My Net Worth
   Plugin URI: http://wordpress.org/extend/plugins/my-net-worth/
   Version: 2.0
   Author: NetworthShare
   Description: This widget displays a live chart of your Net Worth from <a href="https://www.networthshare.com">NetworthShare</a>.
   Text Domain: my-net-worth
   License: GPLv3
  */

/*
    "WordPress Plugin Template" Copyright (C) 2014 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This following part of this file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

$MyNetWorth_minimalRequiredPhpVersion = '5.0';

/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function MyNetWorth_noticePhpVersionWrong() {
    global $MyNetWorth_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' .
      __('Error: plugin "My Net Worth" requires a newer version of PHP to be running.',  'my-net-worth').
            '<br/>' . __('Minimal version of PHP required: ', 'my-net-worth') . '<strong>' . $MyNetWorth_minimalRequiredPhpVersion . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'my-net-worth') . '<strong>' . phpversion() . '</strong>' .
         '</div>';
}


function MyNetWorth_PhpVersionCheck() {
    global $MyNetWorth_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $MyNetWorth_minimalRequiredPhpVersion) < 0) {
        add_action('admin_notices', 'MyNetWorth_noticePhpVersionWrong');
        return false;
    }
    return true;
}

//////////////////////////////////
// Run initialization
/////////////////////////////////
class wp_my_plugin extends WP_Widget {

	// constructor
	function __construct() {
		$widget_ops = [
            'name' => 'My Net Worth Widget',
            'description' => 'This Wordpress widget displays a live chart of your Net Worth. For more information, visit https://www.networthshare.com/widget'
        ];
		parent::__construct( 'wp_my_plugin', 'My Net Worth Widget', $widget_ops);
	}

	// widget form creation
	function form($instance) {	
	}

	// widget update
	function update($new_instance, $old_instance) {
	}

	// widget display
	function widget($args, $instance) {
	$username = get_option('username');
	$entrycount = get_option('entrycount');
	?>
	<div id="NetworthShare" style="width:190px; height:220px;"></div>
	<script type="text/javascript">
		(function () {
			var head = document.getElementsByTagName("head").item(0);
			var script = document.createElement("script");
			var src = 'https://www.networthshare.com/RemoteChart.ashx?u=<?php echo $username ?>&h=120&w=180&i=NetworthShare&n=<?php echo $entrycount ?>';
			script.setAttribute("type", "text/javascript");
			script.setAttribute("src", src);
			script.setAttribute("async", true);
			var complete = false;
			script.onload = script.onreadystatechange = function () {
				if (!complete && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
					complete = true;
				}
			};
			head.appendChild(script);
		})();
	</script>
	<?php
	}
}

	function activate_mynetworth() {
	  add_option('username', '');
	  add_option('entrycount', '6');
	}

	function deactive_mynetworth() {
	  delete_option('username');
	  delete_option('entrycount');
	}

	function admin_init_mynetworth() {
	  register_setting('wp_my_plugin', 'username');
	  register_setting('wp_my_plugin', 'entrycount');
	}

	function admin_menu_mynetworth() {
	  add_options_page('My Net Worth', 'My Net Worth', 'manage_options', 'wp_my_plugin', 'options_page_mynetworth');
	}

	function options_page_mynetworth() {
	  include(WP_PLUGIN_DIR.'/my-net-worth/options.php');  
	}

register_activation_hook(__FILE__, 'activate_mynetworth');
register_deactivation_hook(__FILE__, 'deactive_mynetworth');

add_action('admin_init', 'admin_init_mynetworth');
add_action('admin_menu', 'admin_menu_mynetworth');

add_action('widgets_init', function() { register_widget("wp_my_plugin"); } );

// register widget

?>