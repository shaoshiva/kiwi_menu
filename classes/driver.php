<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */

namespace Kiwi\Menu;

class Driver {

	// The menu item
	protected $item				= null;

	// Configuration
	protected $config			= null;

	/**
	 * Constructor
	 *
	 * @param null $item
	 * @return Driver $this
	 */
	public function __construct($item = null) {
		// Set the item
		$this->item = $item;

		// Loads the driver configuration
		$this->config = $this->loadConfig();

		return $this;
	}

	/**u
	 * Displays the item
	 *
	 * @return string|bool
	 */
	public function display() {
		return $this->item->title();
	}

	/**
	 * Builds the item's edit form
	 *
	 * @param string $content
	 * @return string
	 */
	public function form($content = null) {
		return \View::forge('kiwi_menu::driver/form', array(
			'item'				=> $this->item,
			'content'			=> $content,
			'expander_options'	=> array(
				'allowExpand'		=> true,
				'expanded'			=> true,
			),
		), false)->render();
	}

	/**
	 * Return the item's allowed EAV attributes
	 *
	 * @return array
	 */
	public function attributes() {
		return \Arr::get($this->config, 'attributes', array());
	}

	/**
	 * Item title
	 *
	 * @return string|bool
	 */
	public function title() {
		return !empty($this->item) ? $this->item->mitem_title : false;
	}

	/**
	 * Iem CSS class
	 *
	 * @return string|bool
	 */
	public function cssClass() {
		return !empty($this->item) ? $this->item->mitem_css_class : false;
	}

	/**
	 * Item icon url
	 *
	 * @param bool $absolute Return an absolute URL (default false)
	 * @return null
	 */
	public function icon($absolute = false) {
		return null;
	}

	/**
	 * Loads and returns the config
	 *
	 * @return array
	 */
	public function loadConfig() {
		if (is_null($this->config)) {
			$this->config = static::config();
		}
		return $this->config;
	}

	/**
	 * Get the driver configuration
	 *
	 * @return array
	 */
	public static function config() {
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
	 * Returned a forged item
	 *
	 * @param null $item
	 * @return Driver
	 */
	public static function forge($item = null) {
		if (empty($item)) {
			return false;
		}
		// Try to build the appropriate driver
		// Only if called statically on this class, eg. Driver::forge()
		if (!empty($item->mitem_driver) && get_called_class() == get_class()) {
			$driver = $item->mitem_driver;
			if (class_exists($driver)) {
				return new $driver($item);
			}
		}
		return new static($item);
	}
}
