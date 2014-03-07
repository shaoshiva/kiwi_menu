ALTER TABLE  `kiwi_menu`
  ADD  `menu_context` VARCHAR( 25 ) NOT NULL ,
  ADD  `menu_context_common_id` INT( 11 ) NOT NULL,
  ADD  `menu_context_is_main` TINYINT( 1 ) NOT NULL DEFAULT  '0';

ALTER TABLE  `kiwi_menu_item`
  ADD  `mitem_context` VARCHAR( 25 ) NOT NULL ,
  ADD  `mitem_context_common_id` INT( 11 ) NOT NULL,
  ADD  `mitem_context_is_main` TINYINT( 1 ) NOT NULL DEFAULT  '0';

UPDATE `kiwi_menu` SET `menu_context` = 'main::fr_FR';
UPDATE `kiwi_menu` SET `menu_context_common_id` = `menu_id`;
UPDATE `kiwi_menu` SET `menu_context_is_main` = '1';

UPDATE `kiwi_menu_item` SET `mitem_context` = 'main::fr_FR';
UPDATE `kiwi_menu_item` SET `mitem_context_common_id` = `mitem_id`;
UPDATE `kiwi_menu_item` SET `mitem_context_is_main` = '1';
