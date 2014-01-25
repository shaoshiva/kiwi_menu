<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */
?>
<ol>
	<? foreach ($items as $item) { ?>
		<li id="list_<?= $item->mitem_id ?>" data-item-id="<?= $item->mitem_id ?>" data-item-driver="<?= $item->mitem_driver ?>">
			<div>
				<span class="label">
					<?= $item->mitem_title ? $item->mitem_title : '<em>'.__('No title').'</em>' ?>
				</span>
			</div>
			<?php
			if (count($item->children)) {
				echo \View::forge('kiwi_menu::admin/renderer/menu/layout-tree', array(
					'items'	=> $item->children
				), false);
			}
			?>
		</li>
	<?php } ?>
</ol>
