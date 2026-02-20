# Coordinación pendiente — ElectroPlan → Inventory (disparadores)

Estado verificado en código de ElectroPlan:
- Existe cliente de sync manual: `integrations/inventory/sync_project.php`
- Endpoint export existe: `GET /api/v1/projects/{id}/export`
- Falta disparador automático en:
  - `ProjectsController::store()` (alta)
  - `ProjectsController::update()` (cambios de nombre/status)

## Requerimientos para completar disparadores

1. **Hook post-creación (obligatorio)**
   - Después de insertar proyecto y obtener `$projectId`, disparar sync a Inventory.
   - Modo recomendado: asíncrono best-effort (no bloquear respuesta 201).

2. **Hook post-actualización (recomendado)**
   - Tras `UPDATE`, disparar sync para mantener Inventory alineado.

3. **Feature flag / configuración**
   - Solo ejecutar sync si está configurado:
     - `INVENTORY_UPSERT_URL`
     - `INVENTORY_SHARED_KEY` (opcional)
     - `ELECTROPLAN_API_BASE`
     - `ELECTROPLAN_CLIENT_ID`
     - `ELECTROPLAN_CLIENT_SECRET`

4. **Manejo de errores**
   - Log en archivo dedicado (ej: `integrations/logs/inventory_sync.log`)
   - No tumbar operación principal de ElectroPlan si falla el envío.

5. **Retry operativo**
   - Si falla el hook, permitir reintento manual:
     - `php integrations/inventory/sync_project.php <project_id>`

6. **Validación de contrato payload**
   - Payload actual esperado por Inventory:
     - `project_id` (string)
     - `name` (string)
     - `status` (string|null)
     - `updated_at` (datetime|string|null)
     - `metadata` (json)

## Criterio de listo
- Crear proyecto en ElectroPlan -> aparece en Inventory sin intervención manual.
- Editar nombre/estado en ElectroPlan -> Inventory refleja cambios.
- Fallas de red quedan auditadas y recuperables con retry manual.
