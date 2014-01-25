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
<div class="expander fieldset" data-wijexpander-options="<?= htmlspecialchars(\Format::forge()->to_json($expander_options)); ?>">
    <h3><?= __('Text') ?></h3>
	<div style="overflow:visible;">
		<label for="mitem_attr_text">Text</label>
		<textarea name="attributes[text]" id="mitem_attr_text" rows="5" style="width: 100%"></textarea>
	</div>
</div>
<?= $content ?>
