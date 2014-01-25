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

class Model_Menu_Item extends \Nos\Orm\Model
{
	protected static $_table_name = 'kiwi_menu_item';
    protected static $_primary_key = array('mitem_id');

	protected static $_title_property = 'mitem_title';
    protected static $_properties = array(
		'mitem_id' => array(
			'default' => null,
			'data_type' => 'int',
			'null' => false,
		),
		'mitem_menu_id' => array(
			'default' => null,
			'data_type' => 'int',
			'null' => false,
		),
		'mitem_parent_id' => array(
			'default' => null,
			'data_type' => 'int',
			'null' => true,
			'convert_empty_to_null' => true,
		),
		'mitem_sort' => array(
			'default' => 0,
			'data_type' => 'int',
			'null' => false,
		),
        'mitem_title' => array(
			'default' => '',
			'data_type' => 'varchar',
			'null' => false,
		),
		'mitem_css_class' => array(
			'default' => '',
			'data_type' => 'varchar',
			'null' => false,
		),
		'mitem_driver' => array(
			'default' => null,
			'data_type' => 'varchar',
			'null' => true,
			'convert_empty_to_null' => true,
		),
		'mitem_created_at' => array(
			'data_type' => 'timestamp',
			'null' => false,
		),
		'mitem_updated_at' => array(
			'data_type' => 'timestamp',
			'null' => false,
		),
		'mitem_published' => array(
			'default' => 0,
			'data_type' => 'tinyint',
			'null' => false,
		),
		'mitem_publication_start' => array(
			'default' => null,
			'data_type' => 'datetime',
			'null' => true,
			'convert_empty_to_null' => true,
		),
		'mitem_publication_end' => array(
			'default' => null,
			'data_type' => 'datetime',
			'null' => true,
		),
	);

	// define the EAV container like so
	protected static $_eav = array(
		'attributes' => array(		// we use the statistics relation to store the EAV data
			'attribute' => 'key',	// the key column in the related table contains the attribute
			'value' 	=> 'value',		// the value column in the related table contains the value
		)
	);

    protected static $_belongs_to  = array(
		'parent' => array(
			'key_from'       => 'mitem_parent_id',
			'model_to'       => '\Kiwi\Menu\Model_Menu_Item',
			'key_to'         => 'mitem_id',
			'cascade_save'   => false,
			'cascade_delete' => false,
		),
    );

    protected static $_has_many  = array(
		'attributes' => array(
			'model_to'	=> '\Kiwi\Menu\Model_Menu_Item_Attribute',
			'key_from' => 'mitem_id',		// key in this model
			'key_to' => 'miat_mitem_id',	// key in the related model
			'cascade_save' => true,	// update the related table on save
			'cascade_delete' => true,	// delete the related data when deleting the parent
		)
    );

    protected static $_many_many = array();

	protected static $_observers = array(
		'Orm\\Observer_Self',
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
			'property'=>'mitem_created_at'
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
			'property'=>'mitem_updated_at'
		)
	);

	protected static $_behaviours = array(
		'Nos\Orm_Behaviour_Publishable' => array(
			'publication_state_property' => 'mitem_published',
			'publication_start_property' => 'mitem_publication_start',
			'publication_end_property' => 'mitem_publication_end',
		),
	);

	protected $driver	= null;

	/**
	 * Returns the driver
	 *
	 * @param bool $cache
	 * @return bool|Driver
	 */
	public function driver($cache = true) {
		if (is_null($this->driver) || !$cache) {
			$this->driver = Driver::forge($this);
		}
		return $this->driver;
	}

	/**
	 * Return the EAV attributes
	 */
	public function attributes() {
		return $this->driver()->attributes();
	}

	/**
	 * Safely populate the item with $data or GET/POST
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function populate($data = null) {
		// Populate with POST/GET if $data is empty
		$data = (!empty($data) ? (array) $data : \Input::param());
		foreach ($data as $property => $value) {
			// Eav attributes
			if ($property == 'attributes') {
				foreach ($value as $key => $val) {
					if (in_array($key, $this->attributes())) {
						$this->$key = $val;
//						$this->attributes[] = Model_Menu_Item_Attribute::forge(array(
//							'miat_mitem_id' => $this->mitem_id,
//							'miat_key' => $this->mitem_id,
//							'miat_value' => $this->mitem_id,
//						));
					}
				}
			}

			// Property
			elseif (array_key_exists($property, $this->properties())) {
				$this->$property = $value;
			}

			// Related (wysiwyg or media)
			elseif (strpos($property, '.')) {
				$parts = explode('.', $property);
				if (count($parts) == 2) {
					list($key, $name) = $parts;
					if (in_array($key, array('wysiwygs', 'medias'))) {
						$this->$key->$name = $value;
					}
				}
			}
		}
		return $this;
	}


	/**
	 * Find with order_by default sort
	 *
	 * @param null $id
	 * @param array $options
	 * @return \Orm\Model|\Orm\Model[]
	 */
	public static function find($id = null, array $options = array())
	{
		if (array_key_exists('order_by', $options)) {
			isset($options['order_by']['mitem_sort']) or $options['order_by']['mitem_sort'] = 'ASC';
		}
		return parent::find($id, $options);
	}
}
