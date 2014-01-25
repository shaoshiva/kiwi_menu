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
    <h3><?= __('Wysiwyg') ?></h3>
	<div style="overflow:visible;">
		<?= \Nos\Renderer_Wysiwyg::renderer($renderer) ?>
	</div>
</div>
<?= $content ?>
