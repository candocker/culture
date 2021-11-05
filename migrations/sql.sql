SELECT * FROM `wp_scholarism` AS `s`, `wp_figure` AS `f` WHERE `s`.`author` = `f`.`name` GROUP BY `s`.`author` ;
SELECT * FROM `wp_calligrapher` AS `c`, `wp_figure` AS `f` WHERE `c`.`author` = `f`.`name` GROUP BY `c`.`name` ;


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

CREATE TABLE `wp_book_figure` (
      `id` int(10) NOT NULL COMMENT 'ID',
      `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型',
      `book_code` varchar(200) NOT NULL DEFAULT '' COMMENT '书籍代码',
      `figure_code` varchar(200) NOT NULL DEFAULT '' COMMENT '人物代码',
      `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
      `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
      `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
      `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
      `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='书籍/人物';
ALTER TABLE `wp_book_figure`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `wp_book_figure`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';
