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
		
		// Find the correct language.
		$this->used_protocol = $this->_get_language();
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
				// Find the language tag of the browser Accept-Language variable.
				$browser_language = substr(strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]), 0, 2);

				foreach($this->languages as $language)
				{
					// If the language tags correspond each other, defined the new current language.
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
				$current_uri = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				
				foreach($this->languages as $language)
				{
					// Check if one of uris defined in the config file matches with the current_uri, to find the current language
					if( preg_match('#'.trim(str_replace('http://', '', $language[2]), '/').'#', $current_uri) )
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
		global $_PRE_ROUTE;
		
		//If used protocol is URI and if language selection is made by a uri segment, put this segment in route configuration
		$uri_pre = '';
		if( $this->used_protocol === 'URI' )
		{
			$ext = str_replace('http://', '', $this->current_language[2]);
			$ext = explode('/', $ext, 2);
			if( isset($ext[1]) )
			{
				// Prepare prefix of URI for selected language using uri defined in config file
				$uri_pre = trim( preg_replace('#((.+)\.php)?(.+)#', '$3', $ext[1]), '/' );
				$_PRE_ROUTE = $uri_pre;
				$uri_pre = $uri_pre . '/';
			}
		}
		
		// Load route language file.
		require APPPATH.'language/'.$this->current_language[0].'/route_lang.php';
		
		// Parse the $route variable, like in the route.php config file, with routes of language file.
		$route = array();
		foreach($lang['route'] as $key => $array)
		{
			foreach($array as $uri => $ruri)
			{
				$route[trim($uri_pre.$uri, '/')] = $ruri;
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
		$this->config->set_item('language', $this->current_language[0]);
	}
}