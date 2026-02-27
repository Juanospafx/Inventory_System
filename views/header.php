<?php $user = current_user(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <script>
    (function () {
      function pickTheme() {
        try {
          var stored = localStorage.getItem('app-theme');
          if (stored === 'light' || stored === 'dark') return stored;
        } catch (e) {}
        return (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) ? 'light' : 'dark';
      }
      function applyTheme(theme, persist) {
        document.documentElement.setAttribute('data-theme', theme);
        if (document.body) document.body.setAttribute('data-theme', theme);
        var meta = document.getElementById('metaThemeColor');
        if (meta) meta.setAttribute('content', theme === 'light' ? '#f4f6fb' : '#1b212d');
        var btn = document.getElementById('themeToggle');
        if (btn) btn.textContent = (theme === 'dark' ? '☀️' : '🌙');
        try { if (persist) localStorage.setItem('app-theme', theme); } catch (e) {}
      }
      window.__applyTheme = applyTheme;
      window.__toggleTheme = function(){
        var current = document.documentElement.getAttribute('data-theme') || pickTheme();
        applyTheme(current === 'dark' ? 'light' : 'dark', true);
      };
      var initial = pickTheme();
      applyTheme(initial, false);
      document.addEventListener('DOMContentLoaded', function(){ applyTheme(document.documentElement.getAttribute('data-theme') || initial, false); });
    })();
  </script>
  <style>html[data-theme="dark"], html[data-theme="dark"] body { background-color: #1b212d !important; } html[data-theme="light"], html[data-theme="light"] body { background-color: #f4f6fb !important; }</style>
  <!-- Meta etiqueta para colorear la barra del navegador en móviles -->
  <meta name="theme-color" content="#1b212d" id="metaThemeColor">
  <title><?php if (!empty($page_title))
    echo remove_junk($page_title);
  elseif (!empty($user))
    echo ucfirst($user['name']);
  else
    echo "Brigtronix- INVI"; ?>
  </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Añadida la fuente Poppins para un estilo más moderno -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
  <!-- Migrando de Bootstrap 3.3.4 a Bootstrap 5.3.3 para modernizar la interfaz -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url('libs/css/main.css'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="<?php echo base_url('libs/images/logo-text.png'); ?>">
</head>

<body data-base-url="<?php echo base_url(''); ?>">
  <?php if ($session->isUserLoggedIn()): ?>
    <header id="header">
      <div class="logo float-start">
        <div class="logo-container">
           <img src="<?php echo base_url('libs/images/logo-text.png'); ?>" alt="Brigtronix Logo" class="logo-full">
           <span class="app-subtitle">Inventory System</span>
        </div>
      </div>
      <div class="header-content">
        <div class="sidebar-toggle">
          <a href="#" class="sidebar-toggle-btn" aria-label="Abrir menú"><i class="fa fa-bars"></i></a>
        </div>
        <div class="header-date float-start">
          <strong><span id="time"></span></strong>
        </div>
        <div class="float-end clearfix me-3">
          <ul class="info-menu list-inline list-unstyled mb-0 d-flex align-items-center">
            <li class="me-2">
              <button type="button" class="theme-btn" id="themeToggle" aria-label="Cambiar tema" title="Cambiar tema" onclick="window.__toggleTheme && window.__toggleTheme()">☀️</button>
            </li>
            <li class="profile">
              <!-- Actualizado para el dropdown de Bootstrap 5 -->
              <a href="#" data-bs-toggle="dropdown" class="toggle" aria-expanded="false">
                <img src="<?php echo base_url('uploads/users/' . $user['image']); ?>" alt="user-image" class="rounded-circle img-inline">
                <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo base_url('pages/profile.php?id=' . (int) $user['id']); ?>">
                    <i class="fa-solid fa-user"></i>
                    Profile
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('pages/edit_account.php'); ?>" title="edit account">
                    <i class="fa-solid fa-cog"></i>
                    Configuration
                  </a>
                </li>
                <li class="last">
                  <a href="<?php echo base_url('api/logout.php'); ?>">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </header>
    <div class="sidebar">
      <?php if ($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <?php include_once(__DIR__ . '/admin_menu.php'); ?>

      <?php elseif ($user['user_level'] === '2'): ?>
        <!-- Special user -->
        <?php include_once(__DIR__ . '/special_menu.php'); ?>

      <?php elseif ($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <?php include_once(__DIR__ . '/user_menu.php'); ?>

      <?php endif; ?>

    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
  <?php endif; ?>

  <div class="page">
    <div class="container-fluid">
