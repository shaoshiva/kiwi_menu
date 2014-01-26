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

class Driver_Page extends Driver {

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
	 * @return string|bool
	 */
	public function display() {
		if (empty($this->item)) {
			return false;
		}
		return $this->item->wysiwygs->content->wysiwyg_text;
	}
}
