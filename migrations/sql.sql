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

CREATE TABLE `wp_emperor_source` (
      `id` int(10) NOT NULL COMMENT 'ID',
      `code` varchar(500) NOT NULL DEFAULT '' COMMENT '代码',
      `name` varchar(500) NOT NULL DEFAULT '' COMMENT '名称',
      `name_card` varchar(200) NOT NULL DEFAULT '' COMMENT '身份证名字',
      `nationality` varchar(60) NOT NULL DEFAULT '' COMMENT '国籍',
      `dynasty` varchar(60) NOT NULL DEFAULT '' COMMENT '朝代',
      `period` varchar(60) NOT NULL DEFAULT '' COMMENT '届数',
      `term` varchar(60) NOT NULL DEFAULT '' COMMENT '任数',
      `place` varchar(60) NOT NULL DEFAULT '' COMMENT '位数',
      `dynastic_title` varchar(200) NOT NULL DEFAULT '' COMMENT '庙号',
      `posthumous_title` varchar(200) NOT NULL DEFAULT '' COMMENT '谥号',
      `eraname` varchar(200) NOT NULL DEFAULT '' COMMENT '年号',
      `office_term` varchar(200) NOT NULL DEFAULT '' COMMENT '任期',
      `birth_death` varchar(200) NOT NULL DEFAULT '' COMMENT '生卒',
      `photo` varchar(200) NOT NULL DEFAULT '' COMMENT '标准照',
      `photo2` varchar(200) NOT NULL DEFAULT '' COMMENT '标准照2',
      `photo3` varchar(200) NOT NULL DEFAULT '' COMMENT '标准照3',
      `brief` varchar(200) NOT NULL DEFAULT '' COMMENT '简介',
      `brief2` varchar(200) NOT NULL DEFAULT '' COMMENT '简介2',
      `brief3` varchar(200) NOT NULL DEFAULT '' COMMENT '简介3',
      `description` varchar(200) NOT NULL DEFAULT '' COMMENT '描述',
      `mausoleum` varchar(200) NOT NULL DEFAULT '' COMMENT '陵墓',
      `baidu_url` varchar(300) NOT NULL DEFAULT '' COMMENT '百度百科URL',
      `wiki_url` varchar(300) NOT NULL DEFAULT '' COMMENT '维基百科URL',
      `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
      `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
      `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
      `extfield` varchar(200) NOT NULL DEFAULT '' COMMENT '附加字段'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `wp_calligrapher`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `wp_calligrapher`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';

