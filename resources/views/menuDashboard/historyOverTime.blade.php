<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i class="fa-solid fa-list"></i>&nbsp;&nbsp;Historial de solicitudes</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <hr>

            <center>
                <h4 class="text-secondary">Historial de solicitudes de horas extras</h4>
            </center>
            <hr>

            <div class="table-responsive">

                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Hora Solicitud</th>
                        <th scope="col">Fecha Solicitud</th>
                        <th scope="col">Fecha a laborar</th>
                        <th scope="col">Hora inicio</th>
                        <th scope="col">Hora fin</th>
                        <th scope="col">Motivo</th>
                        <th scope="col">Estado</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ($notifications as $notification)

                        <tr>
                            <th scope="row">{{$notification["id_user"]}}</th>
                            <td>{{$notification["nombre"]}}</td>
                            <td>{{$notification["apellido"]}}</td>
                            <td>{{$notification["hora_solicitud"]}}</td>
                            <td>{{$notification["fecha_solicitud"]}}</td>
                            <td>{{$notification["fecha_notificacion"]}}</td>
                            <td>{{$notification["hora_inicio"]}}</td>
                            <td>{{$notification["hora_final"]}}</td>
                            <td>{{$notification["motivo"]}}</td>


                            @php
                                $span = "";

                                if($notification["estado"] === "Pendiente") $span = "badge badge-warning";
                                elseif($notification["estado"] === "Aceptado") $span = "badge badge-success";
                                else $span = "badge badge-danger";

                                $function = ($notification["estado"] === "Pendiente") ? false : true;
                            @endphp

                            <td><a type="button" data-toggle="modal" onclick="openModalState(`{{$notification['nombre']}}`, `{{$notification['apellido']}}`, `{{$notification['id_notificacion']}}`, `{{$notification['id_user']}}`, `{{$function}}`)"><span class="{{$span}}">{{$notification["estado"]}}</span></a></td>
                          </tr>
                          <tr>
                            
                        @endforeach

                    </tbody>
                  </table>
                  
            </div>

        </div>



    </div>

    <!-- Modal -->
<div class="modal fade" id="modal_state" tabindex="-1" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Solicitud de hora extra</h5>
          <button type="button" class="close" data-dismiss="modal" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="content_modal_state">
        </div>
        <div class="modal-footer">
          <button type="button" onclick="changeStateNotification('{{route('changeStateOverTime')}}', 'Rechazar')" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Rechazar</button>
          <button type="button" onclick="changeStateNotification('{{route('changeStateOverTime')}}', 'Aceptar')" class="btn btn-success"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>