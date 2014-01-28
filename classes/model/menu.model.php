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

	protected $tree	= array();

	/**
	 * Display the menu
	 */
	public function display() {
		return \View::forge('kiwi_menu::front/template/horizontal', array(
			'menu'	=> $this,
			'items'	=> $this->tree()
		), false);
	}

	/**
	 * Returns menu items as a tree
	 *
	 * @param null $parent_id
	 * @return array
	 */
	public function tree($parent_id = null) {
		if (empty($this->tree)) {
			$this->tree = static::build_tree($parent_id);
		}
		return $this->tree;
	}

	/**
	 * Builds and returns an items tree recursively
	 *
	 * @param null $parent_id
	 * @return array
	 */
	protected function build_tree($parent_id = null) {
		$items = array_filter($this->items, function($item) use($parent_id) {
			return $item->mitem_parent_id == $parent_id;
		});
		foreach ($items as $item) {
			$item->children = static::build_tree($item->mitem_id);
		}
		return $items;
	}
}
