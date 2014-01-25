<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */

Nos\I18n::current_dictionary(array('noviusos_page::common', 'nos::application', 'nos::common'));

return array(
    'controller' => 'menu/item/crud',
    'data_mapping' => array(
        'mitem_title' => array(
            'title' => __('Title'),
			'sortDirection' => 'ascending',
        ),
		'context' => true,
		'url' => array(
			'method' => 'url',
		),
		'previewUrl' => array(
			'value' => function($menu_item) {
				return $menu_item->url(array('preview'  => true));
			},
		),
    ),
	'actions' => array(
		'list' => array(
			'delete' => array(
				'primary' => false,
			),
			'add' => array(
				'label' => __('Add a menu item'),
			),
			'visualise' => array(
				'label' => __('Visualise'),
				'primary' => true,
				'iconClasses' => 'nos-icon16 nos-icon16-eye',
				'action' => array(
					'action' => 'window.open',
					'url' => '{{previewUrl}}',
				),
				'disabled' => false,
				'targets' => array(
					'grid' => true,
					'toolbar-edit' => true,
				),
				'visible' => array(
					function($params) {
						return !isset($params['item']) || !$params['item']->is_new();
					})
			),
			'add_submenuitem' => array(
				'label' => __('Add a menu item to this menu item'),
				'icon' => 'plus',
				'action' => array(
					'action' => 'nosTabs',
					'tab' => array(
						'url' => '{{controller_base_url}}insert_update?environment_id={{_id}}&context={{_context}}',
						'label' => __('Add a menu item'),
						'iconUrl' => 'static/apps/noviusos_page/img/16/page.png',
					),
				),
				'targets' => array(
					'grid' => true,
				),
			),
			'duplicate' => array(
				'action' => array(
					'action' => 'nosAjax',
					'params' => array(
						'url' => '{{controller_base_url}}duplicate/{{_id}}',
					),
				),
				'label' => __('Duplicate'),
				'primary' => false,
				'icon' => 'circle-plus',
				'targets' => array(
					'grid' => true,
				),
			),
			'renew_cache' => array(
				'label' => __('Renew menu items cache'),
				'action' => array(
					'action' => 'nosAjax',
					'params' => array(
						'url' => 'admin/kiwi_menu/appdesk/clear_cache',
					),
				),
				'targets' => array(
					'toolbar-grid' => true,
				),
			),
		),
		'order' => array(
			'add',
			'edit',
			'visualise',
			'share',
			'delete',
		)
	),
);