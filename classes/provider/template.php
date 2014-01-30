<?php

namespace Kiwi\Menu;

class Provider_Template {

    /**
     * Return a list of menus
     *
     * @return array An array with the menu IDs as keys and the titles as values
     */
    public static function menus() {
        // Get the published menus
        $menus = \Kiwi\Menu\Model_Menu::find('all', array(
            'where'	=> array(
                array('published', true),
            ),
        ));
        return \Arr::pluck($menus, 'menu_title', 'menu_id');
    }

    /**
     * A callback that return a list of templates
     *
     * @return array|bool
     */
    public static function templates() {
        return array(
            'horizontal',
        );
    }

    /**
     * Display the $menu_id with the $template_id using optional custom $options
     *
     * @param $menu_id
     * @param $template_id
     * @param $options
     * @return bool|\Fuel\Core\View
     */
    public static function display($menu_id, $template_id, $options) {
        // Get the menu by ID
        $menu = \Kiwi\Menu\Model_Menu::find($menu_id);
        if (empty($menu)) {
            return false;
        }
        return \View::forge('kiwi_menu::front/template/'.$template_id.'/layout', array(
            'menu'	=> $menu,
            'items'	=> $menu->tree()
        ), false);
    }
}
