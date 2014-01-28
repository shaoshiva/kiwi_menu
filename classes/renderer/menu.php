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

class Renderer_Menu extends \Nos\Renderer
{
    public function before_construct(&$attributes, &$rules)
    {
        $attributes['class'] = rtrim('kiwi-menu '.\Arr::get($attributes, 'class'));
        if (empty($attributes['id'])) {
            $attributes['id'] = uniqid('menu_');
        }
    }

    public function build()
    {
		$menu = $this->fieldset()->getInstance();
        return $this->template(static::renderer(array(
            'input_name' => $this->name,
			'menu'	=> $menu,
        )));
    }

	/**
	 * Returns a menu builder renderer
	 *
	 * @param array $options
	 * @return string
	 */
    public static function renderer($options = array())
    {
		// Builds renderer options
        $options = \Arr::merge(array(
            'urlJson' 		=> 'admin/kiwi_menu/inspector/menu/Item/json',
            'input_name' 	=> null,
            'items' 		=> array(),
			'max_levels' 	=> 10,
            'contextChange' => true,
        ), $options);

		// Get the menu
		$menu = \Arr::get($options, 'menu');

		// Builds the tree
		$tree = \View::forge('kiwi_menu::admin/renderer/menu/layout-tree', array(
			'items'			=> $menu ? $menu->tree() : array(),
			'options'		=> $options,
		), false);

		// Builds and return the renderer
        return \View::forge('kiwi_menu::admin/renderer/menu/layout', array(
			'id' 			=> uniqid('renderer-menu-'),
			'options'		=> $options,
			'menu'			=> $menu,
			'tree'			=> $tree,
		), false);
    }
}
