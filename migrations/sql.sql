UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_first` = 'luxun' WHERE `ti`.`tag_code` = 'luxun' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_third` = 'scholarism' WHERE `ti`.`tag_code` = 'xueshumingzhu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'britain' WHERE `ti`.`tag_code` = 'yingguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'american' WHERE `ti`.`tag_code` = 'meiguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'germany' WHERE `ti`.`tag_code` = 'deguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'france' WHERE `ti`.`tag_code` = 'faguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'china' WHERE `ti`.`tag_code` = 'zhongguoxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = 'other' WHERE `ti`.`tag_code` = 'qitaxueshu' AND `ti`.`info_id` = `b`.`id`;
UPDATE `wp_tag_info` AS `ti`, `wp_book` AS `b` SET `b`.`category_second` = '' WHERE `ti`.`tag_code` = '' AND `ti`.`info_id` = `b`.`id`;




CREATE TABLE `wp_record` (
      `id` int(10) NOT NULL COMMENT 'ID',
      `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户ID',
      `book_code` varchar(300) NOT NULL DEFAULT '' COMMENT '书籍代码',
      `chapter_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '章节ID',
      `type` varchar(30) NOT NULL DEFAULT '' COMMENT '记录类型',
      `start_at` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '开始时间',
      `finish_at` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '结束时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品收藏表';
ALTER TABLE `wp_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`book_code`,`chapter_id`),
  ADD KEY `chapter_id` (`chapter_id`);
ALTER TABLE `wp_record`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';

