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
    <h3><?= __('Link') ?></h3>
	<div style="overflow:visible;">
		<label for="attribute_url">URL</label>
		<input type="text" name="attributes[url]" id="attribute_url" value="<?= e(!empty($item->url) ? $item->url : '') ?>" />
		<p>or</p>
        <label for="attribute_url">Page</label>
        <input type="text" name="attributes[page]" id="attribute_page" value="<?= e(!empty($item->page) ? $item->page : '') ?>" />
        <p>or</p>
        <label for="attribute_url">Other</label>
        <input type="text" name="attributes[model]" id="attribute_model" value="<?= e(!empty($item->model) ? $item->model : '') ?>" />
	</div>
</div>
<?= $content ?>
