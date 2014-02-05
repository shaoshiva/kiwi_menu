# Introduction

Kiwi Menu is a menu manager for Novius OS. It supports nested menus with different kind of items (text, link, page, wysiwyg...). You can easily develop your own kind of item if the default ones do not fit your needs (see the Driver section in the documentation).

To display a menu you have two possibilities :
- use a template that is compatible with Kiwi Menu (eg. Kiwi Template)
- integrate yourself (programming knowledge required) using the Driver_Menu (see the Documentation)

# Requirements

The Kiwi Menu application runs on Novius OS Chiba 2 and upper.

# Installation

* [How to install a Novius OS application](http://community.novius-os.org/how-to-install-a-nos-app.html)

# Usage

After you installed this application in your Novius OS, you will be able to create menus using the appdesk and then display them on your website using the enhancer.

# Documentation

## Drivers

### Item

This application uses drivers to build and display the a menu item.

These drivers are natively provided :
* Driver_Item_Text
* Driver_Item_Link
* Driver_Item_Page
* Driver_Item_Wysiwyg

#### Structure

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
class Driver_Item_Example extends Driver_Item {

    /**
     * Displays the item
     */
    public function display();

    /**
     * Builds the item's edition form
     */
    public function form();
}
```

#### Available drivers

Available drivers are set in the configuration file `kiwi_menu/config/config.php` :

```php
/*
* Available drivers
*/
'drivers' => array(
	'Kiwi\Menu\Driver_Item_Text',
	'Kiwi\Menu\Driver_Item_Link',
	'Kiwi\Menu\Driver_Item_Page',
	'Kiwi\Menu\Driver_Item_Wysiwyg',
),
```

**Note**: Drivers listed above are the default ones provided by this application.

#### Create a driver

You can create a new driver if the existing ones doesn't fit your needs. You just have to create the class file with the required methods (see the **Structure** section above) :

```php
class Driver_Item_Example extends Kiwi\Menu\Driver {
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
    $config['drivers'][] = 'Demo\Driver_Item_Example';
});
```

#### EAV

Todo

### Menu

This application uses drivers to display a menu.
