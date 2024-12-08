$(document).ready(()=>{

    $("#table_payroll").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            language: {
                search: "Buscar en la tabla:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior",
                },
                emptyTable: "No hay datos disponibles",
            },
        });


});




async function getHistoryPayRoll(url, cedula, id){



    const token = localStorage.getItem("access_token");

    let response = await fetch(url+`/?cedula=${cedula}`,{
        method: "GET",
        headers:{

        "Content-Type": "application/json",
        "Authorization": `Bearer ${token}`
        }


    });

    let data = await response.json();


    if(data.status){



        
    }


}


async function sendPdf(url, iterations){

    let pdfs = collectPayRolls(iterations);

    const token = localStorage.getItem("access_token");


    let form = new FormData();


    getIdUser(iterations);
    return 0;

    let form_name = new FormData();


    console.log(form)


    pdfs.forEach((element,index)=>{

        form.append(`pdf[]`, element);

    })

    let response = await fetch(url,{


        method: "POST",
        headers:{

            "Authorization": `Bearer ${token}`
        },
        body: form
        
    });


    let data = await response.json();

    if(data.status){


        console.log("Se enviaron al backend de manera exitosa");


    }


}


function getIdUser(iterations){

    let array_name = [];


    
    for(let i = 0; i < iterations; i++){

        console.log("iteraciones: "+i)
        let elemento = document.getElementById(`input_pdf${i}`);

        let data = elemento.dataset.code;
       
        console.log("dueleee")

        console.log("elemento: "+elemento)
        array_name.push("hola");

    }

    console.log("hola")
    console.log(array_name);

    return array_name;

}


function collectPayRolls(iterations){

    console.log("las iteraciones son: "+iterations);

    
    let array = [];
    
    for(let i = 0; i < iterations; i++ ){
        
        let elemento = document.getElementById(`input_pdf${i}`);
        let element = elemento.files[0];

        if (!element || element.type !== 'application/pdf') {
            
            Swal.fire({
                title: "¡Uuuuups!",
                text: "¡¡Selecciona solo archivos PDF!!",
                icon: "error",
        });

            return 0;
        }
        array.push(element);
    }


    console.log(array);

    return array;

}