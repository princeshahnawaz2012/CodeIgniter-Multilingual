# CodeIgniter Multilingual

Make multilingual application using CodeIgniter.

--------------------------------------------------

## Documentation

Explanations to use this CodeIgniter skeleton.

### Define languages allowed

In the hook there are two class variable "$languages" and "$current_language". The first one is an array whose elements are the languages allowed in your application. The second one is the default language of your application (if user language is not defined in "$language", this language will be the one displayed).

### Define routes

Routes management is delegated to a language file. Like in i18n routines, urls are defined as a keyword. In this installation, the keyword, placed in an array of a language file (this array must be named $lang['route']) is an array where key is the uri and value the ruri, exactly like in route.php config file. Here's an example :

	$lang['route']['member'] = array( 'member/(:any)' => "welcome/member/$1" );

### Multilingual Helper

There is a helper file to help you to make translating sentences and urls more easily.

#### Translate method

In this helper there is a method : "_t($str, $params, $segment = '%s')" which allows you to translate sentences more easily. Here's an example :

In a language file, there will be :

	$lang['mezcalito'] = "%s is a web agency, located in %s";

In a view file, there will be :

	echo _t($this->lang->line('mezcalito'), array('Mezcalito', 'Grenoble, France'));
	
This will render : "Mezcalito is a web agency, located in Grenoble, France".
(The method replace "%s" (or a surcharged segment) by a $params line, in order shown in the array)

#### Path helper

There is an another method : "_path($str, $params = FALSE)". Thanks to it you can make urls more easily, using keywords of route_lang.php language file. Here's an example (using the route defined above) :

	echo _path('member', array('yannis'));

This will render : "member/yannis" (reference to the rule mentioned above).

--------------------------------------------------

## The operation

How does this process work ?

### Only one hook

There is only one hook class (named : "Multilingual") to manage multilingual rules.

#### Getting correct language

In the hook file "multilingual.php", there is a method : "get_language" used to find the correct language. This method check the language defined in the browser preferences.

#### Language configuration

The method : "set_language" put the language returned by the previous one in the application configuration.

#### Route configuration

The method : "set_route" take routes defined in the route_lang.php language file and put them in the route.php config file.