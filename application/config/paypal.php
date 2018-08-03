<?php
if ( !defined( 'BASEPATH' ) )exit( 'No direct script access allowed' );
// ------------------------------------------------------------------------
// Paypal IPN Class
// ------------------------------------------------------------------------
// Use PayPal on Sandbox or Live
$ci =& get_instance();
$set = $ci->db->select('*')->get('settings')->row_array();
switch($set['paypalsandbox']){ 
case '1':  $config[ 'sandbox' ]  = 'FALSE';break; 
case '1':  $config[ 'sandbox' ]  = 'TRUE';break; 
}
// PayPal Business Email ID
$config[ 'business' ] = $set['paypalemail'];
// If (and where) to log ipn to file
$config[ 'paypal_lib_ipn_log_file' ] = BASEPATH . 'logs/paypal_ipn.log';
$config[ 'paypal_lib_ipn_log' ] = TRUE;
// Where are the buttons located at 
$config[ 'paypal_lib_button_path' ] = 'buttons';
// What is the default currency?
$config[ 'paypal_lib_currency_code' ] = $set['paypalcurrency'];
?>