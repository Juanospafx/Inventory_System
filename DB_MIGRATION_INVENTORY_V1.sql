-- DB_MIGRATION_INVENTORY_V1.sql
-- Objetivo: habilitar sincronización de Projects desde ElectroPlan hacia Inventory_System
-- Motor esperado: MySQL / MariaDB
-- Nota: ejecutar en ventana de mantenimiento y con backup previo.

-- 1) Extender tabla projects con campos de integración
ALTER TABLE `projects`
  ADD COLUMN `project_id` VARCHAR(64) NULL AFTER `id`,
  ADD COLUMN `status` VARCHAR(40) NULL AFTER `name`,
  ADD COLUMN `external_updated_at` DATETIME NULL AFTER `status`,
  ADD COLUMN `metadata_json` LONGTEXT NULL AFTER `external_updated_at`,
  ADD COLUMN `last_synced_at` DATETIME NULL AFTER `metadata_json`;

-- 2) Índices/constraints para lookup y unicidad del ID canónico externo
ALTER TABLE `projects`
  ADD UNIQUE KEY `uq_projects_project_id` (`project_id`),
  ADD KEY `idx_projects_status` (`status`),
  ADD KEY `idx_projects_last_synced_at` (`last_synced_at`);

-- 3) Auditoría de integraciones (opcional pero recomendada: ya es usada por el código)
CREATE TABLE `integration_audit` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `source_system` VARCHAR(60) NOT NULL,
  `event_type` VARCHAR(120) NOT NULL,
  `external_project_id` VARCHAR(64) DEFAULT NULL,
  `http_method` VARCHAR(10) DEFAULT NULL,
  `endpoint` VARCHAR(255) DEFAULT NULL,
  `request_payload` LONGTEXT DEFAULT NULL,
  `response_code` INT DEFAULT NULL,
  `response_payload` LONGTEXT DEFAULT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'ok',
  `error_message` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_integration_audit_source_event` (`source_system`, `event_type`),
  KEY `idx_integration_audit_external_project` (`external_project_id`),
  KEY `idx_integration_audit_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4) Backfill de project_id para registros legacy (evita conflictos de NULL en casos mixtos)
UPDATE `projects`
SET `project_id` = CAST(`id` AS CHAR)
WHERE `project_id` IS NULL OR `project_id` = '';

-- 5) Endurecer project_id después del backfill
ALTER TABLE `projects`
  MODIFY COLUMN `project_id` VARCHAR(64) NOT NULL;
