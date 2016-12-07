<?php
/*
Plugin Name: Simple TPV Sermepa
Plugin URI: http://www.rafelsanso.com/
Description: Simple form for integrate a TPV in your website.
Version: 1.0
Author: Rafel Sanso
Author URI: http://www.rafelsanso.com/
License: GPLv2 or later
*/

// create custom plugin settings menu
add_action('admin_menu', 'simple_tpv_menu');

// Initializes plugin
function simple_tpv_menu()
{
	//Añadimos el menú, con el icono de 17x17 píxeles dentro de la carpeta del plugin
	add_menu_page( _('Configuration'), _('Simple TPV Sermepa'), 'administrator', __FILE__, 'simple_tpv_settings_page', plugins_url('/img/simple-tpv-icon.png', __FILE__));

	//activamos esta función
	add_action( 'admin_init', 'simple_tpv_settings' );
}

function simple_tpv_settings() {
  register_setting( 'simple-tpv', 'Concept' );
  register_setting( 'simple-tpv', 'Commerce_Name' );
  register_setting( 'simple-tpv', 'Ds_Signature' );
  register_setting( 'simple-tpv', 'Ds_Amount' );
  register_setting( 'simple-tpv', 'Ds_Order' );
  register_setting( 'simple-tpv', 'Ds_MerchantCode' );
  register_setting( 'simple-tpv', 'Ds_Currency' );
  register_setting( 'simple-tpv', 'Ds_Date' );
  register_setting( 'simple-tpv', 'Secret_Key' );

  register_setting( 'simple-tpv', 'Demo_URI' );
  register_setting( 'simple-tpv', 'Production_URI' );
  register_setting( 'simple-tpv', 'Ds_Merchant_Currency' );
  //register_setting( 'simple-tpv', 'Ds_Merchant_Amount' ); Contant = 1
  // register_setting( 'simple-tpv', 'Ds_Merchant_Order' ); Date variable = date(ymdHis)
  register_setting( 'simple-tpv', 'Ds_Merchant_MerchantCode' );
  register_setting( 'simple-tpv', 'Ds_Merchant_Terminal' );
  // register_setting( 'simple-tpv', 'Ds_Merchant_TransactionType' ); Constant = 0
  register_setting( 'simple-tpv', 'Ds_Merchant_MerchantURL' );
  register_setting( 'simple-tpv', 'Ds_Merchant_UrlOK' );
  register_setting( 'simple-tpv', 'Ds_Merchant_UrlKO' );
  register_setting( 'simple-tpv', 'Ds_Merchant_MerchantSignature' );
  register_setting( 'simple-tpv', 'Ds_Merchant_ConsumerLanguage' );
  register_setting( 'simple-tpv', 'Which_Environment' );
}

function simple_tpv_settings_page() {
?>
<div class="wrap">
<h2><?php _e('Simple TPV Sermepa Configuration'); ?></h2>
<hr>
<p><?php _e('The follow form need your bank infomation. Please, contact with your bank before integrate this plugin.'); ?></p>

<form method="post" action="options.php">
    <?php settings_fields( 'simple-tpv' ); ?>
    <?php do_settings_sections( 'simple-tpv' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Product Concept</th>
        <td><input type="text" name="Concept" value="<?php echo esc_attr( get_option('Concept') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Secret Key</th>
        <td><input type="text" name="Secret_Key" value="<?php echo esc_attr( get_option('Secret_Key') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Commerce Name</th>
        <td><input type="text" name="Commerce_Name" value="<?php echo esc_attr( get_option('Commerce_Name') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Merchant Code</th>
        <td><input type="text" name="Ds_Merchant_MerchantCode" value="<?php echo esc_attr( get_option('Ds_Merchant_MerchantCode') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Terminal</th>
        <td><input type="text" name="Ds_Merchant_Terminal" value="<?php echo esc_attr( get_option('Ds_Merchant_Terminal') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Currency Code</th>
        <td><input type="text" name="Ds_Merchant_Currency" value="<?php echo esc_attr( get_option('Ds_Merchant_Currency') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Commerce URL</th>
        <td><input type="text" name="Ds_Merchant_MerchantURL" value="<?php echo esc_attr( get_option('Ds_Merchant_MerchantURL') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Commerce URL Success</th>
        <td><input type="text" name="Ds_Merchant_UrlOK" value="<?php echo esc_attr( get_option('Ds_Merchant_UrlOK') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Commerce URL Error</th>
        <td><input type="text" name="Ds_Merchant_UrlKO" value="<?php echo esc_attr( get_option('Ds_Merchant_UrlKO') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Select the environment</th>
        <td>
          <label>
            <input type="radio" name="Which_Environment" value="0" <?php if (esc_attr( get_option('Which_Environment') ) == 0 ) { echo 'checked="checked"'; } ?> /> <?php _e('Test'); ?>
          </label>
          <label>
            <input type="radio" name="Which_Environment" value="1" <?php if (esc_attr( get_option('Which_Environment') ) == 1 ) { echo 'checked="checked"'; } ?> /> <?php _e('Real'); ?>
          </label>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Demo_URI</th>
        <td><input type="text" name="Demo_URI" value="<?php echo esc_attr( get_option('Demo_URI') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Production_URI</th>
        <td><input type="text" name="Production_URI" value="<?php echo esc_attr( get_option('Production_URI') ); ?>" /></td>
        </tr>
    </table>

    <?php submit_button(); ?>

</form>
</div>
<?php }

// Load shortcode
add_shortcode("simpleTPV", "simpleTPVShortcode");

// A la función le hemos añadido el parámetro del color. Por defecto, el color será negro.
function simpleTPVShortcode() {

$output = '
<form method="post" target="_blank" action="' . get_bloginfo('url') . '/index.php?tpvconfirmation' . '">
  <div class="form-group">
    <label for="nameInput">' . __('Name') . '</label>
    <input type="text" class="form-control" id="nameInput" name="nameInput">
  </div>
  <div class="form-group">
    <label for="conceptInput">' . __('Concept') . '</label>
    <input type="text" class="form-control" id="conceptInput" name="conceptInput">
  </div>
  <div class="form-group">
    <label for="amountInput">' . __('Amount (in EUR)') . '</label>
    <input type="text" class="form-control" id="amountInput" name="amountInput" placeholder="0,00">
  </div>
  <button type="submit" class="btn btn-default">' . __('Send') . '</button>
</form>
';

return $output;
}

// Create the query var so that WP catches the custom /member/username url
function userpage_rewrite_add_var( $vars ) {
    $vars[] = 'tpvconfirmation';
    return $vars;
}
add_filter( 'query_vars', 'userpage_rewrite_add_var' );

// Create the rewrites
function userpage_rewrite_rule() {
    add_rewrite_tag( '%tpvconfirmation%', '([^&]+)' );
    add_rewrite_rule(
        '^tpvconfirmation/([^/]*)/?',
        'index.php?tpvconfirmation=$matches[1]',
        'top'
    );
}
add_action('init','userpage_rewrite_rule');

// Catch the URL and redirect it to a template file
function userpage_rewrite_catch() {
    global $wp_query;

    if ( array_key_exists( 'tpvconfirmation', $wp_query->query_vars ) ) {
        include 'resume.php';
        exit;
        //return $file;
    }
}
add_action( 'template_redirect', 'userpage_rewrite_catch' );

// Code needed to finish the member page setup
function memberpage_rewrite() {
     global $wp_rewrite;
     $wp_rewrite->flush_rules();
}
add_action('init','memberpage_rewrite');
