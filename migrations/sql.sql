INSERT INTO `wp_scholarism` (`sort`, `volume`, `name`, `author`, `translator`, `nationality`, `status`) VALUES 

UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_first` = 'luxun' WHERE `ti`.`tag_code` = 'luxun' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_third` = 'scholarism' WHERE `ti`.`tag_code` = 'xueshumingzhu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'britain' WHERE `ti`.`tag_code` = 'yingguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'american' WHERE `ti`.`tag_code` = 'meiguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'germany' WHERE `ti`.`tag_code` = 'deguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'france' WHERE `ti`.`tag_code` = 'faguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'china' WHERE `ti`.`tag_code` = 'zhongguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'other' WHERE `ti`.`tag_code` = 'qitaxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = '' WHERE `ti`.`tag_code` = '' AND `ti`.`info_id` = `b`.`id`;
