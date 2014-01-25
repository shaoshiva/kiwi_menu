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

class Model_Menu_Item_Attribute extends \Orm\Model {

	protected static $_table_name = 'kiwi_menu_item_attribute';
	protected static $_primary_key = array('miat_id');

	protected static $_title_property = 'miat_key';

	protected static $_properties 	= array(
		'miat_id',				// primary key
		'miat_mitem_id',		// foreign key
		'miat_key',				// attribute column
		'miat_value',			// value column
	);
}
