<?php
   /*
   Plugin Name: Woo Web Tweaks
   Plugin URI: https://github.com/aronwp/woo-web
   GitHub Plugin URI: /aronwp/woo-web
   Description: Tweaks to enhance WordPress
   Version: 1.2
   Author: Woo Web Design Inc.
   Author URI: http://woowebdesign.com
   License: GPL2
   */

// Enable Maintenance Mode
/* function wpr_maintenance_mode() {
    if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
        wp_die('Maintenance, please come back soon.');
    }
}
add_action('get_header', 'wpr_maintenance_mode');
*/

// disable theme switching for everyone other than user WordPress was setup by
add_action('admin_init', 'slt_lock_theme');
function slt_lock_theme() {
   global $submenu, $userdata;
   get_currentuserinfo();
   if ($userdata->ID != 1) {
      unset($submenu['themes.php'][5]);
      unset($submenu['themes.php'][15]);
   }
}

define( 'DISALLOW_FILE_EDIT', true ); //Disallow edition of files throught WP editor
define( 'DISALLOW_FILE_MODS',true); //Disallow install of upgrades or deletion of plugins
define('EMPTY_TRASH_DAYS', 30); //Empty trash after 30 days


// allow user to login with username or email
function login_with_email_address($username) {
        $user = get_user_by('email',$username);
        if(!empty($user->user_login))
                $username = $user->user_login;
        return $username;
}
add_action('wp_authenticate','login_with_email_address');
function change_username_wps_text($text){
       if(in_array($GLOBALS['pagenow'], array('wp-login.php'))){
         if ($text == 'Username'){$text = 'Username or Email';}
            }
                return $text;
         }
add_filter( 'gettext', 'change_username_wps_text' );

// hide the update nag within the wordpress admin
function remove_upgrade_nag() {
   echo '<style type="text/css">
           .update-nag {display: none}
         </style>';
}
add_action('admin_head', 'remove_upgrade_nag');

//Automatically spam comments with a very long url
  function rkv_url_spamcheck( $approved , $commentdata ) {
    return ( strlen( $commentdata['comment_author_url'] ) > 50 ) ? 'spam' : $approved;
}

add_filter( 'pre_comment_approved', 'rkv_url_spamcheck', 99, 2 );











?>