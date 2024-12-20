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
                <div class="d-flex justify-content-end"><a onclick="emptyCart()" type="button" title="Vaciar carrito"><i class="fa-solid fa-trash text-danger"></i></a></div>
            </center>
            <hr>


            <div class="table-responsive">


              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Representación</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Precio/unidad</th>
                    <th scope="col">Precio</th>
                  </tr>
                </thead>
                <tbody id="container_shop" data-precio="0">
                </tbody>
              </table>

            </div>

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
</div>