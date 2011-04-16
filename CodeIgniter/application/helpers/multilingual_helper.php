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
 * CodeIgniter Traduction Helpers
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
 * replace key characters.
 *
 * @access	public
 * @param	string
 * @return	string
 */
function _t($str, $params, $segment = '%s')
{
	foreach($params as $param)
	{
		$str = preg_replace('#'.$segment.'#', $param, $str, 1);
	}

	return $str;
}