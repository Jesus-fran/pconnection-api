@extends('welcome')
@section('content')
    <h2>Hola {{ $username }}</h2>
    <form action="" method="post" id="form-change-pass">
        <input type="text" name="password" id="password"><br>
        <input type="text" name="passwordrep" id="passwordrep">
        <h6 style="color:red" id="validation"></h6>
        <input type="submit" value="Cambiar">
    </form>
    <script>
        const form = document.getElementById('form-change-pass');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            changePass();
        });
    </script>
@endsection
