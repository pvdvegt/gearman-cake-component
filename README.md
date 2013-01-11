gearman-cake-component
======================

Gearman client cake component

Put this in you cake config.php file.

/**
 * List of gearman servers, comma seperated ex : 127.0.0.1:4730,127.0.0.1:4235
 */

Configure::write('gearman.servers', '127.0.0.1:4730');

/**
 * List of valid API keys
 */

Configure::write('gearman.valid_keys', array(
  	array('access' => 'HeCweyKlAayX', 'secret' => '7539f31e9bd7c42ddf188bc969b224792d2f6276')
));
