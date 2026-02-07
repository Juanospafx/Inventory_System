<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    /* 
      1) Reset básico para ocupar toda la pantalla 
         y quitar márgenes del body.
    */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      background: #f1f2f7;
      /* Fondo gris claro */
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
      background-color: #f9f9f9;
      /* Fondo blanco/gris muy claro */
      border: 1px solid #f2f2f2;
      /* Borde sutil */
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
      color: #333;
    }

    .login-page p {
      margin: 0 0 20px 0;
      font-size: 16px;
      color: #777;
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
      color: #333;
    }

    .form-control {
      display: block;
      width: 100%;
      padding: 8px 12px;
      font-size: 14px;
      color: #555;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    /*
      6) Botón estilo "info" (azul claro) al estilo Bootstrap,
         pero hecho con CSS propio.
    */
    .btn-info {
      display: inline-block;
      width: 100%;
      padding: 10px 0;
      font-size: 16px;
      color: #fff;
      background-color: #5bc0de;
      /* Azul claro tipo "info" */
      border: 1px solid #46b8da;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      text-align: center;
      transition: background-color 0.2s, border-color 0.2s;
    }

    .btn-info:hover {
      background-color: #31b0d5;
      /* Efecto hover más oscuro */
      border-color: #269abc;
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
  <div class="login-container">
    <div class="login-page">
      <div class="text-center">
        <h1>Welcome</h1>
        <p>Login</p>
      </div>
      <!-- Aquí puedes colocar tus mensajes de validación si los necesitas -->

      <form method="post" action="auth.php">
        <div class="form-group">
          <label for="username">User</label>
          <input type="text" id="username" class="form-control" name="username" placeholder="Usuario">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" class="form-control" name="password" placeholder="Contraseña">
        </div>
        <div class="form-group">
          <button type="submit" class="btn-info">Access</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>