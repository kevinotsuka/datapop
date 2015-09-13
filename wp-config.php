<?php
# Database Configuration
define( 'DB_NAME', 'wp_datapop' );
define( 'DB_USER', 'datapop' );
define( 'DB_PASSWORD', 'jpYiHH0bwDsld3UsRcQK' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'kaFS;:zoAdiRx1P;c|:]6dtS-C~120PHux){5fT~~$G-G/Z+7i}94>mURBGpQg2)');
define('SECURE_AUTH_KEY',  'J?&z1>b0B3+{oo~%-Q-Nd6N2+,,m7p<+M82V+QMWe/=k*t&[ r-wLM)4!?t&|+#i');
define('LOGGED_IN_KEY',    '6$2Jc6@&C)M%*]liC0Mf+Ja%xQ}3=wL^Ay+FxMLV;S,Ta3t+bTP?:RgomTmF##[r');
define('NONCE_KEY',        '+5xv+IZiRtWMz=uX{QZcR3nH0*!0Z%Hi3c]aKXyP8x+<Pe13JW_ laj$?j.m@,++');
define('AUTH_SALT',        '1@`e(:BGisnw&s%pwKzn-f-V_xE5l9^U)vbGHQa_8!`ysDQ}ND!5`f}/zZkfk:~d');
define('SECURE_AUTH_SALT', 'J<Jj=) *h-=V#|.*;4_]~$u15.z+|K5=[|stb2g++bJm7zltjN<Q6-,3S)1+T4Y*');
define('LOGGED_IN_SALT',   ' 7%>4IW/R4mo-U-];!_t`L]QfU9z1]#&{nb-+qG_A>-Z{mnE+7N 0uoT_ f1#EiO');
define('NONCE_SALT',       'ahea MEgC%OXLMg; lSH0pk5tPr#ZnM?uy_x{j|31I31G8d^^c%7W6H,,7>iHLSs');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'datapop' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', 'ec2976a01f78f0f95000d1cfaae65e543cb7153e' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '41277' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '45.79.9.152' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'datapop.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-41277', );

$wpe_special_ips=array ( 0 => '45.79.9.152', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );

define( 'WP_SITEURL', 'http://datapop.wpengine.com' );

define( 'WP_HOME', 'http://datapop.wpengine.com' );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
