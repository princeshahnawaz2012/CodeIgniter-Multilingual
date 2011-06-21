# CodeIgniter Multilingual

Make multilingual application using CodeIgniter (v2.0.2).

--------------------------------------------------

## Documentation

Explanations to use this CodeIgniter skeleton.

### Configuration

You just have to modify application/config/multilingual.php file. Don't touch the other files (hooks) !

#### Define languages allowed

In this file you have to define languages allowed in you application in the $config['multilingual']['allowed_languages'] variable.
To add a language, add a line in the array variable like this following one :

	array('language_name', 'language_tag', 'language_url')
	
Where "language_name" is the name (in lower cases) of language defined (it must be named like the folder language corresponding), and "language_tag" the tag (two letter word) of the language, it used by your browser to define language preferences (in your browser, it may be en_US ; just indicate en), and language_url the url where the language will be used (eg : en.example.com or www.example.com/en or www.example.com/index.php/en)
	
#### Define protocol used

In the $config['multilingual']['protocols'] variable, you define the protocol used to find the correct language. There are two ones : 'BROWSER' and 'URI'. With 'URI', you use the defined urls (in config file) to find the language, whereas with 'BROWSER', you use browser preferences to find it. They are cumulative (for example, if you have en.example.com, fr.example.com and www.example.com and if you choose to cumulate the two rules, en.example.com will be in english, fr.example.com will be in french and for www.example.com, it will depend on user browser preferences).

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

In the hook file "multilingual.php", there is a method : "_get_language" used to find the correct language, using urls of the application or browser preferences.

#### Language configuration

The method : "set_language" put the language returned by the previous one in the application configuration.

#### Route configuration

The method : "set_route" take routes defined in the route_lang.php language file and put them in the route.php config file.