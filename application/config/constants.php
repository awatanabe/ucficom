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
| Security Zones
|--------------------------------------------------------------------------
|
| These define the different security levels. Authentication is done using
| bitwise operations. Each zone is assigned a number that is a power of two and
| each user receives a security number that is a bitwise combination of the 
| zones they are authorized to access. Bitwise AND is then used to check whether
| a user is authorized to access a particular controller.
| 
| An inactive user should have her status set to "INACTIVE"
|
*/

define('INACTIVE',      0);
define('EXTERNAL',      1);
define('AUTHENTICATED', 2);
define('ADMIN',         4);
define("MANAGE",        8);

$INTERNAL_SECURITY_ZONES = array(
        "admin" => ADMIN,
        "manage" => MANAGE);

define("INTERNAL_SECURITY_ZONES", serialize($INTERNAL_SECURITY_ZONES));

// Define security levels in array
define("SECURITY_ZONES", serialize(array_merge(
        array(
            "inactive" => INACTIVE,
            "external" => EXTERNAL,
            "authenticated" => AUTHENTICATED),
        $INTERNAL_SECURITY_ZONES)));

/*
|--------------------------------------------------------------------------
| Database Titles
|--------------------------------------------------------------------------
|
| These are constants for database usage
|
*/

// Constants for Users table
define("USERS_TABLE",           "users");
define("USERS_USER_ID",         "user_id");
define("USERS_EMAIL",           "email");
define("USERS_PASSWORD",        "password");
define("USERS_FIRST_NAME",      "first_name");
define("USERS_LAST_NAME",       "last_name");
define("USERS_SECURITY_LEVEL", "security_level");

/*
|--------------------------------------------------------------------------
| Message Types
|--------------------------------------------------------------------------
|
| Different types of messages
|
*/

// The element in the sessions array where a user's security level is stored
define("MESSAGE_NORMAL",    "message_normal");
define("MESSAGE_SUCCESS",   "message_success");
define("MESSAGE_ALERT",     "message_alert");

/*
|--------------------------------------------------------------------------
| Sessions Data
|--------------------------------------------------------------------------
|
| These constants define the names of different pieces of data in sessions
|
*/

// The element in the sessions array where a user's security level is stored
define("SECURITY_LEVEL", "security_level");
define("MESSAGE", "message");

/*
|--------------------------------------------------------------------------
| Form Constants
|--------------------------------------------------------------------------
|
| Constants for use with forms
|
*/

// Value for password_helper password salting

define('SUBMIT_NAME', "submit");

/*
|--------------------------------------------------------------------------
| Custom Constants
|--------------------------------------------------------------------------
|
| These are constants defined for use with custom libraries
|
*/

// Value for password_helper password salting

define('SALT_VALUE', 8);

/* End of file constants.php */
/* Location: ./application/config/constants.php */