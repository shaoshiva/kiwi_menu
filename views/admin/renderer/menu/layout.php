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
<div class="renderer-kiwi-menu" id="<?= $id ?>">
    <div class="add-buttons">
		<?php
		// Add a button for each available driver
		$config = \Config::load('kiwi_menu::config', true);
		$available_drivers = \Arr::get($config, 'drivers', array());
		foreach ($available_drivers as $driver_class) {
			if (!class_exists($driver_class)) {
				continue;
			}
			$driver_config = $driver_class::config();
			$driver_name = \Arr::get($driver_config, 'name');
			// Dialog options
			$dialog_options = array(
				'width'		=> \Arr::get($driver_config, 'form.width', array()),
				'height'	=> \Arr::get($driver_config, 'form.height', array()),
			);
			?>
			<button data-item-driver="<?= $driver_class ?>"
					data-item-title="New <?= $driver_name ?>"
					data-dialog-options="<?= htmlspecialchars(\Format::forge()->to_json($dialog_options)) ?>">
				<span class="icon">
					<?= \Fuel\Core\Html::img(\Arr::get($driver_config, 'icon')) ?>
				</span>
				Add a <?= $driver_name ?>
			</button>
		<?php } ?>
    </div>
    <input type="hidden" name="tree" value="" />
	<div class="renderer">
		<?= $tree ?>
    </div>
</div>
<script type="text/javascript">
require(
	['jquery-nos', 'static/apps/kiwi_menu/js/nestedSortable/jquery.mjs.nestedSortable.js'],
	function ($) {
		$(function() {
			var $container = $('#<?= $id ?>');
			var $renderer = $container.find('.renderer > ol');
			var $add_buttons = $container.find('.add-buttons');

			/**
			 * Initialize an item
			 *
			 * @param $item
			 */
			function init_item($item) {
				// Adds the edit button
				if (!$item.find('> div a.edit').length) {
					$item.find('> div').append('<a href="#" class="edit"><span class="ui-icon ui-icon-pencil"></span></a>');
				}
				// Set the original parent id
				$item.data('parent-id', get_item_parent_id($item));
			}

			/**
			 * Set item properties
			 *
			 * @param $item
			 * @param properties
			 */
			function set_item_values($item, properties) {
				var item_id = $item.data('item-id');
				var is_new = $item.data('is-new');

				$.each(properties, function(property, value) {

					// Get the hidden field
					var input_name = 'items_updates['+item_id+']['+property+']';
					var $input = $container.find('input[name="'+input_name+'"]');

					// Don't create a hidden field if the value is the same as the original
					if ($item.data(property) == value && !is_new) {
						$input.remove();
						return ;
					}

					if ($input.length) {
						$input.val(value);
					} else {
						$container.append($('<input type="hidden">').attr('name', input_name).val(value));
					}
				});
			}

			/**
			 * Returns the parent id of the $item element
			 *
			 * @param $item
			 * @return {*}
			 */
			function get_item_parent_id($item) {
				var $parent = $item.parent('ol:not(.renderer)').parent('li');
				return $parent.length ? $parent.data('item-id') : '';
			}

			// UI fix
			var $td = $container.closest('td');
			$td.css('padding-left', $td.css('padding-right')).prev('th').remove();
			$container.closest('td').attr('colspan', 2).prev('th').remove();

			// Init nested sortable
			$renderer.nestedSortable({
				maxLevels		: <?= \Arr::get($options, 'max_levels') ?>,
				handle			: 'div',
				items			: 'li',
				toleranceElement: '> div',
				stop			: function() {
					// Updates items parent id and sort
					$renderer.find('li').each(function() {
						var $item = $(this);
						set_item_values($item, {
							mitem_parent_id	: get_item_parent_id($item),
							mitem_sort		: $item.index()
						}, true);
					});
				}
			});

			// Init items
			$renderer.find('li').each(function() {
				init_item($(this));
			});

			 // Add an item
			var temp_id_offset = 0;
			$container.find('.add-buttons button').on('click', function(e) {
				e.preventDefault();
				e.stopImmediatePropagation();
				var $this = $(this);

				var item_driver = $this.data('item-driver') || $this.attr('data-item-driver');

				// Creates the item
				var $item = $('<li><div><span class="label">'+$this.data('item-title')+'</span></div></li>')
						.data('item-driver', item_driver)
						.data('is-new', true);

				// Add icon
				$item.find('> div').prepend('<span class="icon"><img src="'+$this.find('.icon img').attr('src')+'" /></span>');

				// Generates a temporary id
				var id = 'new_'+(++temp_id_offset);
				$item.addClass('list_'+id).data('item-id', id);

				// Add to the DOM
				$renderer.append($item);

				// Set initial values
				set_item_values($item, {
					mitem_title		: $item.find('> div .label').text().trim(),
					mitem_driver	: item_driver
				});

				// Init item
				init_item($item);

				return false;
			});

			// Edit item
			$container.on('click', 'a.edit', function(e) {
				e.preventDefault();
				var $item = $(this).closest('li');
				var item_driver = $item.data('item-driver');
				var item_id = $item.data('item-id');

				// Search the driver to get the dialog options
				var dialog_options = {};
				$add_buttons.find('button').each(function() {
					var $this = $(this);
					if ($this.data('item-driver') == item_driver) {
						dialog_options = $this.data('dialog-options') || {};
					}
                });

				// Build ajax data
				var ajaxData = {
                    form_id			: $container.attr('id'),
                    mitem_driver 	: item_driver,
                    mitem_title		: $item.find('> div .label').text().trim()
                };
				// Get updated data
				$container.find('[name^="items_updates['+item_id+']"]').each(function() {
					var $this = $(this);
					var name = $this.attr('name');
                    var key = name.substring(name.lastIndexOf('[') + 1, name.length - 1);
                    var parts = key.split('.');
					if (parts.length) {
						// Convert dot notation to array (elsewhere fuel php will break it)
						var arr = dotToArray(parts, $this.val());
						$.extend(ajaxData, arr);
                    } else {
						ajaxData[key] = $this.val();
					}
				});

				$(this).nosDialog($.extend({
					contentUrl: 'admin/kiwi_menu/menu/item/ajax/edit/'+item_id,
					ajax : true,
                    ajaxData: ajaxData,
					title: <?= \Format::forge(__('Edit an item'))->to_json() ?>,
					height: 400,
					width: 700
				}, dialog_options));
            });

            function dotToArray(array, value) {
                var key = array.shift();
                var nested = {};
                nested[key] = array.length ? dotToArray(array, value) : value;
                return nested;
            }

			$container.on('update_item', function(event, data) {
				// Find item by id
				$item = $renderer.find('li[data-item-id="'+data.mitem_id+'"]');
				delete data.mitem_id;
				// Set values
                set_item_values($item, data);

				// Updates the title
				if (typeof data.mitem_title != 'undefined') {
					$item.find('> div .label').html(data.mitem_title);
				}

				return true;
			});
		});
	}
);
</script>
<style type="text/css">
.renderer-kiwi-menu {
	padding: 1em 0;
}
.renderer-kiwi-menu .add-buttons {
	margin: 0 0 1.5em 0;
}

.renderer-kiwi-menu .add-buttons button span.icon img {
    width: 12px;
    top: 1px;
    position: relative;
    left: -3px;
}

.renderer-kiwi-menu ol {
    margin: 0;
    padding: 0;
    padding-left: 30px;
}

.renderer-kiwi-menu .renderer > ol {
    margin: 0 0 0 25px;
    padding: 0;
    list-style-type: none;
}

.renderer-kiwi-menu .renderer > ol {
    margin: 0;
}

.renderer-kiwi-menu li {
    margin: 10px 0 0 0;
    padding: 0;
	width: 360px;
}

.renderer-kiwi-menu li div  {
    position: relative;
    border: 1px solid #d4d4d4;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    border-color: #D4D4D4 #D4D4D4 #BCBCBC;
    padding: 8px 40px;
	margin: 0;
    cursor: move;
    background: #f6f6f6;
    background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(47%,#f6f6f6), color-stop(100%,#ededed));
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    background: -o-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    background: -ms-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    background: linear-gradient(to bottom,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
}

.renderer-kiwi-menu li .icon {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 30px;
    border-right: 1px solid #D4D4D4;
    box-shadow: 1px 0 0px rgba(255,255,255,0.5);
	opacity: 0.8;
}

.renderer-kiwi-menu li .icon img {
	width: 16px;
	height: 16px;
    margin-top: -8px;
    margin-left: -8px;
	top: 50%;
	left: 50%;
	display: block;
    position: absolute;
}

.renderer-kiwi-menu li .edit {
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 30px;
	background: rgba(0,0,0,0.1);
    border-left: 1px solid #cecece;
    cursor: pointer;
}

.renderer-kiwi-menu li .edit:hover {
    background: rgba(0,0,0,0.2);
}

.renderer-kiwi-menu li .edit span {
	margin: 7px auto;
	display: block;
}

.renderer-kiwi-menu li .label em {
	font-style: italic;
	color: #999999;
}

.renderer-kiwi-menu li.mjs-nestedSortable-branch div {
    background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);

}

.renderer-kiwi-menu li.mjs-nestedSortable-leaf div {
    background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);

}

li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
    border-color: #999;
    background: #fafafa;
}

.renderer-kiwi-menu .disclose {
    cursor: pointer;
    width: 10px;
    display: none;
}

.renderer-kiwi-menu li.mjs-nestedSortable-collapsed > ol {
    display: none;
}

.renderer-kiwi-menu li.mjs-nestedSortable-branch > div > .disclose {
    display: inline-block;
}

.renderer-kiwi-menu li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
    content: '+ ';
}

.renderer-kiwi-menu li.mjs-nestedSortable-expanded > div > .disclose > span:before {
    content: '- ';
}
</style>
