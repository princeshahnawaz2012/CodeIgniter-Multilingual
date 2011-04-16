# CodeIgniter Multilingual

Make multilingual application using CodeIgniter.

--------------------------------------------------

## Documentation

Explanations to use this CodeIgniter skeleton.

### Define routes

Routes management is delegated to a language file. Like in i18n routines, urls are defined as a keyword. In this installation, the keyword is an array where key is the uri and value the ruri, exactly like in route.php config file. Here's an example :

	$lang['route']['member'] = array( 'member/(:any)' => "welcome/member/$1" );

### Multilingual Helper

There is a helper file to help you to make translating sentences and urls more easily.

--------------------------------------------------

## The operation

How does this process work ?

### Only one hook

There is only one hook (multilingual.php) to manage multilingual rules.

#### Getting correct language

In the hook file "multilingual.php", there is a method : "get_language" used to find the correct language. This method check the language defined in the browser preferences.

#### Language configuration

The method : "set_language" put the language returned by the previous one in the application configuration.

#### Route configuration

The method : "set_route" take routes defined in the route_lang.php language file and put them in the route.php config file.