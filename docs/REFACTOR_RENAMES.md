# BrainWebApp v1 Refactor Renames

Each entry lists the old path, the new path, and the reason.

## Core and Infra
- `includes/config.php` -> `core/config.php`  
  Reason: centralize configuration under `core/`.
- `includes/database.php` -> `core/database.php`  
  Reason: DB infrastructure belongs to `core/`.
- `includes/session.php` -> `core/session.php`  
  Reason: session/auth infrastructure belongs to `core/`.
- `includes/upload.php` -> `core/upload.php`  
  Reason: upload infrastructure belongs to `core/`.
- `includes/sql.php` -> `core/sql.php`  
  Reason: data access layer belongs to `core/`.
- `includes/functions.php` -> `core/legacy_functions.php`  
  Reason: mixed helpers retained as legacy until fully separated.
- `includes/load.php` -> `core/bootstrap.php`  
  Reason: single bootstrap entrypoint for core wiring.

## Views
- `layouts/admin_menu.php` -> `views/admin_menu.php`  
  Reason: UI partial moved to `views/`.
- `layouts/special_menu.php` -> `views/special_menu.php`  
  Reason: UI partial moved to `views/`.
- `layouts/user_menu.php` -> `views/user_menu.php`  
  Reason: UI partial moved to `views/`.
- `layouts/header.php` -> `views/header.php`  
  Reason: UI partial moved to `views/`.
- `layouts/footer.php` -> `views/footer.php`  
  Reason: UI partial moved to `views/`.
- `header.php` -> `views/legacy_header.php`  
  Reason: legacy duplicate header preserved as compatibility partial.
- `footer.php` -> `views/legacy_footer.php`  
  Reason: legacy duplicate footer preserved as compatibility partial.

## Legacy Endpoints
- `ajax.php` -> `api/ajax.php`  
  Reason: legacy endpoint grouped under `api/`.
- `ajax_get_products.php` -> `api/ajax_get_products.php`  
  Reason: legacy endpoint grouped under `api/`.
- `auth.php` -> `api/auth.php`  
  Reason: legacy auth endpoint grouped under `api/`.
- `auth_v2.php` -> `api/auth_v2.php`  
  Reason: legacy auth endpoint grouped under `api/`.
- `logout.php` -> `api/logout.php`  
  Reason: legacy auth endpoint grouped under `api/`.

## Pages
- `add_group.php` -> `pages/add_group.php`  
  Reason: screen moved to `pages/`.
- `add_movement.php` -> `pages/add_movement.php`  
  Reason: screen moved to `pages/`.
- `add_product.php` -> `pages/add_product.php`  
  Reason: screen moved to `pages/`.
- `add_user.php` -> `pages/add_user.php`  
  Reason: screen moved to `pages/`.
- `admin.php` -> `pages/admin.php`  
  Reason: screen moved to `pages/`.
- `change_password.php` -> `pages/change_password.php`  
  Reason: screen moved to `pages/`.
- `daily_movements.php` -> `pages/daily_movements.php`  
  Reason: screen moved to `pages/`.
- `delete_group.php` -> `pages/delete_group.php`  
  Reason: screen moved to `pages/`.
- `delete_media.php` -> `pages/delete_media.php`  
  Reason: screen moved to `pages/`.
- `delete_movement.php` -> `pages/delete_movement.php`  
  Reason: screen moved to `pages/`.
- `delete_product.php` -> `pages/delete_product.php`  
  Reason: screen moved to `pages/`.
- `delete_project.php` -> `pages/delete_project.php`  
  Reason: screen moved to `pages/`.
- `delete_shelf.php` -> `pages/delete_shelf.php`  
  Reason: screen moved to `pages/`.
- `delete_user.php` -> `pages/delete_user.php`  
  Reason: screen moved to `pages/`.
- `edit_account.php` -> `pages/edit_account.php`  
  Reason: screen moved to `pages/`.
- `edit_group.php` -> `pages/edit_group.php`  
  Reason: screen moved to `pages/`.
- `edit_media.php` -> `pages/edit_media.php`  
  Reason: screen moved to `pages/`.
- `edit_movement.php` -> `pages/edit_movement.php`  
  Reason: screen moved to `pages/`.
- `edit_product.php` -> `pages/edit_product.php`  
  Reason: screen moved to `pages/`.
- `edit_project.php` -> `pages/edit_project.php`  
  Reason: screen moved to `pages/`.
- `edit_shelf.php` -> `pages/edit_shelf.php`  
  Reason: screen moved to `pages/`.
- `edit_user.php` -> `pages/edit_user.php`  
  Reason: screen moved to `pages/`.
- `group.php` -> `pages/group.php`  
  Reason: screen moved to `pages/`.
- `home.php` -> `pages/home.php`  
  Reason: screen moved to `pages/`.
- `index.php` -> `pages/index.php`  
  Reason: screen moved to `pages/`.
- `list_tables.php` -> `pages/list_tables.php`  
  Reason: screen moved to `pages/`.
- `login_v2.php` -> `pages/login_v2.php`  
  Reason: screen moved to `pages/`.
- `media.php` -> `pages/media.php`  
  Reason: screen moved to `pages/`.
- `monthly_movements.php` -> `pages/monthly_movements.php`  
  Reason: screen moved to `pages/`.
- `movements.php` -> `pages/movements.php`  
  Reason: screen moved to `pages/`.
- `movements_report.php` -> `pages/movements_report.php`  
  Reason: screen moved to `pages/`.
- `movement_report_process.php` -> `pages/movement_report_process.php`  
  Reason: screen moved to `pages/`.
- `product.php` -> `pages/product.php`  
  Reason: screen moved to `pages/`.
- `profile.php` -> `pages/profile.php`  
  Reason: screen moved to `pages/`.
- `projects.php` -> `pages/projects.php`  
  Reason: screen moved to `pages/`.
- `shelf.php` -> `pages/shelf.php`  
  Reason: screen moved to `pages/`.
- `users.php` -> `pages/users.php`  
  Reason: screen moved to `pages/`.
- `verify_notes.php` -> `pages/verify_notes.php`  
  Reason: screen moved to `pages/`.

## Compatibility Wrappers
Wrappers were created at the old locations to preserve public URLs and include paths.

## Removed Duplicates
- `auth_v2.php` and `api/auth_v2.php`  
  Reason: duplicate login flow not referenced; `auth.php` is the single source of truth.
- `ajax_get_products.php` and `api/ajax_get_products.php`  
  Reason: duplicate of location lookup already handled by `ajax.php`.
- `header.php` and `footer.php` (root wrappers)  
  Reason: legacy duplicates not referenced after pages moved to `views/`.
- `views/legacy_header.php` and `views/legacy_footer.php`  
  Reason: duplicate partials no longer referenced.
- `layouts/header.php`, `layouts/footer.php`, `layouts/admin_menu.php`, `layouts/special_menu.php`, `layouts/user_menu.php`  
  Reason: wrapper duplicates removed after all pages reference `views/` directly.
- All root-level `*.php` wrappers (e.g., `add_product.php`, `projects.php`, `auth.php`)  
  Reason: entrypoints consolidated under `pages/` and `api/`. Access is now `/pages/*.php` and `/api/*.php`.
