﻿<?php
require_once(__DIR__ . '/../includes/load.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#1b212d" id="metaThemeColor">
  <title>Login</title>
  <script>
    (function(){
      function pick(){
        try {
          var s = localStorage.getItem('app-theme');
          if (s === 'light' || s === 'dark') return s;
        } catch(e){}
        return (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) ? 'light' : 'dark';
      }
      var t = pick();
      document.documentElement.setAttribute('data-theme', t);
      document.documentElement.style.colorScheme = t;
    })();
  </script>
  <style>
    /* 
      1) Reset b??sico para ocupar toda la pantalla 
         y quitar m??rgenes del body.
    */
    :root {
      --bg-app:#1b212d;
      --bg-panel:#242a38;
      --bg-input:#151a23;
      --text-primary:#ffffff;
      --text-secondary:#8696af;
      --border-subtle:#2f384a;
      --accent:#fb5a3a;
      --accent-hover:#e0482b;
    }
    html[data-theme="light"] {
      --bg-app:#f4f6fb;
      --bg-panel:#ffffff;
      --bg-input:#eef2f7;
      --text-primary:#0f172a;
      --text-secondary:#64748b;
      --border-subtle:#d9e1ec;
      --accent:#fb5a3a;
      --accent-hover:#e0482b;
    }

    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      background: var(--bg-app);
      color: var(--text-primary);
      font-family: Arial, sans-serif;
    }

    /* 
      2) Contenedor flex que centra vertical y horizontalmente.
    */
    .login-container {
      display: flex;
      align-items: center;
      /* Centra verticalmente */
      justify-content: center;
      /* Centra horizontalmente */
      height: 100%;
    }

    /*
      3) Tarjeta de login (fondo blanco, bordes suaves, sombra, etc.)
    */
    .login-page {
      width: 350px;
      padding: 20px;
      background-color: var(--bg-panel);
      border: 1px solid var(--border-subtle);
      color: var(--text-primary);
      
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
      /* Sombra ligera */
      border-radius: 5px;
      /* Esquinas redondeadas */
      text-align: center;
      transform: translateY(-50px);
      /* Sube el formulario 50px desde el centro */
    }

    /*
      4) Estilos de los textos
    */
    .login-page h1 {
      margin-top: 0;
      margin-bottom: 5px;
      font-size: 28px;
      color: var(--text-primary);
    }

    .login-page p {
      margin: 0 0 20px 0;
      font-size: 16px;
      color: var(--text-secondary);
    }

    /*
      5) Simular la apariencia "form-control" de Bootstrap 
         (inputs con bordes, padding, etc.)
    */
    .form-group {
      margin-bottom: 15px;
      text-align: left;
      /* Para que el label quede a la izquierda */
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: var(--text-primary);
    }

    .form-control {
      display: block;
      width: 100%;
      padding: 8px 12px;
      font-size: 14px;
      color: var(--text-primary);
      background-color: var(--bg-input);
      border: 1px solid var(--border-subtle);
      border-radius: 4px;
      box-sizing: border-box;
    }

    /*
      6) Bot??n estilo "info" (azul claro) al estilo Bootstrap,
         pero hecho con CSS propio.
    */
    .btn-info {
      display: inline-block;
      width: 100%;
      padding: 10px 0;
      font-size: 16px;
      color: #fff;
      background-color: var(--accent);
      border: 1px solid var(--accent);
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      text-align: center;
      transition: background-color 0.2s, border-color 0.2s;
    }

    .btn-info:hover {
      background-color: var(--accent-hover);
      border-color: var(--accent-hover);
    }

    .theme-toggle-login {
      position: fixed;
      top: 14px;
      right: 14px;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      border: 1px solid var(--border-subtle);
      background: var(--bg-panel);
      color: var(--text-primary);
      cursor: pointer;
      z-index: 5;
    }

    /* Media query for mobile */
    @media (max-width: 480px) {
      .login-page {
        width: 90%;
        transform: translateY(-20px);
      }
    }
  </style>
</head>

<body>
  <button class="theme-toggle-login" id="themeToggleLogin" aria-label="Cambiar tema">☀️</button>
  <div class="login-container">
    <div class="login-page">
      <div class="text-center">
        <h1>Welcome</h1>
        <p>Login</p>
      </div>
      <!-- You can place your validation messages here if needed -->

      <form method="post" action="<?php echo base_url('api/auth.php'); ?>">
        <div class="form-group">
          <label for="username">User</label>
          <input type="text" id="username" class="form-control" name="username" placeholder="User">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-group">
          <button type="submit" class="btn-info">Access</button>
        </div>
      </form>
    </div>
  </div>
<script>
  (function(){
    function currentTheme(){ return document.documentElement.getAttribute('data-theme') || 'dark'; }
    function apply(theme, persist){
      document.documentElement.setAttribute('data-theme', theme);
      document.documentElement.style.colorScheme = theme;
      var meta=document.getElementById('metaThemeColor');
      if(meta) meta.setAttribute('content', theme==='light' ? '#f4f6fb' : '#1b212d');
      var btn=document.getElementById('themeToggleLogin');
      if(btn) btn.textContent = (theme==='dark' ? '☀️' : '🌙');
      try{ if(persist) localStorage.setItem('app-theme', theme); }catch(e){}
    }
    apply(currentTheme(), false);
    var btn=document.getElementById('themeToggleLogin');
    if(btn){
      btn.addEventListener('click', function(){
        var next = currentTheme()==='dark' ? 'light' : 'dark';
        apply(next, true);
      });
    }
  })();
</script>
</body>

</html>
