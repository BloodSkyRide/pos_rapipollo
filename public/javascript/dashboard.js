// Pusher.logToConsole = true;

// // sistema de escucha de eventos para notificaciones en tiempo real
// var echo = new Echo({
//     broadcaster: "pusher",
//     cluster: "mt1",
//     key: "p91ggxwl09aprwmrkr38", // cambiar por la key generada en el archivo .env REVERB_APP_KEY, si se desea cambiar se puede usar php artisan reverb:install
//     wsHost: "localhost",
//     wsPort: 8080,
//     forceTLS: false,
//     enabledTransports: ["ws", "wss"], // Solo WebSockets ws:http wss: https
//     disabledTransports: ["xhr_polling", "xhr_streaming"], // Deshabilita otras opciones y evita el cors
//     auth: {
//         headers: {
//             Authorization: `Bearer ${localStorage.getItem("access_token")}`, // Reemplaza con tu token real
//         },
//     },
// });

// echo.channel("realtime-channel") // El nombre del canal debe coincidir con lo que usas en el backend
//     .listen(".eventNotifications", function (data) {
//         let role = document.getElementById("role_h1").textContent;

//         if (role === "administrador") {
//             playNotificationSound();
//             $(document).Toasts("create", {
//                 class: "bg-info",
//                 title: "Solicitud hora extra",
//                 subtitle: "Notificación",
//                 body: data.message,
//             });
//         }
//     });

function startChannelPrivate(id_user) {
    echo.connector.pusher.config.auth = {
        headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
    };

    echo.private(`user-${id_user}`).listen(".responseAdmin", (data) => {
        playNotificationSound();

        let text_class = data.state === "Aceptado" ? "bg-success" : "bg-danger";

        $(document).Toasts("create", {
            class: text_class,
            title: "Respuesta de administración",
            subtitle: "",
            body: data.message,
        });
    });
}

function playNotificationSound() {
    const audio = document.getElementById("notificationSound");
    if (audio) {
        audio.play().catch((error) => {
            console.error("Error reproduciendo el sonido: ", error);
        });
    }
}

//////////////////////////////////////////////////////////////////////

$(document).ready(function () {
    $("#register_nav").trigger("click");
});
async function register_user(url) {
    const token = localStorage.getItem("access_token");
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    }).done(function (res) {
        if (res.status) {
            let element_container = document.getElementById("container_menu");
            element_container.innerHTML = res.html;
        }
    });
}

async function sendUser(url) {
    let formdata = document.getElementById("formdata");
    let form = new FormData(formdata);
    let jsonObject = {};

    const token = localStorage.getItem("access_token");

    if (verifyInputs()) {
        form.forEach((value, key) => {
            jsonObject[key] = value;
        });

        let response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },

            body: JSON.stringify(jsonObject),
        });

        if (response.ok) {
            let data = await response.json();

            if (data.status) {
                Swal.fire({
                    title: "Excelente!",
                    text: "El usuario fue creado de manera exitosa",
                    icon: "success",
                });

                formdata.reset();
            } else {
                Swal.fire({
                    title: "Uuuuups!",
                    text: "El usuario no pudó ser guardado en la base de datos, por favor revisa que todos los campos esten bien formados, recuerda que el nacimiento debe ser mayor a 18 años consulta con el departamento de sistemas",
                    icon: "error",
                });
            }
        }
    }
}

// async function showManageLabor(url) {

//     const token = localStorage.getItem("access_token");
//     let response = await fetch(url, {
//         method: "GET",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//     });

//     if (response.status) {
//         let data = await response.json();
//         let element_container = document.getElementById("container_menu");

//         element_container.innerHTML = data.html;
//         $(".select2").select2();
//         $(".select2bs4").select2({
//             theme: "bootstrap4",
//         });

//         initializeDataTable();
//     }
// }

// function addSubLabors() {
//     let item = document.getElementById("item_labor").value.trim();

//     document.getElementById("item_labor").value = "";

//     let parent_nodo = document.getElementById("add_labors");

//     let id_flaf = 1;

//     if (!parent_nodo.hasChildNodes()) {
//         parent_nodo.innerHTML = `<button onclick=(deleteItem(this.id)) id='item${id_flaf}'style='padding: 0; border: none; background-color: inherit;' class='m-1'><span class='badge badge-info'>${item}</span></button>`;
//     } else {
//         let num_childs = parent_nodo.childNodes.length;

//         parent_nodo.innerHTML += `<button onclick=(deleteItem(this.id)) id='item${
//             id_flaf + num_childs
//         }'style='padding: 0; border: none; background-color: inherit;' class='m-1'><span class='badge badge-info'>${item}</span></button>`;
//     }
// }

// function deleteItem(id) {
//     let item = document.getElementById(id);

//     item.remove();
// }

// async function sendSubLabors(url) {
//     let parent_nodo = document.getElementById("add_labors");

//     let elements = parent_nodo.querySelectorAll("button > span");
//     let texts = [];

//     const token = localStorage.getItem("access_token");

//     elements.forEach((element) => {
//         texts.push(element.textContent);
//     });

//     let sub_labors_string = parent_nodo.textContent;

//     let id_labor_principal = document.getElementById("select_labor").value;

//     if (texts.length > 0 && id_labor_principal !== "selected") {
//         let response = await fetch(url, {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/json",
//                 Authorization: `Bearer ${token}`,
//             },
//             body: JSON.stringify({
//                 id_labor_principal,
//                 texts,
//             }),
//         });

//         if (response.status) {
//             let data = await response.json();

//             let element_container = document.getElementById("container_menu");

//             element_container.innerHTML = data.html;

//             initializeDataTable();

//             Swal.fire({
//                 title: "¡Excelente!",
//                 text: "¡¡ Se añadió de manera exitosa el grupo de sub labores!!",
//                 icon: "succes",
//             });
//         }
//     } else {
//         Swal.fire({
//             title: "¡Uuuuups!",
//             text: "¡¡ verifica que hayas cargado sub labores en la tabla ó no has seleccionado una labor a la cual asignar el grupo de sublabores!!",
//             icon: "error",
//         });
//     }
// }

// function deleteSubLaborsDashborad() {
//     let parent_nodo = document.getElementById("add_labors");

//     parent_nodo.innerHTML = "";
// }

// async function delteSubLaborTable(url) {

//     let column_subgroups = document.querySelectorAll(
//         `td > div.div_checknox > input[type="checkbox"]:checked`
//     );

//     let array = [];

//     column_subgroups.forEach((node) => {
//         array.push(node.value);
//     });

//     const token = localStorage.getItem("access_token");

//     let response = await fetch(url, {
//         method: "DELETE",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//         body: JSON.stringify({
//             ids_deletes: array,
//         }),
//     });

//     if (response.status) {
//         let data = await response.json();

//         let element_container = document.getElementById("container_menu");

//         element_container.innerHTML = data.html;

//         initializeDataTable();
//     }
// }

// async function createLabor(url) {
//     let name_labor = document.getElementById("name_labor").value;
//     const token = localStorage.getItem("access_token");

//     let response = await fetch(url, {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },

//         body: JSON.stringify({
//             name_labor,
//         }),
//     });

//     if (response.status) {
//         let data = await response.json();

//         let element_container = document.getElementById("container_menu");

//         element_container.innerHTML = data.html;
//         initializeDataTable();
//     }
// }

// function initializeDataTable() {
//     $("#table_labors").DataTable({
//         responsive: true,
//         lengthChange: false,
//         autoWidth: false,
//         buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
//         language: {
//             search: "Buscar en la tabla:",
//             lengthMenu: "Mostrar _MENU_ registros",
//             info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
//             paginate: {
//                 first: "Primero",
//                 last: "Último",
//                 next: "Siguiente",
//                 previous: "Anterior",
//             },
//             emptyTable: "No hay datos disponibles",
//         },
//     });
// }

// async function getShowLabors(url) {
//     const token = localStorage.getItem("access_token");
//     let response = await fetch(url, {
//         method: "GET",
//         headers: {
//             "Content-type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//     });
//     let data = await response.json();

//     if (data.status) {

//         let element_container = document.getElementById("container_menu");

//         element_container.innerHTML = data.html;
//     } else {

//         Swal.fire({
//             title: "¡Uuuuups!",
//             text: "¡¡ Parece que no has iniciado labores o ya has finalizado tu jornada laboral!!",
//             icon: "error",
//         });
//     }
// }

async function getShowAssists(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    if (response.status) {
        let data = await response.json();

        let element_container = document.getElementById("container_menu");

        element_container.innerHTML = data.html;
        $("#reservationdate").datetimepicker({
            format: "L",
        });

        $("#report_table").DataTable({
            responsive: true,
            order: [[7, "desc"]],
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
    }
}

function sendDataSet(state, id) {
    let bridge = document.getElementById("bridge");

    bridge.dataset.dataState = state;
    bridge.dataset.dataId = id;

    let modal_message = document.getElementById("security");

    modal_message.innerHTML = `seguro de: ${state}`;
}

function retardo(iterator) {
    return new Promise((resolve, reject) => {
        let button = document.getElementById("button_send_modal");

        let bridge = document.getElementById("bridge");
        let button_id = bridge.dataset.dataId;
        let object_button = document.getElementById(button_id);
        setTimeout(() => {
            button.innerHTML = `<i class="fa-solid fa-circle-check"></i>&nbsp;&nbsp;Confirmar (${
                iterator - 1
            })`;
            object_button.innerHTML = `<i class="fa-solid fa-clock" ></i> Cargando ... (${
                iterator - 1
            })`;
            resolve();
        }, 1000);
    });
}

async function sendModalAccept(url) {
    let data = document.getElementById("bridge").dataset.dataState;

    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            estado: data,
        }),
    });

    let button = document.getElementById("button_send_modal");
    let bridge = document.getElementById("bridge");
    let button_id = bridge.dataset.dataId;
    let object_button = document.getElementById(button_id);

    object_button.setAttribute("disabled", "true");

    button.setAttribute("disabled", "true");

    let iterator = 15;
    for (i = 1; i <= 15; i++) {
        await retardo(iterator);

        iterator--;

        if (iterator === 0) {
            button.innerHTML = `<i class="fa-solid fa-circle-check"></i>&nbsp;&nbsp;Confirmar`;
            button.removeAttribute("disabled");
        }
    }

    if (response.status) {
        let data = await response.json();

        let element_container = document.getElementById("container_menu");

        element_container.innerHTML = data.html;

        $("#exampleModal").modal("hide");
    }
}

// async function verifyHomeWorks(url) {
//     let result = document.querySelectorAll(
//         `td.column_sub_labor > div.icheck-primary > input[type="checkbox"]:checked`
//     );

//     let checked = [];

//     const token = localStorage.getItem("access_token");

//     result.forEach((node, index) => {
//         checked.push(node.value);
//     });

//     let response = await fetch(url, {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//         body: JSON.stringify({
//             checked,
//         }),
//     });

//     if (response.status) {
//         let data = await response.json();

//         let element_container = document.getElementById("container_menu");

//         element_container.innerHTML = data.html;
//     }
// }

// async function rechargeSubLabors(url) {
//     let column_subgroups = document.querySelectorAll(
//         `td > div.div_checknox > input[type="checkbox"]:checked`
//     );

//     if (column_subgroups.length > 0) {
//         let array = [];

//         column_subgroups.forEach((node) => {
//             array.push(node.value);
//         });

//         const token = localStorage.getItem("access_token");
//         let response = await fetch(url, {
//             method: "PUT",
//             headers: {
//                 "Content-Type": "application/json",
//                 Authorization: `Bearer ${token}`,
//             },

//             body: JSON.stringify({
//                 checked: array,
//             }),
//         });

//         if (response.status) {
//             Swal.fire({
//                 title: "Excelente!",
//                 text: "¡¡Se han renovado las sub labores seleccionadas!!",
//                 icon: "success",
//             });

//             column_subgroups.forEach((node) => {
//                 node.checked = false;
//             });
//         } else {
//             Swal.fire({
//                 title: "Uuuuups!",
//                 text: "¡¡No se han renovado las sub labores, consulta con el departamento de sistemas!!",
//                 icon: "error",
//             });
//         }
//     } else {
//         Swal.fire({
//             title: "Uuuuups!",
//             text: "¡¡Recuerda seleccionar las sub labores a las cuales quieres renovar!!",
//             icon: "error",
//         });
//     }
// }

// async function getViewHistoryLabors(url) {
//     const token = localStorage.getItem("access_token");
//     let response = await fetch(url, {
//         method: "GET",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//     });

//     if (response.status) {
//         let data = await response.json();

//         let element_container = document.getElementById("container_menu");

//         element_container.innerHTML = data.html;
//         $("#reservation").daterangepicker();

//         $(".select2").select2();
//         $(".select2bs4").select2({
//             theme: "bootstrap4",
//         });

//         $("#history_table_searcher").DataTable({
//             responsive: true,
//             order: [[4, "desc"]],
//             lengthChange: false,
//             autoWidth: false,
//             buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
//             language: {
//                 search: "Buscar en la tabla:",
//                 lengthMenu: "Mostrar _MENU_ registros",
//                 info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
//                 paginate: {
//                     first: "Primero",
//                     last: "Último",
//                     next: "Siguiente",
//                     previous: "Anterior",
//                 },
//                 emptyTable: "No hay datos disponibles",
//             },
//         });
//     }
// }

// function getRangeDatePicker() {
//     let range = document.getElementById("reservation").value;

//     return range;
// }

// async function searchForRange(url) {
//     let range = getRangeDatePicker();
//     const token = localStorage.getItem("access_token");

//     let response = await fetch(`${url}?range=${range}`, {
//         method: "GET",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//     });

//     let data = await response.json();

//     if (data.status) {

//         let element_container = document.getElementById("container_menu");

//         element_container.innerHTML = data.html;
//         $("#reservation").daterangepicker();

//         $(".select2").select2();
//         $(".select2bs4").select2({
//             theme: "bootstrap4",
//         });

//         $("#reservation").val(range);

//         $("#history_table_searcher").DataTable({
//             responsive: true,
//             order: [[4, "desc"]],
//             lengthChange: false,
//             autoWidth: false,
//             buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
//             language: {
//                 search: "Buscar en la tabla:",
//                 lengthMenu: "Mostrar _MENU_ registros",
//                 info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
//                 paginate: {
//                     first: "Primero",
//                     last: "Último",
//                     next: "Siguiente",
//                     previous: "Anterior",
//                 },
//                 emptyTable: "No hay datos disponibles",
//             },
//         });
//     }
// }

// async function searcherText(url) {
//     let range = getRangeDatePicker();
//     let searcher = document.getElementById("labor_select").value;

//     const token = localStorage.getItem("access_token");

//     let response = await fetch(`${url}?range=${range}&text=${searcher}`, {
//         method: "GET",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//     });

//     let data = await response.json();

//     if (data.status) {

//         let element_container = document.getElementById("container_menu");

//         element_container.innerHTML = data.html;
//         $("#reservation").daterangepicker();

//         document.getElementById("labor_select").value = searcher;
//         $(".select2").select2();
//         $(".select2bs4").select2({
//             theme: "bootstrap4",
//         });

//         $("#reservation").val(range);

//         $("#history_table_searcher").DataTable({
//             responsive: true,
//             order: [[4, "desc"]],
//             lengthChange: false,
//             autoWidth: false,
//             buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
//             language: {
//                 search: "Buscar en la tabla:",
//                 lengthMenu: "Mostrar _MENU_ registros",
//                 info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
//                 paginate: {
//                     first: "Primero",
//                     last: "Último",
//                     next: "Siguiente",
//                     previous: "Anterior",
//                 },
//                 emptyTable: "No hay datos disponibles",
//             },
//         });
//     }
// }

// async function collectSubLabors(url) {
//     $("#modal_confirm").modal("hide");

//     const token = localStorage.getItem("access_token");

//     let response = await fetch(url, {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//     });

//     let data = await response.json();

//     if (data.status) {
//         Swal.fire({
//             title: "¡Excelente!",
//             text: "¡¡Excelente las sub labores han sido recogidas de manera exitosa!!",
//             icon: "success",
//         });
//     } else {
//         Swal.fire({
//             title: "¡Uuups!",
//             text: "¡¡hubó un error, consulta con el departamento de sistemas si el error persiste!!",
//             icon: "error",
//         });
//     }
// }

async function getShowReportAssists(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");

        element_container.innerHTML = data.html;
    }
}

async function getShowAdminUsers(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");

        element_container.innerHTML = data.html;

        $("#table_userss").DataTable({
            responsive: true,
            order: [[9, "desc"]],
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
    }
}

async function openModalUser(cedula, url) {
    $("#modal_edit").modal("show");

    document.getElementById("button_save").dataset.dataId = cedula;

    const token = localStorage.getItem("access_token");

    let response = await fetch(`${url}?cedula=${cedula}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        $("#title_modal").text(
            `Editar al usuario ${data.datos[0].nombre.toUpperCase()} ${data.datos[0].apellido.toUpperCase()}`
        );

        document.getElementById("title_modal").style.fontWeight = "bold";

        $(".select2").select2();
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });

        $("#select_labor_edit")
            .val(data.datos[0].id_labor)
            .trigger("change.select2");

        document.getElementById("selector_rol").value = data.datos[0].rol;

        $("#nombre_form").val(data.datos[0].nombre);
        $("#apellido_form").val(data.datos[0].apellido);
        $("#nombre_emergencia_form").val(data.datos[0].nombre_contacto);
        $("#email_form").val(data.datos[0].email);
        $("#direccion_form").val(data.datos[0].direccion);
        $("#form_num_emergencia").val(data.datos[0].contacto_emergencia);
        $("#my_numero").val(data.datos[0].telefono);
    }
}

async function modifyUser(url) {
    let id = document.getElementById("button_save").dataset.dataId;

    let formdata = document.getElementById("new_form");

    let formu = new FormData(formdata);

    formu.append("cedula", id);

    let jsonObject = {};

    formu.forEach((value, key) => {
        if (key === "new_pass") {
            if (value === "") value = "N/A";
        }
        jsonObject[key] = value;
    });

    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "PUT",

        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },

        body: JSON.stringify(jsonObject),
    });

    let data = await response.json();

    if (data.status) {
        $("#modal_edit").modal("hide");

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $("#table_userss").DataTable({
            responsive: true,
            order: [[9, "desc"]],
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

        Swal.fire({
            title: "¡Excelente!",
            text: "¡¡Excelente el usuario fué modificado de manera exitosa!!",
            icon: "success",
        });
    } else {
        Swal.fire({
            title: "¡UUuups!",
            text: "¡¡El usuario no pudó ser modificado, intentalo nuevamente, si no es posible solucionarlo, remite el inconveniente al departamento de sistemas!!",
            icon: "error",
        });
    }
}

async function deleteUser(url) {
    let cedula = document.getElementById("button_save").dataset.dataId;

    const token = localStorage.getItem("access_token");

    let response = await fetch(`${url}?cedula=${cedula}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        $("#modal_edit").modal("hide");
        Swal.fire({
            title: "¡Excelente!",
            text: "¡¡El usuario fue eliminado de la base de datos!!",
            icon: "success",
        });

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $("#table_userss").DataTable({
            responsive: true,
            order: [[9, "desc"]],
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
    } else {
        Swal.fire({
            title: "¡UUuups!",
            text: "¡¡El usuario no pudó ser eliminado, intentalo nuevamente, si no es posible solucionarlo, remite el inconveniente al departamento de sistemas!!",
            icon: "error",
        });
    }
}

async function logout(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "¡Tu sesión fué cerrada con éxito!",
            showConfirmButton: false,
            timer: 1500,
        });

        localStorage.removeItem("access_token");

        window.location.href = "./";
    }
}

// async function editNamLabor(url) {
//     const token = localStorage.getItem("access_token");

//     let name = document.getElementById("edit_name_labor").value;

//     let id_labor = document.getElementById("select_labor").value;

//     if (id_labor !== "selected" && name.length > 0) {
//         let response = await fetch(url, {
//             method: "PUT",
//             headers: {
//                 "Content-Type": "application/json",
//                 Authorization: `Bearer ${token}`,
//             },

//             body: JSON.stringify({
//                 id_labor: id_labor,
//                 nombre_nuevo: name,
//             }),
//         });

//         let data = await response.json();

//         if (data.status) {
//             let element_container = document.getElementById("container_menu");
//             element_container.innerHTML = data.html;

//             Swal.fire({
//                 title: "¡Excelente!",
//                 text: "¡¡La labor fue modificada correctamente!!",
//                 icon: "success",
//             });
//         } else {
//             Swal.fire({
//                 title: "¡Uuuuups!",
//                 text: "¡¡La labor no pudó ser modificada correctamente, si el error persiste por favor comunicarte con el departamento de sistemas!!",
//                 icon: "error",
//             });
//         }
//     } else {
//         Swal.fire({
//             title: "¡Uuuuups!",
//             text: "¡¡ Error: verifica que si has escrito el nombre al que deseas cambiar ó no has seleccionado la labor que deseas modificar!!",
//             icon: "error",
//         });
//     }
// }

function verifyInputs() {
    let nombre = document.getElementById("nombre");
    let apellido = document.getElementById("apellido");
    let direccion = document.getElementById("direccion");
    let celular_emergencia = document.getElementById("cel_emergencia");
    let password = document.getElementById("password");
    let rol = document.getElementById("rol");
    let labor = document.getElementById("labor");
    let nacimiento = document.getElementById("nacimiento");
    let email = document.getElementById("cedula");
    let celular = document.getElementById("celular");
    let nombre_contacto_emergencia = document.getElementById(
        "contacto_emergencia"
    );
    let cedula = document.getElementById("cedula");

    let data = [
        nombre,
        apellido,
        direccion,
        password,
        rol,
        labor,
        nombre_contacto_emergencia,
        nacimiento,
        email,
        celular_emergencia,
        celular,
        cedula,
    ];

    let results = [];

    let html;

    data.forEach((nodo, index) => {
        let value = nodo.value;

        if (value.length > 0) {
            if (index > 8) {
                let number = parseInt(value);

                if (!isNaN(number)) {
                    results.push(true);
                } else {
                    results.push(false);

                    html = nodo;
                }
            }

            results.push(true);
        } else {
            html = nodo;
        }
    });

    if (html !== undefined) {
        let atribute = html.getAttribute("name");

        Swal.fire({
            title: "¡Uuuuups!",
            text: `¡¡ Error: al parecer el campo de ${atribute} no esta bien diligenciado!!`,
            icon: "error",
        });

        return false;
    } else {
        return true;
    }
}

async function secures(url) {
    const token = localStorage.getItem("access_token");

    let id_user = document.getElementById("id_user_secure").value;
    let state = document.getElementById("estado_secure").value;
    let hour = document.getElementById("hora_secure").value;
    let date = document.getElementById("fecha_secure").value;

    let response = await fetch(url, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            id_user,
            state,
            hour,
            date,
        }),
    });

    let data = await response.json();

    if (data.status) {
        console.log("cambios realizados!");
    }
}

async function getShowChangePassword(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
    }
}

async function changePassword(url) {
    let pass_old = document.getElementById("contraseña_antigua").value;

    let pass_new = document.getElementById("contraseña_nueva").value;

    let pass_new2 = document.getElementById("contraseña_nueva2").value;

    let verificacion = verifyPasswords(pass_new, pass_new2);

    if (verificacion && pass_old.length > 0) {
        const token = localStorage.getItem("access_token");
        let response = await fetch(url, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
                pass_old,
                pass_new,
            }),
        });

        let data = await response.json();

        if (data.status) {
            localStorage.removeItem("access_token");
            window.location.href = "./";
        }
    } else {
        Swal.fire({
            title: "¡Uuuuups!",
            text: `¡¡ parece que las contraseñas no coinciden, o no has escrito la contraseña antigua!!`,
            icon: "error",
        });
    }
}

function verifyPasswords(pass1, pass2) {
    return pass1 === pass2 ? true : false;
}

function showPass(id, id_input) {
    let eye_open = "fa-solid fa-eye color_eye";
    let eye_close = "fa-solid fa-eye-slash color_eye";

    let node = document.getElementById(id);

    let node_children = node.querySelector("i");

    let input = document.getElementById(id_input);

    if (node_children.className === eye_close) {
        node_children.className = eye_open;
        input.setAttribute("type", "password");
    } else if (node_children.className === eye_open) {
        node_children.className = eye_close;
        input.setAttribute("type", "text");
    }
}

// async function getShowNotices(url) {
//     const token = localStorage.getItem("access_token");

//     let response = await fetch(url, {
//         method: "GET",
//         headers: {
//             "Content-Type": "application/json",
//             Authorization: `Bearer ${token}`,
//         },
//     });

//     let data = await response.json();

//     if (data.status) {
//         let element_container = document.getElementById("container_menu");
//         element_container.innerHTML = data.html;
//     }
// }

async function searchRangeAssist() {
    const token = localStorage.getItem("access_token");

    let rango = document.getElementById("rango_fecha").value;

    let convert_date = new Date(rango);

    let fecha_f = convert_date.toLocaleDateString("es-ES", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
    });

    let format_range = fecha_f.replaceAll("/", "-");

    let response = await fetch("../showrangeassists/?rango=" + format_range, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $("#reservationdate").datetimepicker({
            format: "L",
        });
        $("#rango_fecha").val(rango);

        $("#report_table").DataTable({
            responsive: true,
            order: [[7, "desc"]],
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
    }
}

async function getShowSchedules(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        const scripts = element_container.querySelectorAll("script");

        scripts.forEach((script) => {
            eval(script.innerText);
        });
    }
}

function modalSchedule(id, nombre, apellido) {
    let title = document.getElementById("title_modal_schedule");

    let name_lastName = `<i class="fa-solid fa-clock"></i>&nbsp;&nbsp; Añadir horario a <b>${nombre.toUpperCase()} ${apellido.toUpperCase()}</b>`;

    title.innerHTML = name_lastName;

    let button_save_schedule = document.getElementById("button_save_schedule");

    button_save_schedule.dataset.dataId = id;
}

async function insertSchedule(url) {
    let main_option = document.getElementById("select_main");

    if (main_option.value === "selected") {
        Swal.fire({
            title: "¡Uuuuups!",
            text: "¡¡Parece que no seleccionaste ninguna opción en: 'Seleccionar días'!!",
            icon: "error",
        });
    } else if (main_option.value === "individual") {
        let edit_day = document.getElementById("selector_days");

        if (edit_day.value === "selected") {
            Swal.fire({
                title: "¡Uuuuups!",
                text: "¡¡Parece que no seleccionaste ninguna dia!!",
                icon: "error",
            });
        } else {
            let morn1 = document.getElementById("start-morning").value;
            let morn2 = document.getElementById("end-morning").value;

            let afternoon1 = document.getElementById("start-afternoon").value;
            let afternoon2 = document.getElementById("end-afternoon").value;

            let mañana = morn1.toString() + " - " + morn2.toString();

            let tarde = afternoon1.toString() + " - " + afternoon2.toString();

            let total_time = `${mañana}<br>${tarde}`;

            let button_save_schedule = document.getElementById(
                "button_save_schedule"
            );

            let id_user = button_save_schedule.dataset.dataId;

            let selector_days = document.getElementById("selector_days").value;

            let option = "1";

            const token = localStorage.getItem("access_token");
            let response = await fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify({
                    total_time,
                    id_user,
                    dia: selector_days,
                    option,
                    // falta enviar json organizar la ruta en el controldor y hacer la interfaz de horario como sugerencia poner que se puede de lunes a viernes y sabado siempre por aparte
                }),
            });

            let data = await response.json();

            if (data.status) {
                $("#editSchedules").modal("hide");

                let element_container =
                    document.getElementById("container_menu");
                element_container.innerHTML = data.html;

                const scripts = element_container.querySelectorAll("script");

                scripts.forEach((script) => {
                    eval(script.innerText);
                });

                let morn11 = document.getElementById("start-morning");
                let morn22 = document.getElementById("end-morning");

                let afternoon11 = document.getElementById("start-afternoon");
                let afternoon22 = document.getElementById("end-afternoon");

                morn11.value = "";
                morn22.value = "";
                afternoon11.value = "";
                afternoon22.value = "";
            }
        }
    } else {
        const token = localStorage.getItem("access_token");

        let morn1 = document.getElementById("start-morning").value;
        let morn2 = document.getElementById("end-morning").value;

        let button_save_schedule = document.getElementById(
            "button_save_schedule"
        );

        let id_user = button_save_schedule.dataset.dataId;

        let afternoon1 = document.getElementById("start-afternoon").value;
        let afternoon2 = document.getElementById("end-afternoon").value;

        let mañana = morn1.toString() + " - " + morn2.toString();

        let tarde = afternoon1.toString() + " - " + afternoon2.toString();

        let total_time = `${mañana}<br>${tarde}`;

        let option = "2";

        let response = await fetch(url, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
                total_time,
                id_user,
                option,
            }),
        });

        let data = await response.json();

        if (data.status) {
            $("#editSchedules").modal("hide");

            let element_container = document.getElementById("container_menu");
            element_container.innerHTML = data.html;

            const scripts = element_container.querySelectorAll("script");

            scripts.forEach((script) => {
                eval(script.innerText);
            });

            let morn11 = document.getElementById("start-morning");
            let morn22 = document.getElementById("end-morning");

            let afternoon11 = document.getElementById("start-afternoon");
            let afternoon22 = document.getElementById("end-afternoon");

            morn11.value = "";
            morn22.value = "";
            afternoon11.value = "";
            afternoon22.value = "";
        }
    }
}

async function scheduleClear(url) {
    let selector = document.getElementById("select_main");

    if (selector.value === "individual") {
        let selector_days = document.getElementById("selector_days");

        if (selector_days.value !== "selected") {
            let button_save_schedule = document.getElementById(
                "button_save_schedule"
            );

            let id_user = button_save_schedule.dataset.dataId;

            const token = localStorage.getItem("access_token");
            let response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify({
                    dia: selector_days.value,
                    id_user,
                }),
            });

            let data = await response.json();

            if (data.status) {
                $("#editSchedules").modal("hide");

                let element_container =
                    document.getElementById("container_menu");
                element_container.innerHTML = data.html;

                const scripts = element_container.querySelectorAll("script");

                scripts.forEach((script) => {
                    eval(script.innerText);
                });
            }
        } else {
            Swal.fire({
                title: "¡Uuuuups!",
                text: "¡¡Selecciona un día válido!!",
                icon: "error",
            });
        }
    } else {
    }
}

async function deleteClear(url, cedula, dia) {
    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            cedula,
            dia,
        }),
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
        const scripts = element_container.querySelectorAll("script");

        scripts.forEach((script) => {
            eval(script.innerText);
        });
    }
}

async function getShowPayroll(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $("#table_payroll").DataTable({
            // Desactiva la paginación para mostrar todos los nodos
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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
    }
}

async function getHistoryPayRoll(url, cedula) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url + `/?cedula=${cedula}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
    }
}

async function sendPdf(url) {
    let nodes_renderized = verifyNodes();

    let pdfs = collectPayRolls(nodes_renderized);

    const token = localStorage.getItem("access_token");

    let form = new FormData();

    pdfs.forEach((element) => {
        form.append(`user_${element.cedula}`, element.pdf);
    });

    let response = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
        },
        body: form,
    });

    let data = await response.json();

    if (data.status) {
        Swal.fire({
            title: "¡Excelente!",
            text: "¡¡Todas las nominas fuerón cargadas correctamente!!",
            icon: "success",
        });

        limpiar(iterations);
    }

    function limpiar(iterations) {
        for (let i = 0; i < iterations; i++) {
            let elemento = document.getElementById(`input_pdf${i}`);
            elemento.value = "";
        }
    }

    function collectPayRolls(iterations) {
        let array = [];

        for (let i = 0; i < iterations; i++) {
            let elemento = document.getElementById(`input_pdf${i}`);

            if (elemento.files.length > 0) {
                let element = elemento.files[0];
                let data = elemento.dataset.code;

                array.push({
                    cedula: data,
                    pdf: element,
                });
            }
        }

        return array;
    }
}

function verifyNodes() {
    let table = document.getElementById("table_payroll");
    let inputs = table.querySelectorAll("input.input_lenght").length;
}

// function selectAllSubLabors() {
//     let column_subgroups = document.querySelectorAll(
//         `td > div.div_checknox > input[type="checkbox"]:not(:checked)`
//     );

//     column_subgroups.forEach((element) => {
//         element.checked = true;
//     });
// }

async function getShowOverTime(url) {
    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
    }
}

async function requestOverTime(url, self_id) {
    const token = localStorage.getItem("access_token");

    let motivo = document.getElementById("motivo");

    let fecha = document.getElementById("fecha");

    let hora_i = document.getElementById("h_i");

    let hora_f = document.getElementById("h_f");

    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            motivo: motivo.value,
            fecha: fecha.value,
            hora_i: hora_i.value,
            hora_f: hora_f.value,
        }),
    });

    let data = await response.json();

    if (data.status) {
        Swal.fire({
            title: "¡Excelente!",
            text: "¡¡Solicitud enviada correctamente!!",
            icon: "success",
        });

        motivo.value = "";
        fecha.value = "";
        hora_i.value = "";
        hora_f.value = "";

        startChannelPrivate(self_id);
    }
}

async function getShowHistoryOverTime(url) {
    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
    }
}

function openModalState(nombre, apellido, id_notification, id_user, funcion) {
    if (!funcion) {
        $("#modal_state").modal("show");

        let text = document.getElementById("content_modal_state");

        text.innerHTML = `¿Qué deseas hacer para el usuario <b>${nombre} ${apellido}</b>?`;

        text.dataset.dataId = id_notification;

        text.dataset.dataState = id_user;
    }
}

async function changeStateNotification(url, state) {
    let id_notification = document.getElementById("content_modal_state").dataset
        .dataId;

    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "put",
        headers: {
            "Content-type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            state,
            id_notification,
        }),
    });

    let data = await response.json();

    if (data.state) {
        let id_user = document.getElementById("content_modal_state").dataset
            .dataState;
        $("#modal_state").modal("hide");

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
    }
}

async function createProduct(url) {
    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $(".select2").select2();
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });

        const input = document.getElementById("imagen_product");

        input.addEventListener("change", (event) => {
            const file = event.target.files[0];
            let imagePreview = document.getElementById("imagePreview");
            if (file) {
                const reader = new FileReader();

                // Leer el archivo como una URL de datos
                reader.onload = function (e) {
                    imagePreview.src = e.target.result; // Establecer la URL en el atributo src de la imagen
                    imagePreview.style.display = "block"; // Mostrar la imagen
                };

                reader.readAsDataURL(file); // Iniciar la lectura del archivo
            } else {
                // Si no hay archivo, ocultar la previsualización
                imagePreview.style.display = "none";
            }
        });


        const input2 = document.getElementById("edit_imagen_product");

        input2.addEventListener("change", (event) =>{

            const file = event.target.files[0];
            let imagePreview = document.getElementById("imagePreview2");
            if (file) {
                const reader = new FileReader();

                // Leer el archivo como una URL de datos
                reader.onload = function (e) {
                    imagePreview.src = e.target.result; // Establecer la URL en el atributo src de la imagen
                    imagePreview.style.display = "block"; // Mostrar la imagen
                };

                reader.readAsDataURL(file); // Iniciar la lectura del archivo
            } else {
                // Si no hay archivo, ocultar la previsualización
                imagePreview.style.display = "none";
            }

        });

        $("#table_products_total").DataTable({
            // Desactiva la paginación para mostrar todos los nodos
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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


    }
}

function getImagen() {
    const input = document.getElementById("imagen_product");

    const file = input.files[0];
    const formData = new FormData();
    formData.append("image", file);

    return formData;
}

function addItemInventory() {
    let item = document.getElementById("select_item");

    let id_item = item.value;

    if (id_item === "selected") {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "error",
            title: "Selecciona un item válido!",
        });

        return 0;
    }
    let name = item.selectedOptions[0].text;

    let container = document.getElementById("container_tr");

    container.innerHTML += `<tr><th id="selected_item" data-id="${id_item}" class="selected_item">${name}</th>
                           <th><input type="number" step="0.001" class="form-control unidades" id="unidades" placeholder="Ingresa la cantidad de unidades" name="unidades"></th></tr>`;

    $("#select_item").val("selected").trigger("change");
}

function getDataProduct() {
    let collectItem = document.querySelectorAll(".selected_item");

    let collectInputs = document.querySelectorAll(".unidades");

    let data = [];
    let datas = {};

    for (let i = 0; i < collectItem.length; i++) {
        datas = {
            item_inventario: collectItem[i].textContent,
            id_item: collectItem[i].dataset.id,
            input_descuento: collectInputs[i].value,
        };

        data.push(datas);
    }

    return data;
}

async function saveProduct(url) {
    let nombre = document.getElementById("nombre_producto");
    let precio = document.getElementById("precio_producto");
    let dato = getDataProduct();
    let description = document.getElementById("descripcion_textarea");
    // let form_image = getImagen();

    let input = document.getElementById("imagen_product");

    const file = input.files[0];
    let formData = new FormData();
    formData.append("image", file);
    formData.append("nombre", nombre.value);
    formData.append("precio", precio.value);
    formData.append("array", JSON.stringify(dato));
    formData.append("description", description.value);

    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
        },
        body: formData,
    });

    let data = await response.json();

    if (data.status) {
        Swal.fire({
            title: "¡Excelente!",
            text: "¡¡El producto se guardo de manera exitosa!!",
            icon: "success",
        });

        let container_tr = document.getElementById("container_tr");

        container_tr.innerHTML = "";
        nombre.value = "";
        precio.value = "";
        description.value = "";
        input.value = "";
    }
}

async function getShowStore(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        const div_search = document.getElementById("container_search");

        document.addEventListener("click", (event) => {
            if (
                !div_search.contains(event.target) &&
                event.target.id !== "container_search"
            ) {
                div_search.style.display = "none";
            }
        });
    } else {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "error",
            title: "Debes iniciar la asistencia para poder ingresar al panel de venta.!",
        });
    }
}

async function getSearch(url, values) {
    const token = localStorage.getItem("access_token");

    let container_div = document.getElementById("container_search");

    if (values.length > 0) {
        container_div.style.display = "block";
        container_div.style.zIndex = "500";
        container_div.style.position = "absolute";
    } else container_div.style.display = "none";

    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            search_text: values,
        }),
    });

    let data = await response.json();

    if (data.status) {
        container_div.innerHTML = data.html;
    }
}

function lessAndPlus(operator, identifier) {
    let result = document.getElementById(`content_input-${identifier}`);
    let convert_number = +result.value;
    let price = document.getElementById(`button_dataset_${identifier}`);
    let price_convert = parseInt(price.dataset.price.replace(".", ""), 10);
    let price_finally = document.getElementById(`price-${identifier}`);

    if (result.value < 1) {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "error",
            title: "Solo puedes vender minimo 1 unidad en adelante!",
        });
        return 0;
    }

    if (operator === "+") {
        result.value = convert_number + 1;
        price_finally.innerHTML = (
            price_convert *
            (convert_number + 1)
        ).toLocaleString("es");
    } else {
        result.value = convert_number - 1;
        price_finally.innerHTML = (
            price_convert *
            (convert_number - 1)
        ).toLocaleString("es");
    }
}


function deleteUnitsCart(id_nodo, price_product, units){

    let nodo_delete = document.getElementById(`row_product_${id_nodo}`);
    let price_total = document.getElementById("price_total_car");
    let price_format_container = document.getElementById("container_shop");
    let price_convert = (price_total.textContent).replace(/\./g, "");

    let operation_resta = +price_convert - (price_product * units);


    price_format_container.dataset.precio = operation_resta;

    price_total.textContent = operation_resta.toLocaleString("es");

    nodo_delete.remove();
}

function addProductToCar(name, description, identifier, url_image, price_unit) {
    let result = document.getElementById(`content_input-${identifier}`);

    if (result.value < 1) {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "error",
            title: "Solo puedes vender minimo 1 unidad en adelante!",
        });
        return 0;
    }

    let car = document.getElementById("container_shop");
    let amunt = document.getElementById(`content_input-${identifier}`);
    let price_finally = document.getElementById(`price-${identifier}`);
    let convert_price = price_finally.textContent;
    let data_product = `<tr id="row_product_${identifier}" class="row_product" data-date="${identifier}-${
        amunt.value
    }">
                    <th><img src='${url_image}' alt='Imagen pollo' width='60' height='60'></th>
                    <td>${name}</td>
                    <td>${description}</td>
                    <td>${amunt.value}</td>
                    <td><i class='fa-solid fa-dollar-sign text-success'></i>&nbsp;&nbsp;${(+price_unit).toLocaleString("es")}</td>
                    <td><i class='fa-solid fa-dollar-sign text-success'></i>&nbsp;&nbsp;${convert_price.toLocaleString("es")}</td>
                    <td><center><a onclick="deleteUnitsCart('${identifier}','${price_unit}', ${amunt.value})" type='button' title="Eliminar item"><i class="fa-solid fa-xmark text-danger"></i></a></center></td>
                  </tr>`;

    let convert_price_final = parseInt(convert_price.replace(/\./g, ""), 10);

    car.innerHTML += data_product;
    let price_end = parseInt(car.dataset.precio) + convert_price_final;
    car.dataset.precio = price_end;

    let price_car = document.getElementById("price_total_car");

    let precio_final = +car.dataset.precio;
    price_car.innerHTML = precio_final.toLocaleString("es");
    let container_div = document.getElementById("container_search");
    container_div.style.display = "none";
    let searcher = document.getElementById("input_search");
    searcher.value = "";
}

async function sellProducts(url) {
    const token = localStorage.getItem("access_token");

    let convert = convertArray();

    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },

        body: JSON.stringify({
            data: convert,
        }),
    });

    let data = await response.json();

    if (data.status) {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "success",
            title: "Venta realizada con Éxito.!",
        });

        let car = document.getElementById("container_shop");
        let total = document.getElementById("price_total_car");
        let input_search = document.getElementById("input_search");
        let total_cambio = document.getElementById("price_total_car_cambio");
        total_cambio.textContent = 0;
        car.innerHTML = "";
        total.innerHTML = "0";
        input_search.value = "";

        let price = (document.getElementById(
            "container_shop"
        ).dataset.precio = 0);
    }
}

function convertArray() {
    let products = document.querySelectorAll(".row_product");

    let array_producto = [];

    products.forEach((element) => {
        let id_product = element.dataset.date.split("-");

        array_producto.push({
            id_item: id_product[0],
            cantidad: id_product[1],
        });
    });

    return array_producto;
}

async function getShowInventory(url) {
    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $(".select2").select2();
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });

        $("#table_inventory").DataTable({
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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
    }
}

async function createInventory(url) {
    let nombre_producto = document.getElementById("nombre_producto_inventario");
    let unidades = document.getElementById("unidades_inventario");
    let tope_min = document.getElementById("tope_min");
    let precio_costo = document.getElementById("costo");

    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            nombre_producto: nombre_producto.value,
            unidades: unidades.value,
            tope_min: tope_min.value,
            precio_costo: precio_costo.value,
        }),
    });

    let data = await response.json();
    var Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        Toast.fire({
            icon: "success",
            title: "Producto añadido al inventario de manera Satisfactoria.!",
        });

        $("#table_inventory").DataTable({
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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
    } else {
        Toast.fire({
            icon: "error",
            title: "No se pudó guardar el producto en el inmventario, comuniquese con el desarrollador!",
        });
    }
}

async function changeInventory(url) {
    let units = document.getElementById("adicion_unidades");
    let id_item_inventory = document.getElementById("select_item_inventory");
    let price_cost = document.getElementById("price_costo");
    let unit_establishing = document.getElementById("establishing_units");
    let edit_name = document.getElementById("name_edit_inventory");

    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            unidades: units.value,
            id_inventory: id_item_inventory.value,
            precio_costo: price_cost.value,
            nombre_inventario: edit_name.value,
            units_establishing: unit_establishing.value
        }),
    });

    let data = await response.json();

    if (data.status) {
        $("#modal_edit_inventory").modal("hide");

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $(".select2").select2();
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });

        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "success",
            title: "Se actualizó correctamente el item de inventario!",
        });

        $("#table_inventory").DataTable({
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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
    }
}

async function deleteInventory(url) {
    let id_item_inventory = document.getElementById("select_item_inventory");
    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },

        body: JSON.stringify({
            id_item_inventory: id_item_inventory.value,
        }),
    });

    let data = await response.json();

    if (data.status) {
        $("#modal_edit_inventory").modal("hide");

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "success",
            title: "Se eliminó correctamente el item del inventario!",
        });

        $("#table_inventory").DataTable({
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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
    }
}

async function getShowHistorySell(url) {
    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
        $("#history_sell_table").DataTable({
            info: true,
            responsive: true,
            // order: [[7, "desc"]],
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

        $("#history_sell_table_unit").DataTable({
            // Desactiva la paginación para mostrar todos los nodos
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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
    }
}

async function searchRange(url) {
    let fecha = document.getElementById("reservationdate");
    let aux = fecha.value;

    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            fecha: fecha.value,
        }),
    });

    let data = await response.json();

    if (data.status) {
        let element_container = document.getElementById("container_menu");

        element_container.innerHTML = data.html;

        $("#history_sell_table").DataTable({
            info: true,
            responsive: true,
            order: [[7, "desc"]],
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

        $("#history_sell_table_unit").DataTable({
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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
        
        let new_date = document.getElementById("reservationdate");
        new_date.value = aux;
    }
}

function emptyCart() {
    let cart = document.getElementById("container_shop");
    let price_car = document.getElementById("price_total_car");
    let total_cambio = document.getElementById("price_total_car_cambio");
    cart.innerHTML = "";
    price_car.innerHTML = 0;
    cart.dataset.precio = 0;
    total_cambio.textContent = 0;
}

async function modifyItemCompound(url){

    let span = document.getElementById("span_id");
    let item_compound = span.dataset.id;

    let edit_decription = document.getElementById("edit_description");
    let modify_cost = document.getElementById("edit_price");
    let image = document.getElementById("edit_imagen_product");
    let edit_name = document.getElementById("edit_name");
    const file = image.files[0];
    let form = new FormData(); /// aca

    form.append("id_item_compund", item_compound);
    form.append("edit_description", edit_decription.value);
    form.append("modify_cost", modify_cost.value);
    form.append("name", edit_name.value);
    form.append("image", file);

    const token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "POST",
        headers:{
            Authorization: `Bearer ${token}`,
        },
        body: form

    });

    let data = await response.json();


    if (data.status){

        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 6000,
        });

        Toast.fire({
            icon: "success",
            title: data.message,
        });

        modify_cost.value = "";
        image.value = "";
        let imagePreview = document.getElementById("imagePreview2");
        edit_name.value = "";
        imagePreview.src = "";

        $("#modal_info").modal("hide");
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $("#table_products_total").DataTable({
            // Desactiva la paginación para mostrar todos los nodos
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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

    }

}

async function deleteProductSeller(url){

    let span = document.getElementById("span_id");
    let id_item = span.dataset.id;

    const token = localStorage.getItem("access_token");
    let response = await fetch(url,{

        method: "POST",
        headers: {

            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify({

            id_item: id_item

        })

    });


    let data = await response.json();


    if(data.status){

        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 6000,
        });

        Toast.fire({
            icon: "success",
            title: "Se eliminó satisfactoriamente el producto de venta!",
        });
        $("#modal_info").modal("hide");
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        $("#table_products_total").DataTable({
            // Desactiva la paginación para mostrar todos los nodos
            info: true,
            responsive: true,
            order: [[0, "asc"]],
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
    }
}


function change(){

    let price_car = document.getElementById("price_total_car");

    let price_total = price_car.textContent;

    let price_convert = price_total.replace(/\./g, '');

    let int_price = +price_convert;

    let change = document.getElementById("cambio").value

    let less = +change - int_price;

    let total_cambio = document.getElementById("price_total_car_cambio");

    total_cambio.textContent = less.toLocaleString("es-ES");


    $("#modal_cambio").modal("hide");


}
async function getShowEmployeeFood(url){

    const token = localStorage.getItem("access_token");
    let response = await fetch(url,{
        method: "GET",
        headers:{

            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        }
    });


    let data = await response.json();


    if(data.status){

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
        $(".select2").select2();
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });

    }

}

async function discountFoodEmployee(url){

    let id_item_sell = document.getElementById("select_item_sell");
    let name_employee = document.getElementById("name_employee");
    let units = document.getElementById("units_employee");

    const token = localStorage.getItem("access_token");
    let response = await fetch(url,{
        method: "POST",
        headers:{

            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify({

            id_item: id_item_sell.value,
            name_employee: name_employee.value,
            units: units.value


        })
    });


    let data = await response.json();


    if(data.status){

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
        $(".select2").select2();
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });


    }


}

async function openModalInfo(id_item, info_tittle, url){

    

    let titulo_modal = document.getElementById("titulo_modal");

    let span = document.getElementById("span_id");

    span.dataset.id = id_item;

    titulo_modal.innerHTML = "información de producto de venta "+info_tittle;


    let token = localStorage.getItem("access_token");

    let response = await fetch(url,{

        method: "POST",
        headers:{

            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify({

            id_item: id_item
        })
    });

    let data =   await response.json();

    let text = "Informacion de la cantidad de productos asociados a "+info_tittle.toUpperCase();

    if(data.status){


        let body_table = document.getElementById("tbody_id");
        let productos_compuestos = data.producto;
        

        span.innerText = text;


        productos_compuestos.forEach((item) =>{

            body_table.innerHTML = `<td><center>${item.nombre_compuesto}</center></td>
            <td><center>${item.descuento}</center></td>`

        });

        $("#modal_info").modal("show");
    }

}