/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */

CREATE TABLE IF NOT EXISTS `kiwi_menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(255) NOT NULL,
  `menu_description` text,
  `menu_published` tinyint(4) NOT NULL DEFAULT '0',
  `menu_publication_start` datetime DEFAULT NULL,
  `menu_publication_end` datetime DEFAULT NULL,
  `menu_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `menu_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`),
  KEY `menu_created_at` (`menu_created_at`),
  KEY `menu_updated_at` (`menu_updated_at`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `kiwi_menu_item` (
	`mitem_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mitem_menu_id` int(11) NOT NULL,
  `mitem_parent_id` int(11) unsigned DEFAULT NULL,
  `mitem_sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mitem_title` varchar(255) NOT NULL,
  `mitem_css_class` varchar(512) DEFAULT NULL,
  `mitem_driver` varchar(512) DEFAULT NULL,
  `mitem_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mitem_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mitem_published` tinyint(3) NOT NULL DEFAULT '0',
  `mitem_publication_start` datetime DEFAULT NULL,
  `mitem_publication_end` datetime DEFAULT NULL,
  PRIMARY KEY (`mitem_id`),
  KEY `mitem_created_at` (`mitem_created_at`),
  KEY `mitem_updated_at` (`mitem_updated_at`),
  KEY `mitem_parent_id` (`mitem_parent_id`),
  KEY `mitem_menu_id` (`mitem_menu_id`),
  KEY `mitem_sort` (`mitem_sort`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `kiwi_menu_item_attribute` (
  `miat_id` int(111) unsigned NOT NULL AUTO_INCREMENT,
  `miat_mitem_id` int(11) unsigned NOT NULL,
  `miat_key` varchar(50) NOT NULL,
  `miat_value` varchar(512) NOT NULL,
  PRIMARY KEY (`miat_id`),
  KEY `miat_key` (`miat_key`),
  KEY `miat_mitem_id` (`miat_mitem_id`)
) DEFAULT CHARSET=utf8 ;
