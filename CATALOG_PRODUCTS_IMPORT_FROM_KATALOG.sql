-- CATALOG_PRODUCTS_IMPORT_FROM_KATALOG.sql
-- Migra productos desde brightro_katalog.post -> brightro_brightronix_inv.products
-- Incluye mapeo de imágenes hacia media/product_media para NO cargar desde cero.
--
-- Requisitos:
-- 1) Ejecutar primero DB_MIGRATION_CATALOG_V1.sql en brightro_brightronix_inv
-- 2) Tener ambas BD en el mismo servidor MySQL/MariaDB:
--    - brightro_katalog
--    - brightro_brightronix_inv
-- 3) Copiar físicamente los archivos de imagen al path de Inventory:
--    /uploads/products/<nombre_imagen>

SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;

-- Shelf por defecto para productos importados (si no existe, abortar manualmente)
SET @default_shelf_id := (SELECT MIN(id) FROM brightro_brightronix_inv.shelves);

-- 1) Registrar imágenes en media (solo si no existen por file_name)
INSERT INTO brightro_brightronix_inv.media (file_name, file_type, description, uploaded_at)
SELECT
  p.image AS file_name,
  CASE
    WHEN LOWER(p.image) LIKE '%.png' THEN 'image/png'
    WHEN LOWER(p.image) LIKE '%.webp' THEN 'image/webp'
    WHEN LOWER(p.image) LIKE '%.gif' THEN 'image/gif'
    ELSE 'image/jpeg'
  END AS file_type,
  CONCAT('Imported from katalog post_id=', p.id) AS description,
  COALESCE(p.created_at, NOW()) AS uploaded_at
FROM brightro_katalog.post p
WHERE p.image IS NOT NULL
  AND p.image <> ''
  AND NOT EXISTS (
    SELECT 1
    FROM brightro_brightronix_inv.media m
    WHERE m.file_name = p.image
  );

-- 2) Upsert de productos al catálogo de Inventory
--    Requiere unique key en products.catalog_code (incluida en DB_MIGRATION_CATALOG_V1.sql)
INSERT INTO brightro_brightronix_inv.products (
  name,
  catalog_code,
  catalog_category,
  catalog_description,
  catalog_unit,
  catalog_brand,
  catalog_model,
  catalog_is_active,
  qr_code,
  quantity,
  shelf_id,
  media_id,
  date,
  note
)
SELECT
  p.name,
  p.code,
  c.name AS catalog_category,
  p.description,
  'ea' AS catalog_unit,
  NULL AS catalog_brand,
  NULL AS catalog_model,
  CASE WHEN p.is_public = 1 THEN 1 ELSE 0 END AS catalog_is_active,
  NULL AS qr_code,
  '0' AS quantity,
  @default_shelf_id AS shelf_id,
  m.id AS media_id,
  COALESCE(p.created_at, NOW()) AS date,
  CONCAT('Imported from katalog post_id=', p.id) AS note
FROM brightro_katalog.post p
LEFT JOIN brightro_katalog.category c
  ON c.id = p.category_id
LEFT JOIN brightro_brightronix_inv.media m
  ON m.file_name = p.image
WHERE p.code IS NOT NULL
  AND p.code <> ''
ON DUPLICATE KEY UPDATE
  name = VALUES(name),
  catalog_category = VALUES(catalog_category),
  catalog_description = VALUES(catalog_description),
  catalog_unit = VALUES(catalog_unit),
  catalog_is_active = VALUES(catalog_is_active),
  media_id = VALUES(media_id),
  note = VALUES(note);

-- 3) Relación product_media para consistencia multimedia
INSERT INTO brightro_brightronix_inv.product_media (product_id, media_id)
SELECT
  pr.id AS product_id,
  m.id AS media_id
FROM brightro_katalog.post p
INNER JOIN brightro_brightronix_inv.products pr
  ON pr.catalog_code = p.code
INNER JOIN brightro_brightronix_inv.media m
  ON m.file_name = p.image
LEFT JOIN brightro_brightronix_inv.product_media pm
  ON pm.product_id = pr.id AND pm.media_id = m.id
WHERE p.image IS NOT NULL
  AND p.image <> ''
  AND pm.id IS NULL;

COMMIT;

-- Verificaciones rápidas
-- SELECT COUNT(*) FROM brightro_katalog.post;
-- SELECT COUNT(*) FROM brightro_brightronix_inv.products WHERE note LIKE 'Imported from katalog post_id=%';
-- SELECT COUNT(*) FROM brightro_brightronix_inv.media WHERE description LIKE 'Imported from katalog post_id=%';
