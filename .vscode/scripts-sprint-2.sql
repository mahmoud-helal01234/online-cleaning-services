CREATE TABLE `regions` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `name_ar` VARCHAR(100) NOT NULL , `name_en` VARCHAR(100) NOT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `deleted_at` TIMESTAMP NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `regions` ADD `active` TINYINT NOT NULL DEFAULT '1' AFTER `name_en`;