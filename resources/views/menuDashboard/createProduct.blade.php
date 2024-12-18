<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i class="fa-solid fa-list"></i>&nbsp;&nbsp;Crear productos</h3>
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
                        <label for="nombre">Nombre producto:</label>
                        <input type="text" class="form-control" id="nombre_producto" placeholder="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="unidades">Precio producto:</label>
                        <input type="number" step="0.001" class="form-control" id="precio_producto" placeholder="Ingresa la cantidad de unidades"
                            name="unidades">
                    </div>


                    <div class="form-group">
                        <label for="imagen">Imagen representativa:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                    </div>
                </div>

                {{-- COLUMNA 2 --}}
                <div class="col">

                    <div class="row">

                        <div class="col-md-9">

                            <div class="form-group">
                                <label for="select_item">Seleccionar items  inventario:</label>
                                <select class="form-control select2 select2-danger"
                                    data-dropdown-css-class="select2-danger" style="width: 100%;" id="select_item">
                                    <option selected="selected" value="selected">Seleccionar item</option>
        
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto['id_item'] }}">{{ $producto['nombre'] }}</option>
                                    @endforeach
        
                                </select>
        
                            </div>

                        </div>

                        <div class="col-md">

                            <button class="btn btn-primary" onclick="addItemInventory()" style="margin-top: 31px"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Añadir item</button>
                        </div>

                    </div>

                    <table class="table">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">item</th>
                            <th scope="col">Descuento</th>
                          </tr>
                        </thead>
                        <tbody id="container_tr">

                        </tbody>
                      </table>

                </div>
            </div>

            <center><button class="btn btn-primary" onclick="saveProduct('{{route('saveProduct')}}')"><i class="fa-solid fa-square-plus"></i>&nbsp;&nbsp;Crear producto de Venta</button></center>
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