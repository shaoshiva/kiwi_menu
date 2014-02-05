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

/**
 * The abstract menu driver
 *
 * @package Kiwi\Menu
 */
class Driver_Menu extends Driver {

    /**
     * Constructor
     *
     * @param null $menu
     * @return Driver_Menu $this
     */
    public function __construct($menu = null) {
		// Finds the menu if $menu is an ID
		if (is_numeric($menu)) {
			$menu = Model_Menu::find($menu);
		}
        parent::__construct($menu);
    }

    /**
     * Finds the menus compatible with this driver and returns them as a list of forged menu drivers
     *
     * @return array
     */
    public static function getMenus() {
        // Finds the published menus
        $models = Model_Menu::find('all', array(
            'where'	=> array(
                array('published', true),
            ),
        ));

        // Forges them using the current driver
        $menus = array();
        foreach ($models as $model) {
            $menus[] = static::forge($model);
        }

        return $menus;
    }

    /**
     * Returns a tree of menu items forged with their driver (recursive method)
     *
     * @param null|int $parent_id
     * @return array
     */
    public function getItems($parent_id = null) {
        // Get items
        $items = $this->menu->items($parent_id);
        // Forge items driver
        foreach ($items as $k => $item) {
            // Forge driver with item
            $items[$k] = Driver_Item::forge($item);
        }
        return $items;
    }

    /**
     * Gets the menu title
     *
     * @return mixed
     */
    public function getTitle() {
        return $this->menu->menu_title;
    }

    /**
     * Gets the menu id
     *
     * @return mixed
     */
    public function getId() {
        return $this->menu->menu_id;
    }

    /**
     * Returned a forged menu
     *
     * @param null $menu
     * @return Driver
     */
    public static function forge($menu = null) {
        // Try to build the appropriate driver (only if called statically on this class)
        if (!empty($menu) && is_object($menu) && !empty($menu->menu_driver) && get_called_class() == get_class()) {
            $driver = $menu->menu_driver;
            if (class_exists($driver)) {
                return new $driver($menu);
            }
        }
        return parent::forge($menu);
    }
}
