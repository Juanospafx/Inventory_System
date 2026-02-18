# INTEGRATION — Inventory_System ↔ ElectroPlan (Etapa 1)

## Objetivo
Permitir que Inventory_System se conecte con ElectroPlan para:
1) listar proyectos disponibles
2) asociar movimientos/ítems de inventario a un proyecto canónico

## Arquitectura (mínima, sin frameworks)
En Inventory_System se crea un módulo de integración:

/integrations/electroplan/
  client.php        (HTTP client wrapper)
  endpoints.php     (URLs y rutas)
  dto.php           (mapeo de respuesta a estructura usable)
  cache.php         (opcional, archivo o sesión)

Y un módulo de DB:

/db/
  connection.php
  queries.php

## Flujo UI típico
1) Usuario abre “Asignar inventario a proyecto”
2) Inventory llama a ElectroPlan: GET /projects?status=active
3) Inventory muestra dropdown/lista
4) Usuario selecciona proyecto
5) Inventory guarda en su DB:
   - electroplan_project_id
   - metadata local del inventario
6) Cuando necesite validar:
   - Inventory consulta GET /projects/{id}

## Configuración requerida
Inventory necesita variables:
- ELECTROPLAN_BASE_URL (ej: http://localhost:8000 o URL real)
- ELECTROPLAN_TOKEN (si aplica; si no, vacío)

Estas variables viven en config local (config.php o .env simple).
