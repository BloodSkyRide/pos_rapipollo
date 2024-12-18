
@foreach ($productos as $producto)
<div class="row">
    <div class="col-sm-1">
      <img src="https://olimpica.vtexassets.com/arquivos/ids/715678-800-auto?v=637756088913630000&width=800&height=auto&aspect=true" alt="Imagen pollo" width="60" height="60">
    </div>
    <div class="col-sm-6">
      <div >
        <div class="d-flex align-items-center">
          <label for="" class="mt-2 d-block">&nbsp;&nbsp;{{$producto['nombre_producto']}}:</label>
          <span class="mr-4 mt-1">&nbsp;&nbsp;Pollo asado + 4 papas + 4 arepas + 1 gaseosa litro y medio.</span>
        </div>

        <div><label for="">&nbsp;&nbsp;Precio:</label> <span><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span id="price-{{$producto['id_producto']}}">{{$producto['precio']}}</span></span></div>
      </div>
    </div>
    <div class="col-sm d-flex align-items-center">
      <button id="button_dataset_{{$producto['id_producto']}}" data-price="{{$producto['precio']}}" onclick="lessAndPlus('-','{{$producto['id_producto']}}')" class="btn btn-danger mr-2"><i class="fa-solid fa-minus"></i></button><input type="text" id="content_input-{{$producto['id_producto']}}" class="form-control input_info"  value="1"><button onclick="lessAndPlus('+','{{$producto['id_producto']}}')" class="btn btn-success ml-2"><i class="fa-solid fa-plus"></i></button><br>
      <button class="btn btn-success ml-2" onclick="addProductToCar('{{$producto['nombre_producto']}}','4 papa + 4 arepas','{{$producto['id_producto']}}')"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Añadir producto</button>
    </div>

</div>
@endforeach

