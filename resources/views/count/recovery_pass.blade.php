@extends('welcome')
@section('content')
    <div style="background-color: white; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; text-align: center"
        class="first-div">
        <div style="width: 40%; display: inline-block; background-color:whitesmoke; border-radius: 25px" class="second-div">
            <div style="background-color:rgba(255, 92, 27, 0.692); text-align: center; border-radius: 25px; width: 100%; display: inline-block"
                class="div-head">
                <img src="{{ asset('img/logo.png') }}" style="width: 30%; height: auto;" alt="Perfect Connection"
                    class="logo">
            </div>
            <div id="content">
                <h3 style="padding: 15px">Hola {{ $username }}</h3>
                <p style="color:darkslategray; font-weight: 600; padding: 15px">Registra tu nueva contraseña en el siguiente
                    formulario</p>
                <form action="" method="post" id="form-change-pass" style="display: inline-block; text-align: center">
                    <input type="password" name="password" id="password" placeholder="Nueva contraseña"
                        style="display: inline-block; height:35px; width:70%; margin-bottom: 15px; border: solid; border-color:lightgray; border-radius: 10px"
                        onblur="validationPass(this)">
                    <button onclick="showPass(this)" style="display: inline; border: none; height: 37px; cursor: pointer;"
                        data-show="false" data-input="password" type="button"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                        </svg></button>
                    <input type="password" name="passwordrep" id="passwordrep" placeholder="Repite tu contraseña"
                        style="display: inline-block; height:35px; width:70%; border: solid; border-color:lightgray; border-radius: 10px"
                        onblur="validationPassRepeat(this)">
                    <button onclick="showPass(this)" style="display: inline; border: none; height: 37px; cursor: pointer;"
                        data-show="false" data-input="passwordrep" type="button"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                        </svg></button>
                    <p style="color:salmon; font-weight: 600; display: inline-block; width: 60%" id="validation"></p>
                    <br>
                    <input type="submit" value="Cambiar contraseña"
                        style="background-color:#F4B459; color:darkslategray; text-decoration: none; display: inline-block ; border-radius: 5px; padding: 10px; margin-top: 5%; margin-bottom: 50px; width: max-content; font-weight: 600; border: none; cursor: pointer;"
                        class="btn-change-pass" id="btn-change-pass">
                </form>
            </div>
        </div>
    </div>
    <style>
        /* Estilos específicos para teléfonos */
        @media (max-width: 768px) {
            body div {
                width: 100% !important;
            }

        }
    </style>
    <script>
        const form = document.getElementById('form-change-pass');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            changePass();
        });
    </script>
@endsection
