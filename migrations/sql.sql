UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_first` = 'luxun' WHERE `ti`.`tag_code` = 'luxun' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_third` = 'scholarism' WHERE `ti`.`tag_code` = 'xueshumingzhu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'britain' WHERE `ti`.`tag_code` = 'yingguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'american' WHERE `ti`.`tag_code` = 'meiguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'germany' WHERE `ti`.`tag_code` = 'deguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'france' WHERE `ti`.`tag_code` = 'faguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'china' WHERE `ti`.`tag_code` = 'zhongguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'other' WHERE `ti`.`tag_code` = 'qitaxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = '' WHERE `ti`.`tag_code` = '' AND `ti`.`info_id` = `b`.`id`;


CREATE TABLE `wp_shelf` (
      `id` int(11) NOT NULL COMMENT 'ID',
      `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户ID',
      `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
      `created_at` datetime NOT NULL COMMENT '创建时间',
      `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
      `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品收藏表';
ALTER TABLE `wp_shelf`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_shelf` (`name`,`user_id`);

ALTER TABLE `wp_shelf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

