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
 * CodeIgniter Change language Hooks
 *
 * @package		CodeIgniter
 * @subpackage	Hooks
 * @category	Hooks
 * @author		Yannis Sgarra
 * @link		https://github.com/lianis/CI-Multilingual
 */

// ------------------------------------------------------------------------

/**
 * Multilingual
 *
 * Select the correct language
 * for the user.
 *
 * @access	public
 * @param	string
 * @return	string
 */
 class Multilingual
 {

	function get_language()
	{
		$languages = array(
			'fr' => 'french',
			'en' => 'english'
		);
	
		$current_language = $languages['en'];
		
		$browser_language = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
		
		if(isset($languages[$browser_language]) !== FALSE)
		{
			$current_language = $languages[$browser_language];
		}
		
		return $current_language;
	}
	
	function set_language()
	{
		$current_language = $this->get_language();
		
		$this->config =& load_class('Config');
		
		$this->config->set_item('language', $current_language);
	}
}