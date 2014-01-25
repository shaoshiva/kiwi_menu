<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */

return array(
    'controller' => 'menu/crud',
    'data_mapping' => array(
        'menu_title' => array(
            'title' => __('Title'),
        ),
        'menu_description' => array(
            'title' => __('Description'),
            'value' => function($item) {
                return \Str::truncate($item->menu_description, 30);
            },
        ),
    ),
);