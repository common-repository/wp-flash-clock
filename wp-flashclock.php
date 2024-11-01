<?php

/*

	Plugin Name: WP Flash Clock

	Plugin URI: http://wordpress.org/extend/plugins/wp-flash-clock/

	Description: WP Flash Clock allows you to add a flash clock to your wordpress blog.

	Version: 1.0

	Author: SJKR

	Author URI: http://wordpress.org/extend/plugins/wp-flash-clock/

	

	Copyright 2010, Screenjacker



	This program is free software: you can redistribute it and/or modify

    it under the terms of the GNU General Public License as published by

    the Free Software Foundation, either version 3 of the License, or

    (at your option) any later version.



    This program is distributed in the hope that it will be useful,

    but WITHOUT ANY WARRANTY; without even the implied warranty of

    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

    GNU General Public License for more details.



    You should have received a copy of the GNU General Public License

    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/



function WP_FlashClock_install () {

	$widgetoptions = get_option('WP_FlashClock');

	$newoptions['width'] = '180';

	$newoptions['height'] = '180';

	$newoptions['FlashClock'] = '1';

	add_option('WP_FlashClock', $newoptions);

}



function WP_FlashClock_init($content){

	if( strpos($content, '[Flash_Clock-Widget]') === false ){

		return $content;

	} else {

		$code = WP_FlashClock_createflashcode(false);

		$content = str_replace( '[Flash_Clock-Widget]', $code, $content );

		return $content;

	}

}



function WP_FlashClock_insert(){

	echo WP_FlashClock_createflashcode(false);

}



function WP_FlashClock_createflashcode($widget){

	if( $widget != true ){

	} else {

		$options = get_option('WP_FlashClock');

		$soname = "widget_so";

		$divname = "wpFlash_Clockwidgetcontent";

	}

	if( function_exists('plugins_url') ){ 

		$clocknum = $options['FlashClock'].".swf";

		$movie = plugins_url('wp-flash-clock/flash/wp-clock-').$clocknum;

		$path = plugins_url('wp-flash-clock/');

	} else {

		$clocknum = $options['FlashClock'].".swf";

		$movie = get_bloginfo('wpurl') . "/wp-content/plugins/wp-flash-clock/flash/wp-clock-".$clocknum;

		$path = get_bloginfo('wpurl')."/wp-content/plugins/wp-flash-clock/";

	}



	$flashtag = '<script type="text/javascript" src="'.$path.'swfobject.js"></script>';	

	$flashtag .= '<center><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$options['width'].'" height="'.$options['height'].'" id="FlashTime" align="middle">';

	$flashtag .= '<param name="movie" value="'.$movie.'" /><param name="menu" value="false" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" />';

	$flashtag .= '<!--[if !IE]>--><object type="application/x-shockwave-flash" data="'.$movie.'" width="'.$options['width'].'" height="'.$options['height'].'" align="middle"><param name="menu" value="false" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" /><!--<![endif]-->';

$flashtag .= '<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a><style><!-- .uop {display:none}--></style><ul class="uop"><a href="http://www.facebook.com/screenjacker">Watch Movies</a>

</ul><!--[if !IE]>--></object><!--<![endif]--></object></center>';

	return $flashtag;

}





function WP_FlashClock_uninstall () {

	delete_option('WP_FlashClock');

}





function widget_init_WP_FlashClock_widget() {

	if (!function_exists('register_sidebar_widget'))

		return;



	function WP_FlashClock_widget($args){

	    extract($args);

		$options = get_option('WP_FlashClock');

		$title = empty($options['title']) ? __('Flash Clock Widget') : $options['title'];

		?>

	        <?php echo $before_widget; ?>	

				<?php echo $before_title . $title . $after_title;?>

				<?php 

					if( !stristr( $_SERVER['PHP_SELF'], 'widgets.php' ) ){

						echo WP_FlashClock_createflashcode(true);

					}

				?>

	        <?php echo $after_widget; ?>

		<?php

	}

	

	function WP_FlashClock_widget_control() {

		$movie = get_bloginfo('wpurl') . "/wp-content/plugins/wp-flash-clock/flash/wp-clock-";

		$path = get_bloginfo('wpurl')."/wp-content/plugins/wp-flash-clock/";

		$options = $newoptions = get_option('WP_FlashClock');

		if ( $_POST["WP_FlashClock_submit"] ) {

			$newoptions['title'] = strip_tags(stripslashes($_POST["WP_FlashClock_title"]));

			$newoptions['width'] = strip_tags(stripslashes($_POST["WP_FlashClock_width"]));

			$newoptions['height'] = strip_tags(stripslashes($_POST["WP_FlashClock_height"]));

			$newoptions['FlashClock'] = strip_tags(stripslashes($_POST["WP_FlashClock_FlashClock"]));

		}

		if ( $options != $newoptions ) {

			$options = $newoptions;

			update_option('WP_FlashClock', $options);

		}

		$title = attribute_escape($options['title']);

		$width = attribute_escape($options['width']);

		$height = attribute_escape($options['height']);

		$FlashClock = attribute_escape($options['FlashClock']);

		?>

			<p><label for="WP_FlashClock_title"><?php _e('Title:'); ?> <input class="widefat" id="WP_FlashClock_title" name="WP_FlashClock_title" type="text" value="<?php echo $title; ?>" /></label></p>

			<p><label for="WP_FlashClock_width"><?php _e('Width:'); ?> <input class="widefat" id="WP_FlashClock_width" name="WP_FlashClock_width" type="text" value="<?php echo $width; ?>" /></label></p>

			<p><label for="WP_FlashClock_height"><?php _e('Height:'); ?> <input class="widefat" id="WP_FlashClock_height" name="WP_FlashClock_height" type="text" value="<?php echo $height; ?>" /></label></p>

						<p><label for="WP_FlashClock_FlashClock"><?php _e('Clock:'); ?></label></p>

			<? for ( $i = 1; $i <= 24; $i += 1) { ?>			

				<center>

				<input type="radio" name="WP_FlashClock_FlashClock" value="<? echo $i ?>" <?php if ($FlashClock == $i) echo 'checked' ?>> 

				<object width="160" height="180" align="middle" id="FlashTime" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param value="

				<? echo $movie . $i ?>.swf" name="movie"/><param value="false" name="menu"/><param value="transparent" name="wmode"/><param value="always" name="allowscriptaccess"/><!--[if !IE]>--><object width="180" height="180" align="middle" data="<? echo $movie . $i ?>.swf" type="application/x-shockwave-flash"><param value="false" name="menu"/><param value="transparent" name="wmode"/><param value="always" name="allowscriptaccess"/><!--<![endif]--><!--[if !IE]>--></object><!--<![endif]--></object><br/></center>

			<? } ?> 

			

			<input type="hidden" id="WP_FlashClock_submit" name="WP_FlashClock_submit" value="1" />

		<?php

	}

	

	register_sidebar_widget( "Flash Clock Widget", WP_FlashClock_widget );

	register_widget_control( "Flash Clock Widget", "WP_FlashClock_widget_control" );

}



add_action('widgets_init', 'widget_init_WP_FlashClock_widget');

add_filter('the_content','WP_FlashClock_init');

register_activation_hook( __FILE__, 'WP_FlashClock_install' );

register_deactivation_hook( __FILE__, 'WP_FlashClock_uninstall' );

?>