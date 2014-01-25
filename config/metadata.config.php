<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */

return array(
    'name'    => 'Kiwi Menu',
    'version' => '',
    'provider' => array(
        'name' => 'Pascal VINEY',
    ),
    'namespace' => "Kiwi\Menu",
    'permission' => array(
    ),
    'icons' => array( //@todo: to be defined
        64 => '/static/apps/kiwi_menu/img/64/icon.png',
        32 => '/static/apps/kiwi_menu/img/32/icon.png',
        16 => '/static/apps/kiwi_menu/img/16/icon.png',
    ),
    'launchers' => array(
        'Kiwi\Menu::menu' => array(
            'name'    => 'Menu', // displayed name of the launcher
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/kiwi_menu/menu/appdesk', // url to load
                ),
            ),
        ),
    ),
    // Enhancer configuration sample
    'enhancers' => array(
        /*
        'kiwi_menu_menu' => array( // key must be defined
            'title' => 'kiwi_menu Menu',
            'desc'  => '',
            'urlEnhancer' => 'kiwi_menu/front/menu/main', // URL of the enhancer
            //'previewUrl' => 'admin/kiwi_menu/application/preview', // URL of preview
            //'dialog' => array(
            //    'contentUrl' => 'admin/kiwi_menu/application/popup',
            //    'width' => 450,
            //    'height' => 400,
            //    'ajax' => true,
            //),
        ),
        */
    ),
);
