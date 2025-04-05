<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Nuestra Aplicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            max-width: 600px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-custom {
            background: linear-gradient(135deg, #6e57e0, #8a2be2);
            border: none;
            padding: 12px 24px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.2);
            transition: width 0.4s ease-in-out, height 0.4s ease-in-out, top 0.4s ease-in-out, left 0.4s ease-in-out;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .btn-custom:hover::before {
            width: 0%;
            height: 0%;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(138, 43, 226, 0.5);
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido a Nuestra Plataforma</h1>
        <p>Administra y gestiona tus datos de manera eficiente con nuestra aplicación.</p>
        <a href="{{ route('login') }}" class="btn btn-custom">Iniciar Sesión</a>
    </div>
</body>
</html>
