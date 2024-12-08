<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i class="fa-solid fa-list"></i>&nbsp;&nbsp;Historial de solicitudes</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <hr>

            <center>
                <h4 class="text-secondary">Crear productos</h4>
            </center>
            <hr>

            
            <div class="row">
                {{-- COLUMNA 1 --}}

                <div class="col">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" placeholder="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" placeholder="apellido"
                            name="apellido">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Direccion:</label>
                        <input type="text" class="form-control" id="direccion" placeholder="Dirección"
                            name="direccion">
                    </div>

                    <div class="form-group">
                        <label for="cel_emergencia">Celular Emergencia:</label>
                        <input type="text" class="form-control" id="cel_emergencia" placeholder="Celular emergencia"
                            name="contacto_emergencia">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" placeholder="Contraseña"
                            name="password">
                    </div>

                    <div class="form-group">
                        <label for="rol">Tipo de Usuario:</label>
                        <select class="form-control" name="rol" id="rol">
                            <option value="administrador">Administrador</option>
                            <option value="usuario">usuario</option>
                        </select>
                    </div>
                </div>

                {{-- COLUMNA 2 --}}
                <div class="col">

                    <div class="form-group">
                        <label for="labor">Tipo de labor:</label>


                        <select class="form-control" id="labor" name="labor">
                            @foreach ($labores as $labor)
                                <option value="{{ $labor['id_labor'] }}">{{ $labor['nombre_labor'] }}</option>
                            @endforeach
                        </select>

                    </div>


                    <div class="form-group">
                        <label for="nacimiento">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" id="nacimiento" name="nacimiento"
                            placeholder="Fecha de nacimiento.">
                    </div>


                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" id="email" placeholder="E-mail" name="email">
                    </div>

                    <div class="form-group">
                        <label for="cedula">Cédula:</label>
                        <input type="text" class="form-control" id="cedula" placeholder="Cédula" name="cedula">
                    </div>


                    <div class="form-group">
                        <label for="celular">Celular:</label>
                        <input type="text" class="form-control" id="celular" placeholder="Celular" name="celular">
                    </div>

                    <div class="form-group">
                        <label for="contacto_emergencia">Nombre Contacto de Emergencia:</label>
                        <input type="text" class="form-control" id="contacto_emergencia" name="nombre_contacto"
                            placeholder="Nombre Emergencia">
                    </div>
                </div>
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