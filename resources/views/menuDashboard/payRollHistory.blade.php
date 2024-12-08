<div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i
                    class="fa-solid fa-dollar-sign"></i>&nbsp;&nbsp;Nomina {{ $nombre }} {{ $apellido }}</h3>
            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            @if ($rol === "administrador")
                
            <a type="button" onclick="getShowPayroll('{{route('getshowpayroll')}}')"><i class="fa-solid fa-arrow-left text-danger"></i>&nbsp;&nbsp;Regresar</a>
            @endif

            <center>
                <h3>Historial de nomina</h3>
            </center>

            <hr>
            <div class="table-responsive">

                <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col"><center>Fecha</center></th>
                        <th scope="col"><center>PDF</center></th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ($history as $item)

                        @php
                            $name_archive = $item['url'];
                            $rename = str_replace("storage/nominas/", "",$name_archive);
                        @endphp

                        <tr>
                          <td><center><span style="font-size: 20px;">{{ $item['fecha']}}</span></center></td>
                          <td><center><a href="{{$item['url']}}" target="_blank" title="Descargar nomina de {{ $item['fecha']}}"><i class="fa-solid fa-file-pdf text-danger" style="font-size: 40px;"></i></a></center></td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                  </table>

            </div>

            <hr>

        </div>

    </div>
</div>
