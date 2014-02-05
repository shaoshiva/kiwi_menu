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

class Model_Menu extends \Nos\Orm\Model
{
    protected static $_primary_key = array('menu_id');
    protected static $_table_name = 'kiwi_menu';

    protected static $_properties = array(
        'menu_id',
        'menu_title',
		'menu_published',
		'menu_publication_start',
		'menu_publication_end',
		'menu_description',
        'menu_created_at',
        'menu_updated_at',
    );

    protected static $_title_property = 'menu_title';

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property'=>'menu_created_at'
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
            'property'=>'menu_updated_at'
        )
    );

    protected static $_behaviours = array(
        'Nos\Orm_Behaviour_Publishable' => array(
            'publication_state_property' => 'menu_published',
            'publication_start_property' => 'menu_publication_start',
            'publication_endproperty' => 'menu_publication_end',
        ),
    );

    protected static $_belongs_to  = array();

    protected static $_has_many  = array(
		'items' => array(
			'key_from'       => 'menu_id',
			'model_to'       => '\Kiwi\Menu\Model_Menu_Item',
			'key_to'         => 'mitem_menu_id',
			'cascade_save'   => true,
			'cascade_delete' => true,
		),
	);

    protected static $_many_many = array();

	/**
	 * Returns items by parent item id
	 *
	 * @param null $parent_id
	 * @return array
	 */
	public function items($parent_id = null) {
		// Builds the items tree
		$items = $this->buildItemsChildren();

		// Gets the items with $parent_id as parent's item id
		$items = array_filter($items, function($item) use($parent_id) {
			return $item->mitem_parent_id == $parent_id;
		});

		return $items;
	}

	/**
	 * Builds items children recursively (without any sql query)
	 *
	 * @param null $parent_id
	 * @return array|null
	 */
	public function buildItemsChildren($parent_id = null) {
		// Gets the items with $parent_id as parent's item id
		$items = array_filter($this->items, function($item) use($parent_id) {
			return $item->mitem_parent_id == $parent_id;
		});
		// Sort items
		uasort($items, function($a, $b) {
			return strcmp($a->mitem_sort, $b->mitem_sort);
		});
		// Builds children recursively
		foreach ($items as $item) {
			if (is_null($item->children)) {
				$item->children = $this->buildItemsChildren($item->mitem_id);
			}
		}
		return $items;
	}
}
