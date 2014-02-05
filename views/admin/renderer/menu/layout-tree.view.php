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
				<span class="icon">
					<?= \Fuel\Core\Html::img(\Arr::get($item->driver()->getConfig(), 'icon').'?temp') ?>
				</span>
				<span class="label">
					<?= !empty($item->mitem_title) ? $item->mitem_title : '<em>'.__('No title').'</em>' ?>
				</span>
				<span class="buttons"></span>
			</div>
			<?php
			$children = $item->children();
			if (count($children)) {
				echo \View::forge('kiwi_menu::admin/renderer/menu/layout-tree', array(
					'items'	=> $children,
				), false);
			}
			?>
		</li>
	<?php } ?>
</ol>
