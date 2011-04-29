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
 * CodeIgniter Multilingual Hooks
 *
 * @package		CodeIgniter
 * @subpackage	Hooks
 * @category	Hooks
 * @author		Yannis Sgarra
 * @link		https://github.com/lianis/CodeIgniter-Multilingual
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
 	/**
 	* @Array $languages
 	*/
 	private $languages = array();
 	
 	/**
 	* @String $current_language
 	*/
 	private $current_language = "";
 	
 	/**
 	* @String $protocol
 	*/
 	private $protocol = 'BROWSER';
 	
 	/**
 	* @Array $domains
 	*/
 	private $domains = array();
 		
 	// ------------------------------------------------------------------------
 	
 	/**
	 * Constructor
	 *
	 * The constructor can be passed an array of config values
	 */
	public function __construct()
	{
		// Load the multilingual.php file.
		require APPPATH.'config/multilingual.php';
		
		// Parse our class variables with the multilingual configuration items.
		$this->languages = $config['multilingual']['allowed_languages'];
		$this->current_language = $config['multilingual']['default_language'];
		$this->protocol = $config['multilingual']['protocol'];
		$this->domains = $config['multilingual']['domains'];
		
		// Find the correct language.
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
		if($this->protocol === 'BROWSER')
		{
			// Find the language tag of the browser Accept-Language variable.
			$browser_language = substr(strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]), 0, 2);
			
			foreach($this->languages as $language)
			{
				// Make a language tag of a language defined in the multilingual configuration.
				$key_language = substr(strtolower($language), 0, 2);
				
				// If the language tags correspond each other, defined the new current language.
				if($key_language === $browser_language)
				{
					$this->current_language = $language;
					break;
				}
			}
		}
		elseif($this->protocol === 'URI')
		{
			foreach($this->domains as $k => $v)
			{
				// If domain defined and current url correspond each other, defined the new current language.
				if(preg_match('#(http://)?'.$_SERVER['SERVER_NAME'].'/?#', $v))
				{
					$this->current_language = $k;
				}
			}
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
		// Defined global variable for the routes.
		global $_ROUTE;
		
		// Load route language file.
		require APPPATH.'language/'.$this->current_language.'/route_lang.php';
		
		// Parse the $route variable, like in the route.php config file, with routes of language file.
		$route = array();
		foreach($lang['route'] as $key => $array)
		{
			foreach($array as $uri => $ruri)
			{
				$route[$uri] = $ruri;
			}
		}
		
		// Place the $route variable in the global variable defined before.
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
		
		// Change the language of the configuration by the current language found with the hook.
		$this->config->set_item('language', $this->current_language);
	}
}