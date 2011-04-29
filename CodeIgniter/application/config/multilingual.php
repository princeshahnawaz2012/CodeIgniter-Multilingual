<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Multilingual
| -------------------------------------------------------------------------
| This file lets you define general configuration of the multilingual
| hook for CodeIgniter. Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$config['multilingual'] = array();

/*
|--------------------------------------------------------------------------
| Allowed Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['multilingual']['allowed_languages'] = array('english', 'french');

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which default language should be used if the user
| one is not in the allowed ones.
|
*/
$config['multilingual']['default_language'] = 'english';

/*
|--------------------------------------------------------------------------
| Language Protocol
|--------------------------------------------------------------------------
|
| This item determines which technic should be used to retrieve the
| current language of the user.
|
| 'BROWSER'		Uses the BROWSER preferences (Accept-Language)
|
*/
$config['multilingual']['language_protocol'] = 'BROWSER';

/* End of file multilingual.php */
/* Location: ./application/config/multilingual.php */