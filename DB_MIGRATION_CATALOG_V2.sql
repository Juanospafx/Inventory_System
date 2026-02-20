-- DB_MIGRATION_CATALOG_V2.sql
-- Ajustes de catálogo para operación sin shelf obligatorio + categorías normalizadas

START TRANSACTION;

CREATE TABLE IF NOT EXISTS `catalog_categories` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_catalog_categories_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `products`
  ADD COLUMN `catalog_category_id` INT(11) UNSIGNED NULL AFTER `catalog_category`;

ALTER TABLE `products`
  MODIFY COLUMN `shelf_id` INT(11) UNSIGNED NULL;

ALTER TABLE `products`
  ADD KEY `idx_products_catalog_category_id` (`catalog_category_id`);

INSERT IGNORE INTO `catalog_categories` (`name`)
SELECT DISTINCT `catalog_category`
FROM `products`
WHERE `catalog_category` IS NOT NULL AND `catalog_category` <> '';

UPDATE `products` p
JOIN `catalog_categories` c ON c.`name` = p.`catalog_category`
SET p.`catalog_category_id` = c.`id`
WHERE p.`catalog_category` IS NOT NULL AND p.`catalog_category` <> '';

COMMIT;
