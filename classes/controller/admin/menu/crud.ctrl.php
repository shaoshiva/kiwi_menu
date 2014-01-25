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

class Controller_Admin_Menu_Crud extends \Nos\Controller_Admin_Crud
{
	/**
	 * Save menu
	 *
	 * @param $menu
	 * @param $data
	 * @return array
	 */
	public function save($menu, $data) {
		// Save menu
		$response = parent::save($menu, $data);
		if (empty($menu->menu_id)) {
			return $response;
		}

		// Save items
		$response_items = $this->save_items(\Input::post('items_updates'), $menu);

		return \Arr::merge($response, $response_items);
	}

	/**
	 * Save menu items
	 *
	 * @param $items
	 * @param $menu
	 * @return array
	 * @throws \Exception
	 */
	public function save_items($items, $menu) {
		$return = array();

		if (empty($items)) {
			return $return;
		}

		foreach ($items as $id => $properties) {

			try {
				// New item or existing one ?
				$is_new = (empty($id) || !is_numeric($id));

				// Get or create the item
				$item = $is_new ? Model_Menu_Item::forge() : Model_Menu_Item::find($id);
				if (empty($item)) {
					// Item not found
					throw new \Exception(__('Sorry, can\'t find this item. Perhaps it has already been deleted?'));
				}

				// Populate the item with the submitted data
				$item->populate(\Arr::merge($properties, array('mitem_menu_id' => $menu->menu_id)));

				// Save item
				$item->save();

				// Dispatch event
				$return['dispatchEvent'][] = array(
					"name" 		=> "Kiwi\\Menu\\Model_Menu_Item",
					"action" 	=> ($is_new ? 'insert' : 'update'),
					"id" 		=> $item->mitem_id,
				);
			}

			// Errors on item
			catch (\Exception $e) {
				$return['errors'][] = $e->getMessage();
			}
		}

		return $return;
	}
}
