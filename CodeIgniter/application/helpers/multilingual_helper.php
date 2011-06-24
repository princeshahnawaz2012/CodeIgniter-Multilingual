<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Multilingual Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Yannis Sgarra
 * @link		https://github.com/lianis/CI-Multilingual
 */

// ------------------------------------------------------------------------

/**
 * Traduction
 *
 * Add parameters in a string,
 * replace defined segment characters.
 *
 * @access	public
 * @param	string
 * @return	string
 */
function _t($str, $params, $segment = '%s')
{
	$str = str_replace($segment, '%s', $str);
	
	return vsprintf($str, $params);
}

// ------------------------------------------------------------------------

/**
 * Path URL
 *
 * Take URL keyword defined in route_lang.php language file,
 * replace segments replace by params line.
 *
 * @access	public
 * @param	string
 * @return	string
 */
function _path($str, $params = FALSE, $idiom = FALSE)
{
	global $_PRE_ROUTE;
	
	// Put string param in the result variable to return it if there is no rule to apply
	$res = $str;
	
	$CI =& get_instance();
	$CI->lang->load('route');
	
	$route = $CI->lang->line('route');
	$pre_uri = $_PRE_ROUTE[$CI->config->item('language')];
	
	// If $idiom (language name) is defined, it means that we want an another language that the default one
	if($idiom !== FALSE)
	{
		if($idiom !== $CI->config->item('language'))
		{
			if( file_exists(APPPATH.'language/'.$idiom.'/route_lang.php') )
			{
				require_once APPPATH.'language/'.$idiom.'/route_lang.php';
				if( isset($lang['route'])) { $CI->config->set_item('language_route_'.$idiom, $lang['route']); }
				
				$route = $CI->config->item('language_route_'.$idiom);
				$pre_uri = $_PRE_ROUTE[$idiom];
			}
		}
	}
	
	// If a route line corresponds, use it.
	if(isset($route[$str]))
	{
		// Find the correct line in the file
		foreach($route[$str] as $uri => $ruri)
		{
			$res = trim( $pre_uri.'/'.$uri, '/' );
		}
		
	}
	
	// If there are params we put it in the sting url
	if($params !== FALSE)
	{
		// Prepare it to be able to use vsprintf
		$res = str_replace('(', '', str_replace(')', '', $res));
		$res = str_replace(':any', '%s', str_replace(':num', '%s', $res));
		
		// Replacement
		$res = vsprintf($res, $params);
	}
	
	return $res;
}