<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Custom constants userd throughout the application
|--------------------------------------------------------------------------
|
*/


define('QR_HEADER', '#location_name - #code');
define('QR_COMMENT_LABEL', 'Enter your comment:');
define('QR_SUCCESS_TEXT', 'Your comment has been successfully submitted to #location_name. Thank you!');

define('SMS_FIRST_REPLY', 'Enter your comment (add your email if you would like to be contacted). Text HELP for help, text STOP to stop. Msg&Data Rates May Apply.');
define('SMS_LAST_REPLY', 'Thank you for your feedback. Msg&Data Rates May Apply');

define('S_BODY_BG1', '#F9F9F9');
define('S_BODY_BG2', '#F1F1F1');
define('S_HEADER_BG1', '#3C3C3C');
define('S_HEADER_BG2', '#111111');
define('S_HEADER_FCOLOR', '#FFFFFF');
define('S_HEADER_FFAMILY', 'Arial');
define('S_HEADER_FSIZE', 16);
define('S_LABELS_FCOLOR', '#333333');
define('S_LABELS_FFAMILY', 'Arial');
define('S_LABELS_FSIZE', 16);

/* End of file constants.php */
/* Location: ./application/config/constants.php */