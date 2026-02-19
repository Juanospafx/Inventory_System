-- DB_MIGRATION_CATALOG_V1.sql
-- Integración de catálogo dentro de Inventory_System (sobre tabla products)

ALTER TABLE `products`
  ADD COLUMN `catalog_code` VARCHAR(100) NULL AFTER `name`,
  ADD COLUMN `catalog_category` VARCHAR(150) NULL AFTER `catalog_code`,
  ADD COLUMN `catalog_description` TEXT NULL AFTER `catalog_category`,
  ADD COLUMN `catalog_unit` VARCHAR(20) NULL AFTER `catalog_description`,
  ADD COLUMN `catalog_brand` VARCHAR(120) NULL AFTER `catalog_unit`,
  ADD COLUMN `catalog_model` VARCHAR(120) NULL AFTER `catalog_brand`,
  ADD COLUMN `catalog_is_active` TINYINT(1) NOT NULL DEFAULT 1 AFTER `catalog_model`;

ALTER TABLE `products`
  ADD UNIQUE KEY `uq_products_catalog_code` (`catalog_code`),
  ADD KEY `idx_products_catalog_category` (`catalog_category`),
  ADD KEY `idx_products_catalog_is_active` (`catalog_is_active`);

-- Backfill opcional para productos existentes
UPDATE `products`
SET `catalog_code` = CONCAT('INV-', `id`)
WHERE (`catalog_code` IS NULL OR `catalog_code` = '');

UPDATE `products`
SET `catalog_unit` = 'ea'
WHERE (`catalog_unit` IS NULL OR `catalog_unit` = '');
