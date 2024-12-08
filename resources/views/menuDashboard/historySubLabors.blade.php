<div class="container-fluid">

    <div class="card card-primary">
        <div class="card-header" style="background-color: #0f318f">
            <h3 class="card-title"><i class="fa-solid fa-list"></i>&nbsp;&nbsp;Historial de sub labores</h3>
        </div>
        <div class="card-body">


            <div class="form-group mb-5">
                <div class="d-flex row">

                    <div class="col-md-4">
                        <label>Búsqueda por rango de fechas:</label>

                        <div class="input-group mb-2">



                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation" autocomplete="off">
                            <button class="btn btn-primary ml-2 "
                                onclick="searchForRange('{{ route('searchForRange') }}')"><i
                                    class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Buscar rango</button>
                        </div>
                    </div>
                    <div class="col-md-7">


                        <div class="input-group sub_labors" style="margin-top: 32px">


                            <select class="form-control select2 select2-danger" style="width: 40%; height: 28px;"
                                data-dropdown-css-class="select2-danger" id="labor_select">
                                <option selected="selected">Seleccionar sub labor</option>

                                @foreach ($labores as $labor)
                                    <option value="{{ $labor['nombre_sub_labor'] }}">
                                        {{ $labor['nombre_sub_labor'] }}
                                    </option>
                                @endforeach
                            </select>


                            <button class="btn btn-info ml-2 " onclick="searcherText('{{ route('searchText') }}')"><i
                                    class="fa-solid fa-magnifying-glass"></i>&nbsp;Nombre Labor</button>
                        </div>









                    </div>


                </div>

                <table class="table table-striped" id="history_table_searcher">
                    <thead class="thead-dark">

                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Sub labor</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Estado</th>
                        </tr>

                    </thead>
                    <tbody>

                        @foreach ($historial as $item)
                            <tr>
                                <td>{{ $item['nombre_user'] }}</td>
                                <td>{{ $item['apellido'] }}</td>
                                <td>{{ $item['sub_labor'] }}</td>
                                <td>{{ $item['hora'] }}</td>
                                <td>{{ $item['fecha'] }}</td>
                                <td>
                                    @php
                                        $badge = '';

                                        switch ($item['estado']) {
                                            case 'REALIZADO':
                                                $badge = 'success';
                                                break;

                                            case 'PENDIENTE':
                                                $badge = 'warning';
                                                break;

                                            case 'NO REALIZADO':
                                                $badge = 'danger';
                                                break;

                                            default:
                                                $badge = 'Unknown status';
                                                break;
                                        }

                                    @endphp
                                    <span class="badge badge-{{ $badge }}">{{ $item['estado'] }} </span>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>

    </div>
