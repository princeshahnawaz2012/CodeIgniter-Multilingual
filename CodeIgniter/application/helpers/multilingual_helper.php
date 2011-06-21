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
function _path($str, $params = FALSE)
{
	$res = $str;
	
	global $_PRE_ROUTE;
	
	$CI =& get_instance();
	$CI->lang->load('route');
	
	$route = $CI->lang->line('route');
	
	if(isset($route[$str]))
	{
		foreach($route[$str] as $uri => $ruri)
		{
			$res = trim( $_PRE_ROUTE.'/'.$uri, '/' );
		}
		
		$res = str_replace('(', '', str_replace(')', '', $res));
		$res = str_replace(':any', '%s', str_replace(':num', '%s', $res));
	}
	
	if($params !== FALSE)
	{
		$res = vsprintf($res, $params);
	}
	
	return $res;
}