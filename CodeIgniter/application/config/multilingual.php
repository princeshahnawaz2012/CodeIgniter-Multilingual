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
| there is an available translation (language folder) if you intend to use
| something other than english.
|
*/
$config['multilingual']['allowed_languages'] = array(
														array('english', 'en', 'en.ci-multilingue.labs.mezcalito.viki/'),
														array('french', 'fr', 'ci-multilingue.labs.mezcalito.viki/fr')
													);

/*
|--------------------------------------------------------------------------
| Language Protocols
|--------------------------------------------------------------------------
|
| This item determines which technic should be used to retrieve the
| current language of the user. You can use one or more. Just put them
| in the order that you want to be effective.
|
| 'BROWSER'		Uses the BROWSER preferences (Accept-Language)
| 'URI'			Uses the URI domain
|
*/
$config['multilingual']['protocols'] = array('URI', 'BROWSER');

/* End of file multilingual.php */
/* Location: ./application/config/multilingual.php */