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
            <div class="table-responsive">

                <table class="table" id="history_sell_table">
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

                        @php
                            $flagg = 1;
                        @endphp

                        @foreach ($historial as $item)
                            <tr>
                                <th scope="row">{{ $flagg }}</th>
                                <td>{{ $item['nombre_producto_venta'] }}</td>
                                <td>{{ $item['descripcion_producto_venta'] }}</td>
                                <td>{{ $item['unidades_venta'] }}</td>
                                <td>{{ $item['nombre_cajero'] }}</td>
                                <td>{{ $item['id_user_cajero'] }}</td>
                                <td>{{ $item['hora'] }}</td>
                                <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{number_format($item['total_venta'], 0, '', '.')}} </td>
                            </tr>

                            @php
                                $flagg++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="row p-5">

                <div class="col-sm"><h3>Total vendido:</h3></div>
                <div class="col-sm d-flex justify-content-end"><h3><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{number_format($total, 0, '', '.')}}</h3></div>
            </div>
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
