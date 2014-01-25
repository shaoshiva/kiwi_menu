<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */

Nos\I18n::current_dictionary(array('kiwi_menu::common'));

return array(
    'models' => array(
        array(
            'model' => 'Kiwi\Menu\Model_Menu_Item',
            'order_by' => 'mitem_sort',
            'childs' => array('Kiwi\Menu\Model_Menu_Item'),
            'dataset' => array(
                'id' => 'mitem_id',
                'title' => 'mitem_title',
            ),
        ),
    ),
    'roots' => array(
        array(
            'model' => 'Kiwi\Menu\Model_Menu_Item',
            'where' => array(array('mitem_parent_id', 'IS', \DB::expr('NULL'))),
            'order_by' => 'mitem_sort',
        ),
    ),
    'root_node' => array(
        'title' => __('Root'),
    ),
);
