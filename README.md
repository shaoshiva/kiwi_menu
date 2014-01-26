# Introduction

Kiwi Menu is a menu manager for Novius OS.

# Requirements

The Kiwi Menu application runs on Novius OS Chiba 2 and upper.

# Installation

* [How to install a Novius OS application](http://community.novius-os.org/how-to-install-a-nos-app.html)

# Usage

After you installed this application in your Novius OS, you will be able to create menus with an infinite number of sub-menususing through an appdesk and a powerful drag'n drop UI based on the nestedSortable jQuery plugin.

# Documentation

## Driver

This application uses drivers to build and display the menu's items.

These drivers are natively provided :
* Driver_Text
* Driver_Link
* Driver_Wysiwyg

### Structure

A driver is composed of two files :

* A configuration file `kiwi_menu/config/driver/example.config.php` :

```php
return array(
    'name'	=> __('Example'),
    'icon'    => array(
        '16'    => 'example.png',
    ),
);
```

* A class file `kiwi_menu/config/driver/example.config.php` that extends `Driver` and implements at least these methods :

```php
class Driver_Example extends Driver {

    /**
     * Displays the item
     */
    public function display();

    /**
     * Builds and returns the item edition form
     */
    public function form();
}
```

### Available drivers

Available drivers are set in the configuration file `kiwi_menu/config/config.php` :

```php
/*
* Available drivers
*/
'drivers' => array(
		'Kiwi\Menu\Driver_Text',
		'Kiwi\Menu\Driver_Link',
		'Kiwi\Menu\Driver_Wysiwyg',
),
```

### Create a driver

You can create a new driver if the existing ones doesn't fit your needs. You just have to create the class file with the required methods (see the **Structure** section above) :

```php
class Driver_Example extends Kiwi\Menu\Driver {
  ...
}
```

... and the configuration file:

```php
return array(
    'name'	=> __('Example'),
    'icon'    => array(
        '16'    => 'example.png',
    ),
);
```

Then add your driver to the list of available drivers:

```php
\Event::register_function('config|kiwi_menu::config', function(&$config) {
    $config['drivers'][] = 'Demo\Driver_Example';
});
```

### EAV

Todo
