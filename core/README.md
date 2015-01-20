## XDaRk Core

This project is now on Floobits too! [Watch us code](https://floobits.com/jaswsinc/ws-core/redirect) in real-time :-) <a href="https://floobits.com/jaswsinc/ws-core/redirect"><img alt="Floobits status" width="100" height="40" src="https://floobits.com/jaswsinc/ws-core.png" align="right" /></a>

#### The XDaRk Core framework (for WordPress®)

The XDaRk Core can be bundled into plugins created for WordPress®. It is most often distributed as a single GZIP compressed [PHP Archive](http://www.php.net/manual/en/intro.phar.php) file; found inside `/xd.php.phar`. This file not only contains the entire XDaRk Core; but it is also a [webPhar-compatible archive](http://php.net/manual/en/phar.webphar.php) capable of serving both static and dynamic content through popular web servers like Apache®, Litespeed™, Windows® IIS; and other Apache-compatible web servers.


#### Incorporating the XDaRk Core into a plugin for WordPress®

----

###### Option #1. Using a GZIP compressed PHP Archive (recommended for small plugins).

Redistribute your plugin with this single file (`/xd.php.phar`); which can be obtained from the repo here at GitHub™. To make use of the XDaRk Core, add these lines of PHP code to files that depend on the XDaRk Core.

```php
<?php
// The XDaRk Core.
require_once 'xd.php.phar';
```
*It is important to note that while the `xd.php.phar` file is rather large; including the file in a PHP script does NOT actually include the entire PHP Archive; because the `xd.php.phar` file halts the PHP compiler after the initial PHP Archive stub is loaded into your scripts. In other words, it is perfectly safe (and efficient) to include `xd.php.phar` in your plugin files.*

*XDaRk Core class methods/properties that you access in your PHP scripts will be autoloaded by the XDaRk Core (only as needed; and this occurs automatically at runtime) — keeping your application highly effecient at all times. The XDaRk Core uses PHP's SPL Autoload functionality to accomplish this dynamically for you.*

---

###### Option #2. Bundling the entire XDaRk Core (full directory — for better performance/compatibility).

Download the full directory structure from the repo here at GitHub™ (use ZIP download option). You will need to bundle the entire `core/` directory into your plugin; including it right along with all of the other files that make up your plugin. To make use of the XDaRk Core, add these lines of PHP code to files that depend on the XDaRk Core.

```php
<?php
// The XDaRk Core.
require_once 'core/stub.php';
```
*While the `core/` directory is rather large; including the `stub.php` in a PHP script does NOT actually include the entire class structure of the XDaRk Core. XDaRk Core class methods/properties that you access in your PHP scripts will be autoloaded by the XDaRk Core (only as needed; and this occurs automatically at runtime) — keeping your application highly effecient at all times. The XDaRk Core uses PHP's SPL Autoload functionality to accomplish this dynamically for you.*

----

#### Calling XDaRk Core Class Methods Directly

```php
<?php
// The XDaRk Core.
require_once 'core/stub.php';

// Example usage...
echo xd()->©var->dump(
		xd()->©classes->get_details()
	);

// Or create a shorter reference variable if you like.
// BUT, please do NOT override $GLOBALS['xd'].

// This is OK :-)
global $xd;
echo $xd->©var->dump(
		$xd->©classes->get_details()
	);

// This is OK :-)
$core = xd();
echo $core->©var->dump(
		$core->©classes->get_details()
	);

// This is BAD!
$GLOBALS['xd'] = xd();
// Do NOT override the `$xd` global reference.
```

----

#### Creating a New WP Plugin Based on the XDaRk Core

Create this test plugin directory and file: `/wp-content/plugins/rocketship/plugin.php`

```php
<?php
namespace rocketship; // You MUST choose a unique PHP namespace.

/*
For WordPress®
Plugin Name: RocketShip™
See also: http://codex.wordpress.org/File_Header
*/

// Include the plugin you're about to create.
require_once dirname(__FILE__).'/classes/rocketship/framework.php';
```

Now create this directory and file: `/wp-content/plugins/rocketship/classes/rocketship/framework.php`

```php
<?php
namespace rocketship;

// Include your bundled copy of the XDaRk Core.
// Assuming: `/wp-content/plugins/rocketship/xd.php.phar`.
require_once dirname(dirname(dirname(__FILE__))).'/xd.php.phar';

class framework extends \xd__framework
{
	// This will serve as the base class for your plugin.
	// If you wanted to use a specific version of the XDaRk Core, you would do this.
	# class framework extends \xd_v141226_dev\framework
}

$GLOBALS[__NAMESPACE__] = new framework(
	array(
	     'plugin_root_ns' => __NAMESPACE__, // The root namespace (e.g. `rocketship`).
	     'plugin_var_ns'  => 'rs', // A shorter namespace alias (or the same as `plugin_root_ns` if you like).
	     'plugin_cap'     => 'administrator', // The WordPress capability (or role) required to manage plugin options.
	     'plugin_name'    => 'RocketShip™', // The name of your plugin (feel free to dress this up please).
	     'plugin_version' => '130310', // The current version of your plugin (must be in `YYMMDD` format).
	     'plugin_site'    => 'http://www.example.com/rocketship-plugin', // URL to site about your plugin.

	     'plugin_dir'     => dirname(dirname(dirname(__FILE__))) // Your plugin directory.

	     /* ↑ This directory MUST contain a WordPress® plugin file named: `plugin.php`.
	      * If you have this plugin directory: `/wp-content/plugins/rocketship/`
	      * This file MUST exist: `/wp-content/plugins/rocketship/plugin.php` */

	     /* ↑ This directory MUST contain a classes directory named: `classes`.
	      * If you have this plugin directory: `/wp-content/plugins/rocketship/`
	      * This directory MUST exist: `/wp-content/plugins/rocketship/classes` */
	)
);
```

###### A quick test now (after installing your plugin into WordPress®).

```php
<?php
// Example usage...
echo rocketship()->©var->dump(
		rocketship()->©classes->get_details()
	);

// Or create a shorter reference variable if you like.
// BUT, please do NOT override $GLOBALS['rocketship'].

// This is OK :-)
global $rocketship;
echo $rocketship->©var->dump(
		$rocketship->©classes->get_details()
	);

// This is OK :-)
$rs = rocketship();
echo $rs->©var->dump(
		$rs->©classes->get_details()
	);

// This is BAD!
$GLOBALS['rocketship'] = rocketship();
// Please do NOT override the `$rocketship` global reference variable.
```

###### Creating new class files that extend your framework (optional).

Create this directory and file:
`/wp-content/plugins/rocketship/classes/rocketship/blaster.php`

```php
<?php
namespace rocketship;

class blaster extends framework // You can choose to extend your framework; or not.
{
	public function says()
		{
			$output = 'Hello :-)'."\n";
			$output .= $this->©var->dump($this); // Only works if you extended your framework.
			return $output;
		}
}
```

###### A quick test now.

```php
<?php
echo rocketship()->©blaster->says();
```

----

#### Why Base My Plugin on the XDaRk Core?

The XDaRk Core makes plugin development SUPER easy. Everything from installation, options, menu pages, UI enhancements; to database interactity and exception handling; along with MANY utilities that can make development much easier for you. We'll get into additional examples soon :-) Once the Codex is ready-to-go, it will make things a little simpler for everyone. That being said, extending the XDaRk Core classes in creative ways, is what makes this powerful. The source code is already very well documented. If you're feeling adventurous you can start learning ahead of time if you like.

----

#### Digging Deeper into the XDaRk Core can be FUN :-)

Let's say you're navigating the XDaRk Core source code and you find it has a cool class file `/core/classes/xd-v141226-dev/strings.php`; with several methods you'd like to use. If you've built your plugin on the XDaRk Core; all of those methods are alreay available in your plugin. To call upon the `strings` class in your plugin, you simply use the `©` symbol (representing a dynamic class). It's a copyright symbol, but the XDaRk Core associates this symbol with dynamic class instances (singletons). It can also instantiate new class instances; but we'll get into that later.

###### Calling a method in the `strings` class.
```php
<?php
echo rocketship()->©strings->unique_id();
```

Almost all of the XDaRk Core classes are aliased too (with both singular and plural forms); so you can make your code a little easier to understand; depending on the way you're using a particular class; or on the way you're using a particular method in that class. I can use `©strings` by calling the class absolutely; or I can call it's alias `©string` to make things a little easier to read.

###### Example of this usage (singular and plural forms).

```php
<?php
$a = '0'; $b = array('hello'); $c = 'there';

if(rocketship()->©strings->are_not_empty($a, $b, $c)) // false
	echo $a.' '.$b.' '.$c;

else if(rocketship()->©string->is_not_empty($a)) // false
	echo $a; // This is empty.

else // First `string` that is NOT empty.
	echo rocketship()->©strings->not_empty_coalesce($a, $b, $c); # there
```

----

#### What if I don't like the the `©` symbol? Is there another way?

The answer is both yes and no. It depends on how you plan to work with the XDaRk Core. If you want to work with things from an INSIDE-out approach, we recommend sticking to the default XDaRk Core syntax; because that is most efficient when working with class objects (i.e. from within class object members). The `©` symbol might seem odd at first, but it becomes second-nature in minutes. Also, most editors will offer some form of auto-completion to make it easier for you to repeat when you're writing code. In addition, when you're working from the INSIDE (i.e. from class members), you really won't use the dynamic class `©` symbol that often.

On the other hand, if you plan to use the XDaRk Core mostly from the OUTSIDE, as we're doing here (e.g. you're NOT planning to write and/or extend many classes of your own); you will probably be more comfortable working with some alternatives we make available. In some cases you might find it helpful to use one syntax variation over another; depending on the scenario.

#### Other Ways to Access Dynamic Class Instances

The XDaRk Core will automatically setup an API class for your plugin. You might find the API class is easier to work with. This class is created dynamically when you instantiate your framework object instance (i.e. `new framework()` as seen above). The name of this special API class will always match that of your root Namespace in PHP (`rocketship` in this example). However, instead of it being declared within your Namespace; it's declared globally (for easy access from any PHP script - just like a PHP function would be).

###### Here is a quick example (using static methods in your API class).

```php
<?php
$a = NULL;
if(rocketship::string()->is_not_empty($a))
	echo $a;
else throw rocketship::exception('code', $a, '$a is empty!');
```

###### Here is another example (using an instance of your API class; instead of static calls).

```php
<?php
$rs = new rocketship(); // A new instance of your auto-generated API class.

$a = NULL;
if($rs->string->is_not_empty($a))
	echo $a;
else throw $rs->exception('code', $a, '$a is empty!');
```

If you like this approach better, please feel free to use it. Even if you're not going to use it, you might find value in this approach (from a site owner's perspective); because it might be helpful if you need to offer code samples; providing ways for a site owner to interact with your plugin quite easily. This is PERFECT for that kind of thing, since it's a more static & simpler/cleaner syntax.

----

The XDaRk Core will also create a shorter alias for this API class, using your `plugin_var_ns` value (part of your initial instance configuration). In this example it was `rs`. That's pretty short, hopefully it's not too short. Be careful when you configure `plugin_var_ns`. You don't want to create a conflict if introduced into an application where there are many plugins living together.

###### Here is a quick example (using static methods in your API class alias).

```php
<?php
$a = NULL;
if(rs::string()->is_not_empty($a))
	echo $a;
else throw rs::exception('code', $a, '$a is empty!');
```

###### Here is another example (using an instance of your API class alias; instead of static calls).

```php
<?php
$rs = new rs(); // A new instance of your auto-generated API class.

$a = NULL;
if($rs->string->is_not_empty($a))
	echo $a;
else throw $rs->exception('code', $a, '$a is empty!');
```

----

#### What if I don't like the way a particular method works? What if I want to add a new method of my own? Does the XDaRk Core make it easy for me to get creative with things?

Absolutely. You can either create an entirely new class (as shown in the previous `blaster` example); or you can extend an existing XDaRk Core class. Here is how you would extend the `strings` class (one of MANY that come with the XDaRk Core).

Create this file in your plugin directory: `/wp-content/plugins/rocketship/classes/rocketship/strings.php`

```php
<?php
namespace rocketship;

class strings extends \xd__strings
{
    public function write_lines() // My new class member.
        {
            foreach(func_get_args() as $line)
               echo $line.'<br />';
        }
    public function write_ps() // Another new member.
        {
            foreach(func_get_args() as $paragraph)
               echo '<p>'.$paragraph.'</p>';
        }
    public function is_not_empty(&$var) // Overwrites existing class member.
        {
            return (!empty($var) && is_string($var));
        }
    public function markdown($string) // Another new member (w/ `$this` examples).
        {
            $this->check_arg_types('string:!empty', func_get_args());

            $string = $this->trim($string);

            return $this->©markdown->parse($string);
        }
}
```

###### Now you have some new class members.

```php
<?php
$line1 = 'I love to write code.';
$line2 = 'Call me an UBER nerd :-)';
rocketship::strings()->write_lines($line1, $line2);
```

```php
<?php
$line1 = 'I love to write code.';
$line2 = 'Call me an UBER nerd :-)';
rocketship::strings()->write_ps($line1, $line2);
```

```php
<?php
echo rocketship::string()->markdown(
	'I love to write `code` @ [GitHub](http://github.com)'
);
```

----

#### What If I Build MANY plugins — ALL powered by the XDaRk Core?

How does that work exactly? It's pretty simple really. You bundle the XDaRk Core with each plugin that you want to distribute. At runtime, the first plugin to introduce an instance of the XDaRk Core — wins! All of the other plugins that depend on the XDaRk Core will share that single instance. This occurs transparently of course.

And, it works out BEAUTIFULLY! It reduces the amount of code that is required to run each plugin. If all plugins were based on the XDaRk Core, you could potentially have hundreds of plugins running simultaneouly on a website; and most of these would include only small bits of code that add onto WordPress® (and the XDaRk Core) in different ways. All of them sharing a single instance of the XDaRk Core as their plugin framework of choice :-)

#### What If I Build MANY plugins — some powered by different versions of the XDaRk Core?

If you want to be more specific about which version of the XDaRk Core that your plugin uses, you should extend a specific version and not just extend the `xd__framework`; which is a more generalized reference.

```php
<?php
class framework extends \xd_v141226_dev\framework // Specific version!
{
}
```

Here is a full example to help provide some additional clarity on this.

```php
<?php
namespace rocketship;

// Include your bundled copy of the XDaRk Core.
// Assuming: `/wp-content/plugins/rocketship/xd.php.phar`.
require_once dirname(dirname(dirname(__FILE__))).'/xd.php.phar';

class framework extends \xd_v141226_dev\framework // Specific version!
{
	// This will serve as the base class for your plugin.
}

$GLOBALS[__NAMESPACE__] = new framework(
	array(
	     'plugin_root_ns' => __NAMESPACE__, // The root namespace (e.g. `rocketship`).
	     'plugin_var_ns'  => 'rs', // A shorter namespace alias (or the same as `plugin_root_ns` if you like).
	     'plugin_cap'     => 'administrator', // The WordPress capability (or role) required to manage plugin options.
	     'plugin_name'    => 'RocketShip™', // The name of your plugin (feel free to dress this up please).
	     'plugin_version' => '130310', // The current version of your plugin (must be in `YYMMDD` format).
	     'plugin_site'    => 'http://www.example.com/rocketship-plugin', // URL to site about your plugin.

	     'plugin_dir'     => dirname(dirname(dirname(__FILE__))) // Your plugin directory.

	     /* ↑ This directory MUST contain a WordPress® plugin file named: `plugin.php`.
	      * If you have this plugin directory: `/wp-content/plugins/rocketship/`
	      * This file MUST exist: `/wp-content/plugins/rocketship/plugin.php` */

	     /* ↑ This directory MUST contain a classes directory named: `classes`.
	      * If you have this plugin directory: `/wp-content/plugins/rocketship/`
	      * This directory MUST exist: `/wp-content/plugins/rocketship/classes` */
	)
);
```

In this case, there could be multiple instances of the XDaRk Core running on a single site. Specifying a particular version will force that version to load up; if it has not already been loaded up by another plugin running on the same site. If there are other plugins running with a newer version of the XDaRk Core; those will run fine. Your plugin (because it references a specific version of the XDaRk Core); will force the older version to load up as well — specifically for your plugin to use.

----

#### Where Is The Formal Documentation for the XDaRk Core?

We appreciate your interest in the XDaRk Core. However, it's STILL in development at this point. While the product HAS reached the beta phase and IS already being used to construct some amazing new plugins for WordPress; we do NOT have the final documentation ready just yet. Please stay tuned for further details. We will update this page and construct a Codex for the XDaRk Core very soon. Until then, you are free to browse the source code on your own. Most of the formal documentation that is forthcoming; will be taken directly from the extremely well-documented source code that already exists :-)


#### UPDATE ... the Codex is now available online, but remains in a beta state.

See <http://websharks.github.io/core/codex/index.html>