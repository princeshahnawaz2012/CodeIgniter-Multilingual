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
 	* @Array $current_language
 	*/
 	private $current_language = array();
 	
 	/**
 	* @Array $protocols
 	*/
 	private $protocols = array('URI');
 	
 	/**
 	* @Array $domains
 	*/
 	private $domains = array();
 	
 	/**
 	* @String $used_protocol
 	*/
 	private $used_protocol = '';
 		
 	// ------------------------------------------------------------------------
 	
 	/**
	 * Constructor
	 *
	 * The constructor can be passed an array of config values
	 */
	public function __construct()
	{
		// Load the multilingual.php config file.
		require APPPATH.'config/multilingual.php';
		
		// Parse our class variables with the multilingual configuration items.
		$this->languages = $config['multilingual']['allowed_languages'];
		$this->current_language = $this->languages[0];
		$this->protocols = $config['multilingual']['protocols'];
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
	 * @return	string
	 */
	private function _get_language()
	{
		foreach($this->protocols as $protocol)
		{
			if($protocol === 'BROWSER')
			{
				// Find the language tag of the browser Accept-Language variable
				$browser_language = substr(strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]), 0, 2);

				foreach($this->languages as $language)
				{
					// If the language tags correspond each other, defined the new current language
					if($language[1] === $browser_language)
					{
						$this->current_language = $language;
						return $protocol;
					}
				}
			}
			elseif($protocol === 'URI')
			{
				// Get the current uri
				$current_uri = 'http://'.trim($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], '/').'/';
				
				foreach($this->languages as $language)
				{
					// Check if one of uris defined in the config file matches with the current_uri, to find the current language
					if( preg_match('#http://'.trim(str_replace('http://', '', $language[2]), '/').'/#', $current_uri) )
					{
						$this->current_language = $language;
						return $protocol;
					}
				}
			}
		}
		
		return 'no_protocol';
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Find Pre Uri
	 *
	 * If there is pre_uri informations to define language
	 * (like "en" in http://www.example.com/en), find it.
	 *
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	private function _find_pre_uri()
	{
		$result = array();
		
		foreach($this->languages as $language)
		{
			// If there is a pre uri, get it.
			$ext = explode('/', str_replace('http://', '', trim($language[2], '/')), 2);
			$result[$language[0]] = ( isset($ext[1]) ) ? trim( preg_replace('#((.+)\.php)?(.+)#', '$3', $ext[1]), '/' ) : '';
		}
		
		return $result;
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
		// Defined global variable for the routes
		global $_ROUTE, $_PRE_ROUTE, $_CURRENT_LANGUAGE;
		
		// Find the correct current language
		$this->used_protocol = $this->_get_language();
		$_CURRENT_LANGUAGE = $this->current_language[0];
		
		// Get pre uri informations
		$_PRE_ROUTE = $this->_find_pre_uri();
		
		// Load route language file.
		require APPPATH.'language/'.$this->current_language[0].'/route_lang.php';
		
		// Parse the $route variable, like in the route.php config file, with routes of language file
		$route = array();
		foreach($lang['route'] as $key => $array)
		{
			foreach($array as $uri => $ruri)
			{
				// Build route array
				$route[trim($_PRE_ROUTE[$this->current_language[0]].'/'.$uri, '/')] = $ruri;
			}
		}
		
		// Place the $route variable in the global variable defined before
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
		// Defined global variable for the routes
		global $_CURRENT_LANGUAGE;
		
		// Get config instance
		$this->config =& load_class('Config');
		
		// Change the language of the configuration by the current language found with the hook
		$this->config->set_item('language', $_CURRENT_LANGUAGE);
	}
}