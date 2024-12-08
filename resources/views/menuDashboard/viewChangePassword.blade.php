<div class="container-fluid">

    <div class="card card-primary">
        <div class="card-header" style="background-color: #0f318f">
            <h3 class="card-title"><i class="fa-solid fa-key"></i>&nbsp;&nbsp;Cambiar mi contraseña</h3>
        </div>
        <div class="card-body">

            <div class="form-group">
                <label for="nombre_form">Contraseña Antigua:</label>
                <div class="d-flex">
                    <input type="password" class="form-control" id="contraseña_antigua"
                        placeholder="contraseña antigua..." name="contraseña_antigua" autocomplete="off"> 
                        <a type="button" class="m-2 color_eye" onclick="showPass(this.id, 'contraseña_antigua')" id="showpass1">

                        <i class="fa-solid fa-eye color_eye"></i>

                    </a>
                </div>

            </div>


            <div class="form-group">
                <label for="nombre_form">Contraseña nueva:</label>
                <div class="d-flex">
                    <input type="password" class="form-control" id="contraseña_nueva"
                        placeholder="contraseña nueva..." name="contraseña_nueva" autocomplete="off"> 
                        <a type="button" class="m-2" onclick="showPass(this.id, 'contraseña_nueva')" id="showpass2">

                        <i class="fa-solid fa-eye color_eye"></i>

                    </a>
                </div>

            </div>


            <div class="form-group">
                <label for="nombre_form">Repetir contraseña nueva:</label>
                <div class="d-flex">
                    <input type="password" class="form-control" id="contraseña_nueva2"
                        placeholder="Repetir contraseña..." name="contraseña_nueva2" autocomplete="off"> 
                        <a type="button" class="m-2" onclick="showPass(this.id, 'contraseña_nueva2')" id="showpass3">

                        <i class="fa-solid fa-eye color_eye"></i>

                    </a>
                </div>

            </div>

            <center><button class="btn btn-info mt-3" onclick="changePassword('{{ route('changePassword') }}')"><i
                        class="fa-solid fa-arrows-rotate"></i>&nbsp;&nbsp;Cambiar contraseña</button></center>

        </div>

    </div>

</div>
