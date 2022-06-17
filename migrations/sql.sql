SELECT `b`.`code`, `b`.`name`,`f`.`code`,`f`.`name`,`f`.`name_card`,`s`.`name`,`s`.`author` FROM `wp_book` AS `b`, `wp_book_figure` AS `bf`, `wp_figure` AS `f`, `wp_scholarism` AS `s` WHERE `b`.`code` = `bf`.`book_code` AND `bf`.`figure_code` = `f`.`code` AND `b`.`code` = `s`.`book_code`;

SELECT * FROM `wp_scholarism` AS `s`, `wp_figure` AS `f` WHERE `s`.`author` = `f`.`name` GROUP BY `s`.`author` ;
SELECT * FROM `wp_calligrapher` AS `c`, `wp_figure` AS `f` WHERE `c`.`author` = `f`.`name` GROUP BY `c`.`name` ;
