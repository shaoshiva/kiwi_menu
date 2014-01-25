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

class Driver_Wysiwyg extends Driver {

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

	/**
	 * Builds and returns the item edition form
	 *
	 * @param string $content
	 * @return string
	 */
	public function form($content = null) {
		return parent::form(\View::forge('kiwi_menu::driver/wysiwyg/form', array(
			'item'				=> $this->item,
			'content'			=> $content,
			'expander_options'	=> array(
				'allowExpand'		=> true,
				'expanded'			=> true,
			),
			'renderer'			=> array(
				'style' 			=> 'width: 100%; height: 180px;',
				'name'				=> 'wysiwygs.content',
				'value'				=> $this->item->wysiwygs->content,
				'renderer_options' 	=> \Nos\Tools_Wysiwyg::jsOptions(array(
					'mode' 				=> 'exact',
				), $this->item, false),
			),
		), false)->render());
	}
}
