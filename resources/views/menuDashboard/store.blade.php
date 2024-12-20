<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Vender productos</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <hr>

            <div class="input-group mb-2">
              <input type="search" autocomplete="off" class="form-control form-control-lg" onkeyup="getSearch('{{route('searcher')}}', this.value)" placeholder="Buscar producto de venta..." id="input_search">
              <div class="input-group-append">
                  <button type="submit" class="btn btn-lg btn-default">
                      <i class="fa fa-search"></i>
                  </button>
              </div>
          </div>
          <div id="container_search" class="product_search mt-1" ></div>

            <center>
                <h4 class="text-secondary"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Carrito de productos</h4>
            </center>
            <hr>


            
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Representación</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Precio</th>
                  </tr>
                </thead>
                <tbody id="container_shop" data-precio="0">
                </tbody>
              </table>
              
              <div class="p-5">

                <div class="row">
                  <div class="col-sm "><div class="d-flex"><h3>Total:</h3></div></div>
                  <div class="col-sm d-flex justify-content-end"><h3><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span id="price_total_car">0</span></h3></div>
                </div>
              </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-success mr-2" onclick="sellProducts('{{route('sell')}}')"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Vender productos</button>
            <button class="btn btn-info" onclick="saveProduct('{{route('saveProduct')}}')"><i class="fa-solid fa-print"></i>&nbsp;&nbsp;Vender/Imprimir Recibo</button>
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