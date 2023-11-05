<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperación de contraseña</title>
</head>

<body>
    <div
        style="background-color: whitesmoke; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 16pt; text-align: center">
        <div style="background-color:rgba(255, 92, 27, 0.692); text-align: center; border-radius: 25px;"><img
                src="{{ asset('img/logo.png') }}" style="width: 25%;" alt="Perfect Connection"></div>
        <h3 style="padding: 25px">¿Olvidaste tu contraseña?</h3>
        <p style="color:darkslategray; font-weight: 600">¡Hola {{ $username }}! Puedes restablecer tu contraseña
            haciendo clic en
            el siguiente
            botón:</p>
        <div style="width: 100%; text-align: center">
            <a href="http://localhost:8000/api/password/reset?token={{ $token }}"
                style="background-color:#F4B459; color:darkslategray; text-decoration: none; display: inline-block ; border-radius: 5px; padding: 10px; margin-top: 5%; margin-bottom: 50px; width: max-content; font-weight: 600;"
                target="_blank">Restablecer
                contraseña</a>
        </div>
        <p style="color:darkslategray; font-weight: 500">Tienes 15 minutos para elegir tu contraseña. Después de eso,
            tendrás que hacer otra solicitud.</p>
        <p style="color:darkslategray; font-weight: 500"> <strong style="color:tomato">Si no solicitaste </strong> una
            nueva contraseña. Por
            favor ignore este
            correo electrónico.</p>
        <br>
    </div>
</body>

</html>
