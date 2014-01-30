<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @page http://lekiwi.fr
 */

namespace Kiwi\Menu;

class Driver_Item_Page extends Driver_Item {

	/**
	 * Builds and returns the item edition form
	 *
	 * @param string $content
	 * @return string
	 */
	public function form($content = null) {
		return parent::form(\View::forge('kiwi_menu::driver/page/form', array(
			'item'				=> $this->item,
			'content'			=> $content,
			'expander_options'	=> array(
				'allowExpand'		=> false,
				'expanded'			=> true,
			),
			'renderer'	=> array(
				'input_name' => 'attributes.page_id',
				'id'		=> 'attribute_page_id',
				'selected' => array(
					'id' => !empty($this->item->page_id) ? $this->item->page_id : null,
				),
				'treeOptions' => array(
//					'context' => 'main::en_GB',
				),
				'height' => '220px',
			),
		), false)->render());
	}

	/**
	 * Displays the item
	 *
	 * @return bool|string
	 * @throws \Exception
	 */
	public function display() {
		if (empty($this->item) || empty($this->item->page_id)) {
			return false;
		}
		// Get the page
		$page = $this->getPage();
		if (empty($page)) {
			return false;
		}
		return $page->htmlAnchor();
	}

	/**
	 * Are this menu item and the associated page published ?
	 *
	 * @return bool
	 */
	public function published() {
		$page = $this->getPage();
		if (empty($page) || !$page->published()) {
			return false;
		}
		return parent::published();
	}

	/**
	 * Get the page
	 *
	 * @return bool|\Orm\Model|\Orm\Model[]
	 * @throws \Exception
	 */
	protected function getPage() {
        if (empty($this->item->page_id)) {
            return false;
        }
		return \Nos\Page\Model_Page::find($this->item->page_id);
	}
}
