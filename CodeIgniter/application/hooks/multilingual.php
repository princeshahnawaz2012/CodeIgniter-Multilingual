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
 * Hook for multilingual application
 * with CodeIgniter.
 *
 */
 class Multilingual
 {
 	var $languages = array(
							'fr' => 'french',
							'en' => 'english'
						  );
							 	
 	var $current_language = 'en';
 	
 	/**
	 * Constructor - Sets Email Preferences
	 *
	 * The constructor can be passed an array of config values
	 */
	public function __construct()
	{
		$this->get_language();
	}
 	
	// ------------------------------------------------------------------------
	
	/**
	 * Get Language
	 *
	 * Get current language,
	 * using browser preferences.
	 *
	 * @access	private
	 * @param	none
	 * @return	void
	 */
	private function get_language()
	{
		$this->current_language = $this->languages[$this->current_language];
		
		$browser_language = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
		
		if(isset($this->languages[$browser_language]) !== FALSE)
		{
			$this->current_language = $this->languages[$browser_language];
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Route URL
	 *
	 * Get routes URL in route_lang.php language file,
	 * place them in the route.php config file.
	 *
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function set_route()
	{
		global $_ROUTE;
		
		require_once APPPATH.'language/'.$this->current_language.'/route_lang.php';
		
		$route = array();
		foreach($lang['route'] as $key => $array)
		{
			foreach($array as $uri => $ruri)
			{
				$route[$uri] = $ruri;
			}
		}
		
		$_ROUTE = $route;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Language conf
	 *
	 * Put the correct language
	 * in the config.php config file.
	 *
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function set_language()
	{
		$this->config =& load_class('Config');
		
		$this->config->set_item('language', $this->current_language);
	}
}