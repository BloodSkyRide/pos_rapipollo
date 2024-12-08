<div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Administrador de labores</h3>
            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="card card-primary">
                <div class="card-header" style="background-color: #0f318f">
                    <h3 class="card-title">Crear labor y sub labores</h3>
                </div>

                <div class="card-body">

                    <div class="row">


                        <div class="col-sm">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre Labor:</label>
                                <div class="input-group input-group">
                                    <input type="text" class="form-control" placeholder="Nombre grupo de labores..." autocomplete="off"
                                        id="name_labor">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat"
                                            onclick="createLabor('{{ route('insertlabor') }}')"><i
                                                class="fa-solid fa-plus"></i>&nbsp;&nbsp;Añadir</button>
                                    </span>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre sub labor:</label>
                                <div class="input-group input-group">
                                    <input type="text" class="form-control" placeholder="Nombre sub labor..." autocomplete="off"
                                        id="item_labor">
                                    <span class="input-group-append">
                                        <button onclick="addSubLabors()" type="button" class="btn btn-info btn-flat"><i
                                                class="fa-solid fa-plus"></i>&nbsp;&nbsp;Añadir</button>
                                    </span>
                                </div>

                            </div>


                            <div class="form-group">
                                <label for="edit_name_labor">Editar Nombre de labor:</label>
                                <div class="input-group input-group">
                                    <input type="text" class="form-control" placeholder="Editar nombre de labor..." name="edit_name_labor" autocomplete="off"
                                        id="edit_name_labor">
                                    <span class="input-group-append">
                                        <button onclick="editNamLabor('{{route('editLabor')}}')" type="button" class="btn btn-info btn-flat"><i
                                                class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;Editar</button>
                                    </span>
                                </div>

                            </div>




                        </div>

                        <div class="col-sm">

                            <div class="form-group">
                                <label for="select_labor">Seleccionar labor:</label>
                                <select class="form-control select2 select2-danger"
                                    data-dropdown-css-class="select2-danger" style="width: 100%;" id="select_labor">
                                    <option selected="selected" value="selected">Seleccionar labor</option>

                                    @foreach ($labores as $labor)
                                        <option value="{{ $labor['id_labor'] }}">{{ $labor['nombre_labor'] }}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="card card-info success card-outline" style="height: 160px">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-edit"></i>

                                        Sub labor a añadir
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="trash d-flex justify-content-end"><a type="button"
                                            onclick="deleteSubLaborsDashborad()" title="Borrar todo."><i
                                                class="fa-solid fa-trash"
                                                style="color: rgb(177, 14, 14); position: absolute;"></i></a></div>

                                    <div id="add_labors"></div>

                                </div>
                            </div>
                            <center> <button class="btn btn-success"
                                    onclick="sendSubLabors('{{ route('insertSubLabor') }}')"><i
                                        class="fa-solid fa-folder-plus"></i>&nbsp;&nbsp;asignar sub labores</button>
                            </center>
                        </div>
                    </div>

                </div>
                <hr>
                <center>
                    <h2>Administrador de labores</h2>
                </center>

                <div>

                    <button class="btn btn-danger m-2" onclick="delteSubLaborTable('{{ route('Deletes') }}')"><i
                            class="fa-solid fa-trash">&nbsp;&nbsp;</i>Eliminar sub labores</button>

                    <button class="btn btn-info m-2" onclick="rechargeSubLabors('{{ route('rechargeSubLabors') }}')"><i
                            class="fa-solid fa-arrows-rotate"></i>&nbsp;&nbsp;Renovar Sub Labores</button>

                    <button class="btn btn-warning m-2" data-toggle="modal" data-target="#modal_confirm"><i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;Recoger labores</button>

                    
                    <button class="btn btn-primary" onclick="selectAllSubLabors()"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Seleccionar todo</button>

                </div>

                <div class="mt-4">


                    <div class="table-responsive">
                        <table class="table table-striped" id="table_labors">
                            <thead class="table"
                                style="background-color: #0f318f; color: white; border-color: none!important">
                                <tr>
                                    <th scope="col">#</th>
    
                                    <th scope="col">Nombre labor</th>
    
                                    <th scope="col">Grupo Labores</th>
    
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $bandera = 1;
                                @endphp
                                <tr>
    
                                    @foreach ($labores as $labor)
                                        <th scope="row">#{{ $bandera }}</th>
                                        @php
                                            $bandera++;
                                        @endphp
    
                                        <td>{{ $labor['nombre_labor'] }}</td>
    
    
                                        <td>
    
                                            @php
                                                $flag = 0;
                                            @endphp
    
                                            @foreach ($sublabores as $sublabor)
                                                @if ($labor['id_labor'] === $sublabor['id_labor'])
                                                    <div class="div_checknox custom-control custom-checkbox">
                                                        <input class="custom-control-input custom-control-input-danger"
                                                            type="checkbox" id="customCheckbox{{ $flag }}"
                                                            value="{{ $sublabor['id_sub_labor'] }}">
                                                        <label
                                                            for="customCheckbox{{ $flag }}"class="custom-control-label">{{ $sublabor['nombre_sub_labor'] }}</label>
                                                    </div>
                                                @endif
                                                @php
                                                    $flag++;
                                                @endphp
                                            @endforeach
    
    
                                        </td>
                                </tr>
                                @endforeach
    
                            </tbody>
                        </table>
                    </div>


                </div>
                <!-- /.row -->

                <!-- /.card-body -->
                <div class="card-footer">
                    Mypantalla todos los derechos reservados © 2024
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_confirm">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg bg-info">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;Seguro de recoger las sub labores no realizadas?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¡Recuerda que para realizar esta operación es porque los colaboradores ya no van a laborar mas en el día de hoy!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cerrar</button>
                    <button type="button" class="btn btn-info" onclick="collectSubLabors('{{route('collectSubLabors')}}')"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Confirmar</button>
                </div>
            </div>
        </div>
    </div>


</div>
