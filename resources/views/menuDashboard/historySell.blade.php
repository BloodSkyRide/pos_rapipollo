<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i
                    class="fa-solid fa-list"></i>&nbsp;&nbsp;Crear productos</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <hr>

            <center>
                <h4 class="text-secondary">Historial de ventas </h4>
            </center>
            <hr>

            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Descripción Producto</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Cajero Responsable</th>
                    <th scope="col">Cédula</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Total venta</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                </tbody>
              </table>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_state" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Solicitud de hora extra</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="content_modal_state">
                </div>
                <div class="modal-footer">
                    <button type="button"
                        onclick="changeStateNotification('{{ route('changeStateOverTime') }}', 'Rechazar')"
                        class="btn btn-danger" data-dismiss="modal"><i
                            class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Rechazar</button>
                    <button type="button"
                        onclick="changeStateNotification('{{ route('changeStateOverTime') }}', 'Aceptar')"
                        class="btn btn-success"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
