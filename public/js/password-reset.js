
async function verify() {
    const params = new URLSearchParams(this.location.search);
    const token = params.get('token');
    try {
        const resp = await fetch('http://localhost:8000/api/password/reset/verify', {
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
    const params = new URLSearchParams(this.location.search);
    const token = params.get('token');
    const pass = document.getElementById('password').value;
    try {
        const resp = await fetch('http://localhost:8000/api/password/reset/change', {
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
            document.body.innerHTML = data['message'];
        }

        if (resp.status == 200 && !data['status']) {
            document.body.innerHTML = data['message'];
        }

        if (resp.status == 401) {
            window.location.href = 'http://localhost:8000/api/error/401';
        }

    } catch (error) {
        console.debug(error);
    }
}

window.addEventListener('load', function () {
    verify();
});