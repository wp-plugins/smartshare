<?php
/*
Plugin Name: Smartshare
Plugin URI: http://wordpress.org/extend/plugins/smartshare/
Description: Include social share buttons in your template, that doesn't cause additional requests, javascript, css-files or iframes.
Author: Christoph Dietrich
Version: 1.0
Author URI: http://www.scrollleiste.de/
*/

/* 
    Copyright 2011 Christoph Dietrich

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

define ('SMARTSHARE_TEXTDOMAIN', 'smartshare');
define ('SMARTSHARE_FOLDER', WP_PLUGIN_URL . '/smartshare');

load_plugin_textdomain(SMARTSHARE_TEXTDOMAIN, 'wp-content/plugins/' . basename(dirname(__FILE__)), basename(dirname(__FILE__)) );


function get_twitter_link($popup = false, $linkContent = "Share on Twitter", $cssClass = "") {
	$twitterName = get_option('smartshare_twittername');
	$title = get_the_title();
	$titleLimit = 90;
	$permalinkUrl = get_permalink();
	
	// shorten title for twitter
	if(strlen($title) > $titleLimit) {
		$title = urlencode(html_entity_decode(mb_substr($title, 0, $titleLimit) . '...'));
	}
	else {
		$title = urlencode(html_entity_decode($title));
	}
	
	// add "related" and "via" parameters if twitter name is set
	if(isset($twitterName) && $twitterName != '') {
		$related = '&related=' . $twitterName;
		$via = '&via=' . $twitterName;
	}

	// build post url
	$url = 'http://twitter.com/intent/tweet?' . $related . '&text=' .$title . '&url=' . $permalinkUrl . $via . '&lang=de';
	
	// add popup handler
	if($popup) $onclick = ' onclick="window.open(this.href, \'Share on Twitter\', \'width=680,height=450\'); return false;"';
	
	// replace link content with a predefined button
	if($linkContent == "smallbutton") $linkContent = '<img src="' . SMARTSHARE_FOLDER . '/images/smalltwitter.png" alt="Share on Twitter" />';
	if($linkContent == "bigbutton") $linkContent = '<img src="' . SMARTSHARE_FOLDER . '/images/bigtwitter.png" alt="Share on Twitter" />';
	
	// add CSS class
	if($cssClass != "") $class = ' class="' . $cssClass .'"';
	
	// build share link
	return '<a href="' . $url . '"' . $onclick . $class . ' rel="nofollow" title="Share on Twitter">' . $linkContent . '</a>';
}


function the_twitter_link($popup = false, $linkContent = "Share on Twitter", $cssClass = "") {
	echo get_twitter_link($popup, $linkContent, $cssClass);
}


function get_facebook_link($popup = false, $linkContent = "Share on Facebook", $cssClass = "") {
	$title = get_the_title();
	$permalinkUrl = get_permalink();

	// build post url
	$url = 'http://www.facebook.com/sharer.php?u=' . $permalinkUrl . '&t=' . urlencode($title);
	
	// add popup handler
	if($popup) $onclick = ' onclick="window.open(this.href, \'Share on Facebook\', \'width=680,height=450\'); return false;"';
	
	// replace link content with a predefined button
	if($linkContent == "smallbutton") $linkContent = '<img src="' . SMARTSHARE_FOLDER . '/images/smallfacebook.png" alt="Share on Facebook" />';
	if($linkContent == "bigbutton") $linkContent = '<img src="' . SMARTSHARE_FOLDER . '/images/bigfacebook.png" alt="Share on Facebook" />';
	
	// add CSS class
	if($cssClass != "") $class = ' class="' . $cssClass .'"';
	
	// build share link
	return '<a href="' . $url . '"' . $onclick . $class . ' rel="nofollow" title="Share on Facebook">' . $linkContent . '</a>';
}


function the_facebook_link($popup = false, $linkContent = "Share on Facebook", $cssClass = "") {
	echo get_facebook_link($popup, $linkContent, $cssClass);
}


function get_plusone_link($linkContent = "+1", $cssClass = "") {
	$permalinkUrl = get_permalink();

	// build post url
	$url = 'https://plusone.google.com/u/0/+1/profile/?type=po&ru=' . $permalinkUrl;
	
	// replace link content with a predefined button
	if($linkContent == "smallbutton") $linkContent = '<img src="' . SMARTSHARE_FOLDER . '/images/smallplusone.png" alt="Google +1" />';
	if($linkContent == "bigbutton") $linkContent = '<img src="' . SMARTSHARE_FOLDER . '/images/bigplusone.png" alt="Google +1" />';
	
	// add CSS class
	if($cssClass != "") $class = ' class="' . $cssClass .'"';
	
	// build share link
	return '<a href="' . $url . $class . '" rel="nofollow" title="Google +1">' . $linkContent . '</a>';
}


function the_plusone_link($linkContent = "+1", $cssClass = "") {
	echo get_plusone_link($linkContent, $cssClass);
}


// backend option page
function smartshare_options_page() {
?>
<div class="wrap">
<h2>Smartshare</h2>
   
   	<form method="post" action="options.php">
   
        <?php wp_nonce_field('update-options') ?>
   
      	<table class="form-table">

         	<tr valign="top">
         		<th scope="row"><?php _e('Advertising', SMARTSHARE_TEXTDOMAIN); ?></th>
         		<td>
						<p>
							<?php _e('Click on this banner, if you like the plugin:', SMARTSHARE_TEXTDOMAIN); ?>
						</p>
						<div>
							<script type="text/javascript"><!--
							google_ad_client = "ca-pub-8109381707505306";
							/* Smartshare */
							google_ad_slot = "6993683240";
							google_ad_width = 468;
							google_ad_height = 60;
							//-->
							</script>
							<script type="text/javascript"
							src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
							</script>
						</div>
         		</td>
         	</tr>

         	<tr valign="top">
         		<th scope="row"><?php _e('Your Twitter username', SMARTSHARE_TEXTDOMAIN); ?></th>
         		<td>
                  <input type="text" name="smartshare_twittername" id="smartshare_twittername" value="<?php echo get_option('smartshare_twittername'); ?>" />
         		</td>
         	</tr>

      	</table>
   
      	<p class="submit">
      		<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save settings', SMARTSHARE_TEXTDOMAIN); ?>" />
      		<input type="hidden" name="action" value="update" />
      		<input type="hidden" name="page_options" value="smartshare_twittername" />
      	</p>

   	</form>

	<br/><br/>
	<h3><?php _e('Function Reference of Smartshare', SMARTSHARE_TEXTDOMAIN); ?></h3>
	<p><?php _e('Placing one of the following PHP codes in your template will output a sharing link.', SMARTSHARE_TEXTDOMAIN); ?></p>
	
   	<table class="form-table">
	  	<tr valign="top">
	  		<th scope="row"><?php _e('Include a Twitter share link', SMARTSHARE_TEXTDOMAIN); ?></th>
	  		<td>
				<p><code>&lt;?php the_twitter_link(); ?&gt;</code></p>
				<p><?php _e('Parameters:', SMARTSHARE_TEXTDOMAIN); ?></p>
				<dl>
					<dt><strong>$popup</strong></dt>
					<dd style="margin-left: 25px;">
						<i>(boolean) (optional)</i>
						<?php _e('Open the share page in a popup.', SMARTSHARE_TEXTDOMAIN); ?>
						<br/>
						Default: <i>false</i>
					</dd>
					<dt><strong>$linkContent</strong></dt>
					<dd style="margin-left: 25px;">
						<i>(string) (optional)</i>
						<?php _e('Text or HTML (e.g. an image) that is linked to the share page. There two kind of images predefined, if you want to link a button: "smallbutton" and "bigbutton". Use one of these keywords as argument to get one of the buttons.', SMARTSHARE_TEXTDOMAIN); ?>
						<br/>
						Default: <i>"Share on Twitter"</i>
					</dd>
					<dt><strong>$cssClass</strong></dt>
					<dd style="margin-left: 25px;">
						<i>(string) (optional)</i>
						<?php _e('CSS-class to add to the link.', SMARTSHARE_TEXTDOMAIN); ?>
						<br/>
						Default: <i>none</i>
					</dd>
				</dl>
	  		</td>
	  	</tr>
	  	<tr valign="top">
	  		<th scope="row"><?php _e('Include a Facebook share link', SMARTSHARE_TEXTDOMAIN); ?></th>
	  		<td>
				<p><code>&lt;?php the_facebook_link(); ?&gt;</code></p>
				<p><?php _e('Parameters:', SMARTSHARE_TEXTDOMAIN); ?></p>
				<dl>
					<dt><strong>$popup</strong></dt>
					<dd style="margin-left: 25px;">
						<i>(boolean) (optional)</i>
						<?php _e('Open the share page in a popup.', SMARTSHARE_TEXTDOMAIN); ?>
						<br/>
						Default: <i>false</i>
					</dd>
					<dt><strong>$linkContent</strong></dt>
					<dd style="margin-left: 25px;">
						<i>(string) (optional)</i>
						<?php _e('Text or HTML (e.g. an image) that is linked to the share page. There two kind of images predefined, if you want to link a button: "smallbutton" and "bigbutton". Use one of these keywords as argument to get one of the buttons.', SMARTSHARE_TEXTDOMAIN); ?>
						<br/>
						Default: <i>"Share on Facebook"</i>
					</dd>
					<dt><strong>$cssClass</strong></dt>
					<dd style="margin-left: 25px;">
						<i>(string) (optional)</i>
						<?php _e('CSS-class to add to the link.', SMARTSHARE_TEXTDOMAIN); ?>
						<br/>
						Default: <i>none</i>
					</dd>
				</dl>
	  		</td>
	  	</tr>
	  	<tr valign="top">
	  		<th scope="row"><?php _e('Include a Google +1 link', SMARTSHARE_TEXTDOMAIN); ?></th>
	  		<td>
				<p><code>&lt;?php the_plusone_link(); ?&gt;</code></p>
				<p><?php _e('Parameters:', SMARTSHARE_TEXTDOMAIN); ?></p>
				<dl>
					<dt><strong>$linkContent</strong></dt>
					<dd style="margin-left: 25px;">
						<i>(string) (optional)</i>
						<?php _e('Text or HTML (e.g. an image) that is linked to the share page. There two kind of images predefined, if you want to link a button: "smallbutton" and "bigbutton". Use one of these keywords as argument to get one of the buttons.', SMARTSHARE_TEXTDOMAIN); ?>
						<br/>
						Default: <i>"+1"</i>
					</dd>
					<dt><strong>$cssClass</strong></dt>
					<dd style="margin-left: 25px;">
						<i>(string) (optional)</i>
						<?php _e('CSS-class to add to the link.', SMARTSHARE_TEXTDOMAIN); ?>
						<br/>
						Default: <i>none</i>
					</dd>
				</dl>
	  		</td>
	  	</tr>
	</table>
	<p>
		<?php _e('Want to receive the link as a string variable instead of echoing it?', SMARTSHARE_TEXTDOMAIN); ?>
		<?php _e('Use', SMARTSHARE_TEXTDOMAIN); ?>
		<code>&lt;?php&nbsp;get_twitter_link();&nbsp;?&gt;</code>,
		<code>&lt;?php&nbsp;get_facebook_link();&nbsp;?&gt;</code>
		<?php _e('or', SMARTSHARE_TEXTDOMAIN); ?>
		<code>&lt;?php&nbsp;get_plusone_link();&nbsp;?&gt;</code>
		<?php _e('with the same parameters.', SMARTSHARE_TEXTDOMAIN); ?>.
	</p>
   
</div>
   
<?php
}


// add option page to backend
function smartshare_admin_menu() {
   add_options_page('Smartshare', 'Smartshare', 'manage_options', basename(__FILE__), 'smartshare_options_page');
}
add_action('admin_menu', 'smartshare_admin_menu');


?>