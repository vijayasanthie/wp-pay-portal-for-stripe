<?php
/**
* Plugin Name: WP Pay Portal For Stripe
* Plugin URI: http://mailarchiva.net
* Description: This plugin used for managing their subscription, invoices, etc..
* Version: 1.0
* Author: Your Vijayasanthi E
* Author URI: http://stallioni.com
**/
define( 'WPSTRIPESM_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPSTRIPESM_URL', plugin_dir_url( __FILE__ ) );



define('SUBPRELOADER_IMG', WPSTRIPESM_URL . 'assets/images/subpreloader.gif');
define('PRELOADER_IMG', WPSTRIPESM_URL . 'assets/images/preloader.gif');
define('IMAGE_PATH', WPSTRIPESM_URL . 'assets/images/');


define('UTILS_JS', WPSTRIPESM_URL . 'assets/intltel/js/utils.js');


$country_array = array(
""=>"Select Country",
"AF" => "Afghanistan",
"AL" => "Albania",
"DZ" => "Algeria",
"AS" => "American Samoa",
"AD" => "Andorra",
"AO" => "Angola",
"AI" => "Anguilla",
"AQ" => "Antarctica",
"AG" => "Antigua and Barbuda",
"AR" => "Argentina",
"AM" => "Armenia",
"AW" => "Aruba",
"AU" => "Australia",
"AT" => "Austria",
"AZ" => "Azerbaijan",
"BS" => "Bahamas",
"BH" => "Bahrain",
"BD" => "Bangladesh",
"BB" => "Barbados",
"BY" => "Belarus",
"BE" => "Belgium",
"BZ" => "Belize",
"BJ" => "Benin",
"BM" => "Bermuda",
"BT" => "Bhutan",
"BO" => "Bolivia",
"BA" => "Bosnia and Herzegovina",
"BW" => "Botswana",
"BV" => "Bouvet Island",
"BR" => "Brazil",
"BQ" => "British Antarctic Territory",
"IO" => "British Indian Ocean Territory",
"VG" => "British Virgin Islands",
"BN" => "Brunei",
"BG" => "Bulgaria",
"BF" => "Burkina Faso",
"BI" => "Burundi",
"KH" => "Cambodia",
"CM" => "Cameroon",
"CA" => "Canada",
"CT" => "Canton and Enderbury Islands",
"CV" => "Cape Verde",
"KY" => "Cayman Islands",
"CF" => "Central African Republic",
"TD" => "Chad",
"CL" => "Chile",
"CN" => "China",
"CX" => "Christmas Island",
"CC" => "Cocos [Keeling] Islands",
"CO" => "Colombia",
"KM" => "Comoros",
"CG" => "Congo - Brazzaville",
"CD" => "Congo - Kinshasa",
"CK" => "Cook Islands",
"CR" => "Costa Rica",
"HR" => "Croatia",
"CU" => "Cuba",
"CY" => "Cyprus",
"CZ" => "Czech Republic",
"CI" => "Côte d’Ivoire",
"DK" => "Denmark",
"DJ" => "Djibouti",
"DM" => "Dominica",
"DO" => "Dominican Republic",
"NQ" => "Dronning Maud Land",
"DD" => "East Germany",
"EC" => "Ecuador",
"EG" => "Egypt",
"SV" => "El Salvador",
"GQ" => "Equatorial Guinea",
"ER" => "Eritrea",
"EE" => "Estonia",
"ET" => "Ethiopia",
"FK" => "Falkland Islands",
"FO" => "Faroe Islands",
"FJ" => "Fiji",
"FI" => "Finland",
"FR" => "France",
"GF" => "French Guiana",
"PF" => "French Polynesia",
"TF" => "French Southern Territories",
"FQ" => "French Southern and Antarctic Territories",
"GA" => "Gabon",
"GM" => "Gambia",
"GE" => "Georgia",
"DE" => "Germany",
"GH" => "Ghana",
"GI" => "Gibraltar",
"GR" => "Greece",
"GL" => "Greenland",
"GD" => "Grenada",
"GP" => "Guadeloupe",
"GU" => "Guam",
"GT" => "Guatemala",
"GG" => "Guernsey",
"GN" => "Guinea",
"GW" => "Guinea-Bissau",
"GY" => "Guyana",
"HT" => "Haiti",
"HM" => "Heard Island and McDonald Islands",
"HN" => "Honduras",
"HK" => "Hong Kong SAR China",
"HU" => "Hungary",
"IS" => "Iceland",
"IN" => "India",
"ID" => "Indonesia",
"IR" => "Iran",
"IQ" => "Iraq",
"IE" => "Ireland",
"IM" => "Isle of Man",
"IL" => "Israel",
"IT" => "Italy",
"JM" => "Jamaica",
"JP" => "Japan",
"JE" => "Jersey",
"JT" => "Johnston Island",
"JO" => "Jordan",
"KZ" => "Kazakhstan",
"KE" => "Kenya",
"KI" => "Kiribati",
"KW" => "Kuwait",
"KG" => "Kyrgyzstan",
"LA" => "Laos",
"LV" => "Latvia",
"LB" => "Lebanon",
"LS" => "Lesotho",
"LR" => "Liberia",
"LY" => "Libya",
"LI" => "Liechtenstein",
"LT" => "Lithuania",
"LU" => "Luxembourg",
"MO" => "Macau SAR China",
"MK" => "Macedonia",
"MG" => "Madagascar",
"MW" => "Malawi",
"MY" => "Malaysia",
"MV" => "Maldives",
"ML" => "Mali",
"MT" => "Malta",
"MH" => "Marshall Islands",
"MQ" => "Martinique",
"MR" => "Mauritania",
"MU" => "Mauritius",
"YT" => "Mayotte",
"FX" => "Metropolitan France",
"MX" => "Mexico",
"FM" => "Micronesia",
"MI" => "Midway Islands",
"MD" => "Moldova",
"MC" => "Monaco",
"MN" => "Mongolia",
"ME" => "Montenegro",
"MS" => "Montserrat",
"MA" => "Morocco",
"MZ" => "Mozambique",
"MM" => "Myanmar [Burma]",
"NA" => "Namibia",
"NR" => "Nauru",
"NP" => "Nepal",
"NL" => "Netherlands",
"AN" => "Netherlands Antilles",
"NT" => "Neutral Zone",
"NC" => "New Caledonia",
"NZ" => "New Zealand",
"NI" => "Nicaragua",
"NE" => "Niger",
"NG" => "Nigeria",
"NU" => "Niue",
"NF" => "Norfolk Island",
"KP" => "North Korea",
"VD" => "North Vietnam",
"MP" => "Northern Mariana Islands",
"NO" => "Norway",
"OM" => "Oman",
"PC" => "Pacific Islands Trust Territory",
"PK" => "Pakistan",
"PW" => "Palau",
"PS" => "Palestinian Territories",
"PA" => "Panama",
"PZ" => "Panama Canal Zone",
"PG" => "Papua New Guinea",
"PY" => "Paraguay",
"YD" => "People's Democratic Republic of Yemen",
"PE" => "Peru",
"PH" => "Philippines",
"PN" => "Pitcairn Islands",
"PL" => "Poland",
"PT" => "Portugal",
"PR" => "Puerto Rico",
"QA" => "Qatar",
"RO" => "Romania",
"RU" => "Russia",
"RW" => "Rwanda",
"RE" => "Réunion",
"BL" => "Saint Barthélemy",
"SH" => "Saint Helena",
"KN" => "Saint Kitts and Nevis",
"LC" => "Saint Lucia",
"MF" => "Saint Martin",
"PM" => "Saint Pierre and Miquelon",
"VC" => "Saint Vincent and the Grenadines",
"WS" => "Samoa",
"SM" => "San Marino",
"SA" => "Saudi Arabia",
"SN" => "Senegal",
"RS" => "Serbia",
"CS" => "Serbia and Montenegro",
"SC" => "Seychelles",
"SL" => "Sierra Leone",
"SG" => "Singapore",
"SK" => "Slovakia",
"SI" => "Slovenia",
"SB" => "Solomon Islands",
"SO" => "Somalia",
"ZA" => "South Africa",
"GS" => "South Georgia and the South Sandwich Islands",
"KR" => "South Korea",
"ES" => "Spain",
"LK" => "Sri Lanka",
"SD" => "Sudan",
"SR" => "Suriname",
"SJ" => "Svalbard and Jan Mayen",
"SZ" => "Swaziland",
"SE" => "Sweden",
"CH" => "Switzerland",
"SY" => "Syria",
"ST" => "São Tomé and Príncipe",
"TW" => "Taiwan",
"TJ" => "Tajikistan",
"TZ" => "Tanzania",
"TH" => "Thailand",
"TL" => "Timor-Leste",
"TG" => "Togo",
"TK" => "Tokelau",
"TO" => "Tonga",
"TT" => "Trinidad and Tobago",
"TN" => "Tunisia",
"TR" => "Turkey",
"TM" => "Turkmenistan",
"TC" => "Turks and Caicos Islands",
"TV" => "Tuvalu",
"UM" => "U.S. Minor Outlying Islands",
"PU" => "U.S. Miscellaneous Pacific Islands",
"VI" => "U.S. Virgin Islands",
"UG" => "Uganda",
"UA" => "Ukraine",
"SU" => "Union of Soviet Socialist Republics",
"AE" => "United Arab Emirates",
"GB" => "United Kingdom",
"US" => "United States",
"ZZ" => "Unknown or Invalid Region",
"UY" => "Uruguay",
"UZ" => "Uzbekistan",
"VU" => "Vanuatu",
"VA" => "Vatican City",
"VE" => "Venezuela",
"VN" => "Vietnam",
"WK" => "Wake Island",
"WF" => "Wallis and Futuna",
"EH" => "Western Sahara",
"YE" => "Yemen",
"ZM" => "Zambia",
"ZW" => "Zimbabwe",
"AX" => "Åland Islands",
);

define('WSSM_COUNTRY', $country_array);


$currency_array = array(
'usd' => 'US $',
'eur' => 'EUR €',
'zar' => 'ZAR R',
'aud' => 'AUD $',
'nzd' => 'NZD $',
'cad' => 'CAD $',
'gbp' => 'GBP £',
'yen' => 'YEN ¥',
'inr' => 'INR',
);



define('WSSM_CURRENCY', $currency_array);

define('WSSM_PAYMENT_TYPES', array('charge_automatically' => 'Auto pay', 'send_invoice' => 'Manual'));


global $wpdb;
$table_name = $wpdb->prefix . "wssm_country_currency_map";
define( 'WSSM_CURCOUNTRY_TABLE_NAME', $table_name);

$table_name1 = $wpdb->prefix . "wssm_metadata";
define( 'WSSM_METADATA_TABLE_NAME', $table_name1);

$table_name2 = $wpdb->prefix . "wssm_user_stripeplan";
define( 'WSSM_USERPLAN_TABLE_NAME', $table_name2);



// define('SUBCSRIPTION_TYPES',array('flat_subscriptions' => 'Flat Subscription','meter_subscription' => 'Metered-based Subscription','multi_tier_subscription' =>'Multi-tier subscription'));


register_activation_hook( __FILE__, 'wssm_activation_fn' );
register_deactivation_hook( __FILE__, 'wssm_deactivation_fn' );

function wssm_activation_fn(){



    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


    $table_name = WSSM_CURCOUNTRY_TABLE_NAME; 
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
   `ccmap_id` int(11) NOT NULL AUTO_INCREMENT,
   `country_code` varchar(250) DEFAULT NULL,
   `currency_code` varchar(250) DEFAULT NULL,
   `status` int(11) DEFAULT '1',
   `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`ccmap_id`)
    ) $charset_collate;";
    dbDelta( $sql );



    $table_name1 = WSSM_METADATA_TABLE_NAME; 
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name1 (
   `mid` int(11) NOT NULL AUTO_INCREMENT,
   `stripe_fname` varchar(250) DEFAULT NULL,
   `sublist_activation` int(11) NOT NULL DEFAULT '0',
   `sublist_activation_label` varchar(250) DEFAULT NULL,
   `newsub_activation` int(11) NOT NULL DEFAULT '0',
   `newsub_activation_label` varchar(250) NOT NULL,
   `status` int(11) NOT NULL DEFAULT '1',
   `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`mid`)
    ) $charset_collate;";
    dbDelta( $sql );


    $table_name2 = WSSM_USERPLAN_TABLE_NAME; 
    $charset_collate = $wpdb->get_charset_collate();
    $sql2 = "CREATE TABLE IF NOT EXISTS $table_name2 (
    `suser_id` int(11) NOT NULL AUTO_INCREMENT,
     `plan_details` text,
     `activation_code` varchar(250) DEFAULT NULL,
     `user_oldemail` varchar(250) DEFAULT NULL,
     `user_newemail` varchar(250) DEFAULT NULL,
     `link_expire` varchar(100) DEFAULT NULL,
     `full_name` varchar(250) DEFAULT NULL,
     `password` varchar(250) DEFAULT NULL,
     `phone_number` varchar(250) DEFAULT NULL,
     `status_type` varchar(250) NOT NULL,
     `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`suser_id`)
      ) $charset_collate;";
    dbDelta( $sql2 );


    $my_post1 = array(
      'post_title'    => wp_strip_all_tags( 'WP Pay Portal' ),
      'post_content'  => '[WSSM_STRIPE_MANAGEMENT]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-account-info'
    );
    wp_insert_post( $my_post1 );

    $my_post2 = array(
      'post_title'    => wp_strip_all_tags( 'Stripe Payment Methods' ),
      'post_content'  => '[WSSM_STRIPE_CARD]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-payment-methods'
    );
    wp_insert_post( $my_post2 );

    $my_post3 = array(
      'post_title'    => wp_strip_all_tags( 'Stripe Invoices' ),
      'post_content'  => '[WSSM_STRIPE_INVOICE]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-invoices'
    );
    wp_insert_post( $my_post3 );

    $my_post4 = array(
      'post_title'    => wp_strip_all_tags( 'Stripe Subscription' ),
      'post_content'  => '[WSSM_STRIPE_SUBSCRIPTION]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-subscription'
    );
    wp_insert_post( $my_post4 );

    $my_post5 = array(
      'post_title'    => wp_strip_all_tags( 'Stripe Add New Subscription' ),
      'post_content'  => '[WSSM_STRIPE_ADDSUBSCRIPTION]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-add-subscription'
    );
    wp_insert_post( $my_post5 );


    $my_post6 = array(
      'post_title'    => wp_strip_all_tags( 'Email Verification' ),
      'post_content'  => '[WSSM_EMAIL_VERIFICATION]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-email-verfication'
    );
    wp_insert_post( $my_post6 );

    $my_post7 = array(
      'post_title'    => wp_strip_all_tags( 'Login / Register' ),
      'post_content'  => '[WSSM_LOGIN_REGISTER]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-login-register'
    );
    wp_insert_post( $my_post7 );


    $my_post8 = array(
      'post_title'    => wp_strip_all_tags( 'More Users' ),
      'post_content'  => '[WSSM_STRIPE_ADDITIONAL_USERS]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-additional-users'
    );
    wp_insert_post( $my_post8 );

    $my_post9 = array(
      'post_title'    => wp_strip_all_tags( 'Xero Authorization' ),
      'post_content'  => '[WSSM_STRIPE_XERO_AUTHORIZATION]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-xero-authorization'
    );
    wp_insert_post( $my_post9 );

    $my_post10 = array(
      'post_title'    => wp_strip_all_tags( 'Xero Callback' ),
      'post_content'  => '[WSSM_STRIPE_XERO_CALLBACK]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'wp-stripe-xero-callback'
    );
    wp_insert_post( $my_post10 );


    update_option( 'wssm_stripe_page_acounttinfo', 'wp-stripe-account-info' );
    update_option( 'wssm_stripe_page_card', 'wp-stripe-payment-methods' );
    update_option( 'wssm_stripe_page_invoice', 'wp-stripe-invoices' );
    update_option( 'wssm_stripe_page_subscription', 'wp-stripe-subscription' );
    update_option( 'wssm_stripe_page_addsubscription', 'wp-stripe-add-subscription' );
    update_option( 'wssm_mail_urlredirect', 'wp-stripe-email-verfication' );
    update_option( 'wssm_logreg_urlredirect', 'wp-stripe-login-register' );
    update_option( 'wssm_stripe_page_additionalusers', 'wp-stripe-additional-users' );
    update_option( 'wssm_stripe_page_xeroauth', 'wp-stripe-xero-authorization' );
    update_option( 'wssm_stripe_page_xerocallback', 'wp-stripe-xero-callback' );

}

function wssm_deactivation_fn(){
  global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS ".WSSM_CURCOUNTRY_TABLE_NAME );
    $wpdb->query( "DROP TABLE IF EXISTS ".WSSM_METADATA_TABLE_NAME );
    $wpdb->query( "DROP TABLE IF EXISTS ".WSSM_USERPLAN_TABLE_NAME );

    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-account-info'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-payment-methods'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-invoices'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-subscription'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-add-subscription'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-email-verfication'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-login-register'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-additional-users'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-xero-authorization'" );
    $wpdb->query( "delete from ".$wpdb->prefix."posts where post_name ='wp-stripe-xero-callback'" );

    delete_option("wssm_stripe_page_acounttinfo");
    delete_option("wssm_stripe_page_card");
    delete_option("wssm_stripe_page_invoice");
    delete_option("wssm_stripe_page_subscription");
    delete_option("wssm_stripe_page_addsubscription");
    delete_option("wssm_mail_urlredirect");
    delete_option("wssm_logreg_urlredirect");
    delete_option("wssm_stripe_page_xeroauth");
    delete_option("wssm_stripe_page_xerocallback");

}

require_once plugin_dir_path( __FILE__ ) . 'libraries/stripe/init.php';
require_once plugin_dir_path( __FILE__ ) . 'libraries/xerooauth2/vendor/autoload.php';
require_once plugin_dir_path( __FILE__ ) . 'libraries/xerooauth2/storage.php';
require_once plugin_dir_path( __FILE__ ) . 'libraries/xerooauth2/example.php';
require_once plugin_dir_path( __FILE__ ) . 'classes/stl_wssm_xero.php';
require_once plugin_dir_path( __FILE__ ) . 'classes/stl_wssm_stripe.php';
require_once plugin_dir_path( __FILE__ ) . 'classes/stl_wssm_common.php';
require_once plugin_dir_path( __FILE__ ) . 'classes/stl_wssm_shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'classes/stl_wssm_template.php';
require_once plugin_dir_path( __FILE__ ) . 'classes/stl_wssm_email.php';

\Stripe\Stripe::setAppInfo("WP Pay Portal", "0.1.0", "https://github.com/stimulussoft/wppayportal");



// add css and js file for admin
add_action('admin_enqueue_scripts', "stl_wssm_admin_js_css");
function stl_wssm_admin_js_css() {
  
  wp_register_style ( 'stl_wssm_main_css', plugins_url ( 'assets/css/main.css', __FILE__ ) );  
  wp_register_style ( 'stl_wssm_admin_css', plugins_url ( 'assets/css/admin.css', __FILE__ ) ); 

}

// add css and js file for admin
add_action('wp_enqueue_scripts', "stl_wssm_front_js_css");
function stl_wssm_front_js_css() {

  wp_register_script('stl_wssm_datatable_js', plugins_url ( 'assets/datatables/datatables.min.js', __FILE__ ), array( 'jquery' ));
  wp_register_script('stl_wssm_jvalidation_js', plugins_url ( 'assets/js/jquery.validate.min.js', __FILE__ ), array( 'jquery' ));
  wp_register_script('stl_wssm_swertalt_js', plugins_url ( 'assets/sweetalert/sweetalert.min.js', __FILE__ ), array( 'jquery' ));
  wp_register_script('stl_wssm_toastr_js', plugins_url ( 'assets/toastr/toastr.min.js', __FILE__ ), array( 'jquery' ));
  wp_register_script('stl_wssm_intltel_js', plugins_url ( 'assets/intltel/js/intlTelInput.js', __FILE__ ), array( 'jquery' ));
  wp_register_script('stl_wssm_accountinfo_js', plugins_url ( 'assets/js/accountinfo.js', __FILE__ ), array( 'jquery' ));
  wp_register_script('stl_wssm_custom_js', plugins_url ( 'assets/js/custom.js', __FILE__ ), array( 'jquery' ));
  wp_register_style ( 'stl_wssm_datatable_css', plugins_url ( 'assets/datatables/datatables.min.css', __FILE__ ) );  
  wp_register_style ( 'stl_wssm_fmain_css', plugins_url ( 'assets/css/main.css', __FILE__ ) );  
  wp_register_style ( 'stl_wssm_toastr_css', plugins_url ( 'assets/toastr/toastr.min.css', __FILE__ ) );  
  wp_register_style ( 'stl_wssm_swertalt_css', plugins_url ( 'assets/sweetalert/sweetalert.css', __FILE__ ) ); 
  wp_register_style ( 'stl_wssm_intltel_css', plugins_url ( 'assets/intltel/css/intlTelInput.css', __FILE__ ) );
  wp_register_style ( 'stl_wssm_frontend_css', plugins_url ( 'assets/css/frontend.css', __FILE__ ) );


  wp_enqueue_style('stl_wssm_datatable_css');  
  wp_enqueue_style('stl_wssm_fmain_css');
  wp_enqueue_style('stl_wssm_toastr_css');
  wp_enqueue_style('stl_wssm_swertalt_css');
  wp_enqueue_style('stl_wssm_intltel_css');
  wp_enqueue_style('stl_wssm_frontend_css');
  wp_enqueue_script('stl_wssm_datatable_js');
  wp_enqueue_script('stl_wssm_jvalidation_js');
  wp_enqueue_script('stl_wssm_toastr_js');
  wp_enqueue_script('stl_wssm_swertalt_js');
  wp_enqueue_script('stl_wssm_intltel_js');
  wp_enqueue_script('stl_wssm_custom_js');

}


// add menu to wp-admin
add_action( 'admin_menu', 'sp_admin_menu_page' );

function sp_admin_menu_page() {
  add_menu_page('Pay Portal', 'Pay Portal', 'manage_options', 'wssm_stripemanage', 'wssm_stripemanage','dashicons-dashboard',200);
  add_submenu_page('wssm_stripemanage', 'Settings', 'Settings', 'manage_options', 'stl_wssm_settings', 'stl_wssm_settings');
  add_submenu_page('wssm_stripemanage', 'Currencies ', 'Currencies', 'manage_options', 'stl_wssm_country_currency', 'stl_wssm_country_currency');
  add_submenu_page('wssm_stripemanage', 'Meta Data Fields ', 'Meta Data Fields', 'manage_options', 'stl_wssm_metadata', 'stl_wssm_metadata');
  add_submenu_page('wssm_stripemanage', 'Email Template', 'Email Template', 'manage_options', 'stl_wssm_emailtemp', 'stl_wssm_emailtemp');

  remove_submenu_page( 'wssm_stripemanage', 'wssm_stripemanage' ); // remove sub menu
}




//plugin settings page
if (!function_exists('stl_wssm_settings'))  
{
  function stl_wssm_settings(){
    wp_enqueue_style('stl_wssm_main_css');  //include css
    wp_enqueue_style('stl_wssm_admin_css');
      if(file_exists(WPSTRIPESM_DIR.'admin/stl_wssm_settings.php')){
        include_once(WPSTRIPESM_DIR.'admin/stl_wssm_settings.php');
      }
  }
}

if (!function_exists('stl_wssm_country_currency'))  
{
  function stl_wssm_country_currency(){
    wp_enqueue_style('stl_wssm_main_css');  //include css
    wp_enqueue_style('stl_wssm_admin_css');
      if(file_exists(WPSTRIPESM_DIR.'admin/stl_wssm_country_currency.php')){
        include_once(WPSTRIPESM_DIR.'admin/stl_wssm_country_currency.php');
      }
  }
}

if (!function_exists('stl_wssm_metadata'))  
{
  function stl_wssm_metadata(){
    wp_enqueue_style('stl_wssm_main_css');  //include css
    wp_enqueue_style('stl_wssm_admin_css');
      if(file_exists(WPSTRIPESM_DIR.'admin/stl_wssm_metadata.php')){
        include_once(WPSTRIPESM_DIR.'admin/stl_wssm_metadata.php');
      }
  }
}

if (!function_exists('stl_wssm_emailtemp'))  
{
  function stl_wssm_emailtemp(){
    wp_enqueue_style('stl_wssm_main_css');  //include css
    wp_enqueue_style('stl_wssm_admin_css');
      if(file_exists(WPSTRIPESM_DIR.'admin/stl_wssm_emailtemp.php')){
        include_once(WPSTRIPESM_DIR.'admin/stl_wssm_emailtemp.php');
      }
  }
}


add_action('init', 'stl_wssm_getuserid');

function stl_wssm_getuserid(){
  global $stl_user_email;
  global $parent_userid;

  if(is_user_logged_in())
  {
    $current_user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $usermeta_parent_id = get_user_meta( $current_user_id, 'parent_user_id', true );
    if($usermeta_parent_id)
    {
      $user_data =  get_user_by('id', $usermeta_parent_id );
      // echo "<pre>";print_r($user_data);echo "</pre>";
      $stl_user_email = $user_data->user_email;
      $parent_userid = $usermeta_parent_id;
    }
    else
    {
      $stl_user_email =  $current_user->user_email;
      $parent_userid = $current_user_id;
    }
    $stl_user_email = strtolower($stl_user_email);
  }
  else
  {
    $parent_userid = 0;
  }

  // echo "parent_userid = ".$parent_userid;
  $stl_shortcodelist=new WPStlShortcode();
}


// $stl_shortcodelist=new WPStlShortcode();
$stl_commonlist=new WPStlCommoncls();

function get_collectiontype($collection_method)
{
  $wssm_payment_type = WSSM_PAYMENT_TYPES;
  $collectiont_txt = $wssm_payment_type[$collection_method];
  return $collectiont_txt;
}



function check_attempted_login( $user, $username, $password ) {
  if ( get_transient( 'attempted_login' ) ) {
    $datas = get_transient( 'attempted_login' );
    if ( $datas['tried'] >= 4 ) {
      $until = get_option( '_transient_timeout_' . 'attempted_login' );
      $time = time_to_go( $until );
      return new WP_Error( 'too_many_tried',  sprintf( __( '<strong>ERROR</strong>: You have reached authentication limit, you will be able to try again in %1$s.' ) , $username ) );
    }
  }
  return $user;
}

// add_filter( 'authenticate', 'check_attempted_login', 30, 3 ); 
function login_failed( $username ) {
  if (!session_id())
    session_start();

  $transient_name = 'attempted_login_'.$username;
  if ( get_transient( $transient_name ) ) {
    $datas = get_transient( $transient_name );
    $datas['tried']++;

    if ($datas['tried'] <= 4 )
      set_transient( $transient_name, $datas , 900 );
  } else {
    $datas = array('tried'     => 1);
    set_transient( $transient_name, $datas , 900 );
  }
  $_SESSION['stl_transient_name'] = $transient_name;
}
add_action( 'wp_login_failed', 'login_failed', 10, 1 ); 


function time_to_go($timestamp)
{
  $periods = array(
        "second",
        "minute",
        "hour",
        "day",
        "week",
        "month",
        "year"
  );
  $lengths = array(
        "60",
        "60",
        "24",
        "7",
        "4.35",
        "12"
  );
  $current_timestamp = time();
  $difference = abs($current_timestamp - $timestamp);
  for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i ++) {
    $difference /= $lengths[$i];
  }
  $difference = round($difference);
  if (isset($difference)) {
    if ($difference != 1)
      $periods[$i] .= "s";
    $output = "$difference $periods[$i]";
    return $output;
  }
}

