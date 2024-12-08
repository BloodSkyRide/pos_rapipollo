// Configura la URL base si es necesario
window.onload = function() {
    
    const token = localStorage.getItem('access_token');
    if(token){

       // window.location.href = `/reloj/public/dashboard?token=${encodeURIComponent(token)}`; // Cambia la URL por la que desees
    }
    
};


const input_pass = document.getElementById("pass");

input_pass.addEventListener('keypress', function(event){


    if(event.key === 'Enter'){

        sendData();

    }

});

// Configuración de AJAX para incluir el token CSRF
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

async function sendData() {
    let cedula = document.getElementById("cedula").value;
    let pass = document.getElementById("pass").value;

    console.log("Entra en la función: " + cedula);

    try {
        const res = await $.ajax({
            url: './login',
            type: 'POST',
            dataType: 'json',
            data: { cedula, pass }
        });

        if (res.status) {
            console.log("Éxitoso");
            console.log(res.access_token);
            localStorage.setItem('access_token', res.access_token);
            const token = localStorage.getItem('access_token');

            console.log("Token a enviar: " + token);

        //   let responses =  await fetch('/reloj/public/dashboard',{
        //         method: "POST",
        //         headers: {
        //             'Authorization': `Bearer ${token}`
        //         },
                
        //     })

                 window.location.href = `./dashboard?token=${encodeURIComponent(token)}`;
            

            if (!res.ok) {
                throw new Error('Error en la respuesta del dashboard');
            }

            const dashboardData = await res.json();
            console.log(dashboardData);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}