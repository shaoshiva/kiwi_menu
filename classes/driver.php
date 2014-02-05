<?php

namespace Kiwi\Menu;

/**
 * Abstract class for a menu driver
 *
 * @package Kiwi\Menu
 */
abstract class Driver {

    // The menu
    protected $menu				= null;

    // Configuration
    protected $config			= null;

    // Cached list of installed menu drivers
    protected static $drivers   = null;

    /**
     * Constructor
     *
     * @param null $menu
     * @return Driver $this
     */
    public function __construct($menu = null) {
        // Set the menu
        $this->menu = $menu;
        // Load the driver configuration
        $this->config = $this->loadConfig();
    }

    /**
     * Returned a forged driver
     *
     * @param null $menu
     * @return Driver
     */
    public static function forge($menu = null) {
        return new static($menu);
    }

    /**
     * Loads and returns the config
     *
     * @return array
     */
    public function loadConfig() {
        if (is_null($this->config)) {
            $this->config = static::getConfig();
        }
        return $this->config;
    }

    /**
     * Get the driver configuration
     *
     * @return array
     */
    public static function getConfig() {
        // Get current driver configuration
        list($application_name, $config_file) = \Config::configFile(get_called_class());
        $config = \Config::loadConfiguration($application_name, $config_file);
        // Merge with the common configuration
        if (get_called_class() != get_class()) {
            list($application_name, $config_file) = \Config::configFile(get_class());
            $config = \Arr::merge(\Config::loadConfiguration($application_name, $config_file), $config);
        }
        return $config;
    }

    /**
     * Returns a list of installed menu drivers
     *
     * @return array
     */
    public static function getDrivers() {
        if (is_null(self::$drivers)) {
            // Set in cache
            self::$drivers = Helper::getInstalledDrivers();
        }
        return self::$drivers;
    }

    /**
     * Find the menus compatible with this driver and returns them as a list of forged menu drivers
     *
     * @return mixed
     */
    public static function getMenus() {
		return array();
	}

    /**
     * Returns a tree of menu items forged with their driver (recursive method)
     *
     * @param null|int $parent_id
     * @return array
     */
    abstract public function getItems($parent_id = null);

    /**
     * Gets the menu title
     *
     * @return string
     */
    abstract public function getTitle();

    /**
     * Gets the menu id
     *
     * @return mixed
     */
    abstract public function getId();
}
