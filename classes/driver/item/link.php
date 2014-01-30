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

class Driver_Item_Link extends Driver_Item {

	/**
	 * Builds and returns the item edition form
	 *
	 * @param string $content
	 * @return string
	 */
	public function form($content = null) {
		return parent::form(\View::forge('kiwi_menu::driver/link/form', array(
			'item'				=> $this->item,
			'content'			=> $content,
			'expander_options'	=> array(
				'allowExpand'		=> false,
				'expanded'			=> true,
			),
		), false)->render());
	}

	/**
	 * Displays the item
	 *
	 * @return string|bool
	 */
	public function display() {
		if (empty($this->item->url)) {
			return false;
		}
        // Blank target
        $attributes = array();
        if (!empty($this->item->url_blank)) {
            $attributes['target'] = '_blank';
        }
        // Build anchor with link
        return \Html::anchor($this->item->url, $this->title(), $attributes);
	}
}
