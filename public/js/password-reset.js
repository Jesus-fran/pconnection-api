const URL = "https://1333-35-174-10-33.ngrok-free.app";

async function verify() {
    const params = new URLSearchParams(this.location.search);
    const token = params.get('token');
    try {
        const resp = await fetch(URL + '/api/password/reset/verify', {
            headers: {
                "Authorization": `Bearer ${token}`,
            },
        });

        const data = await resp.text();
        document.write(data);
    } catch (error) {
        console.debug(error);
    }
}

async function changePass() {
    const btn = document.getElementById('btn-change-pass');
    btn.setAttribute('disabled', true);
    btn.style = 'display:none';
    const spinner = document.getElementById('spinner');
    spinner.style = 'display:inline-block';
    const params = new URLSearchParams(this.location.search);
    const token = params.get('token');
    const pass = document.getElementById('password').value;
    try {
        const resp = await fetch(URL + '/api/password/reset/change', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ password: pass })
        });

        const data = await resp.json();

        if (resp.status == 422) {
            const msgValidation = document.getElementById('validation');
            msgValidation.innerHTML = data['errors']['password'][0];
        }

        if (resp.status == 200 && data['status']) {
            const content = document.getElementById('content');
            content.innerHTML = '<p style = "color:darkslategray; font-weight: 600; font-size:16pt; padding: 30px" >' + data['message'] + '</p>';
            return;
        }

        if (resp.status == 200 && !data['status']) {
            const msgValidation = document.getElementById('validation');
            msgValidation.innerHTML = data['message'];
        }

        if (resp.status == 401) {
            window.location.href = URL + '/api/error/401';
        }

        if (resp.status == 500) {
            msgError.innerHTML = 'Hubo un error en el servidor. Intente de nuevo';
        }

        spinner.style = 'display:none';
        btn.style = 'display:inline-block';
        btn.removeAttribute('disabled');
    } catch (error) {
        console.debug(error);
        const msgError = document.getElementById('validation');
        msgError.innerHTML = 'Hubo un error al intentar cambiar la contraseña. Intente de nuevo';
        spinner.style = 'display:none';
        btn.style = 'display:inline-block';
        btn.removeAttribute('disabled');
    }
}

window.addEventListener('load', function () {
    verify();
});

function validationPassRepeat(element) {
    const value = element.value;
    const valuePass = document.getElementById('password').value;
    const msgValidation = document.getElementById('validation');
    msgValidation.innerHTML = '';

    if (value !== valuePass) {
        msgValidation.innerHTML = 'Las contraseñas no coinciden.';
    }
}

function validationPass(element) {
    const value = element.value;
    const msgValidation = document.getElementById('validation');
    msgValidation.innerHTML = '';
    const inputRepeat = document.getElementById('passwordrep');
    inputRepeat.removeAttribute('disabled');

    if (value.length < 6) {
        msgValidation.innerHTML = 'Al menos debe tener 6 caracteres';
        inputRepeat.setAttribute('disabled', true);
        return;
    }

    const expresion = /^(?=.*[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ])(?=.*\d)(?=.*[@$!%*?&^#_.;\s:/-])[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\d@$!%*?&^#_.;\s:/-]+$/;
    if (!value.match(expresion)) {
        msgValidation.innerHTML = 'Su contraseña debe tener al menos una letra minúscula o  mayúscula, un número y un caracter especial';
        inputRepeat.setAttribute('disabled', true);
    }

}

function showPass(element) {
    const status = element.dataset.show;
    const idInput = element.dataset.input;
    const input = document.getElementById(idInput);
    if (status == 'true') {
        element.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>`;
        element.dataset.show = 'false';
        input.setAttribute('type', 'password');
    } else {
        element.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"> ñ<path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/></svg>`;
        element.dataset.show = 'true';
        input.setAttribute('type', 'text');
    }
}