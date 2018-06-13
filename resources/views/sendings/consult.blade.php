@extends('adminlte::layouts.auth')

@section('htmlheader_title')
Consultar Tracking.
@endsection

@section('content')
<body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box">
            <div class="login-logo">
                <img class="center-block" src="/img/skyimportglobal.png">
            </div><!-- /.login-logo -->

            <div class="login-box-body">
                <p class="login-box-msg">Ingresa el número de consolidado a consultar.</p>
                <form>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Número de consolidado" name="consolidated"/>
                        <span class="fa fa-location-arrow form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-offset-7 col-xs-5">
                            <button type="submit" class="btn btn-block btn-flat btn-primary"><span class="fa fa-sign-in"></span> Consultar</button>
                        </div><!-- /.col -->
                    </div>
                </form>

                <a href="{{ url('/') }}">Iniciar Sesión.</a><br>
                <a href="{{ url('/password/reset') }}">{{ trans('adminlte_lang::message.forgotpassword') }}</a><br>
                @if(env('REGISTRATION_OPEN'))
                <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>
                @endif

            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->
    </div>

    <div class="modal fade" id="modal-send-show" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-aqua">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="exampleModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">Datos del consolidado:</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="records" class="table table-striped table-bordered table-hover table-condensed">
                                    <tbody>
                                        <tr>
                                            <th class="col-md-3">Consolidado:</th>
                                            <td class="col-md-3" id="number"></td>
                                            <th class="col-md-3">Usuario:</th>
                                            <td class="col-md-3" id="user"></td>
                                        </tr>
                                        <tr>
                                            <th>Fecha de creacion:</th>
                                            <td class="" id="created_date"></td>
                                            <th>Fecha de cierre:</th>
                                            <td class="" id="closed_date"></td>
                                        </tr>
                                        <tr>
                                            <th>Estado:</th>
                                            <td id="state" class=""></td>
                                            <th>Cantidad de trackings:</th>
                                            <td class="" id="cant"></td>
                                        </tr>
                                        <tr>
                                            <th>Valor total declarado:</th>
                                            <td class="" id="value"></td>
                                            <th>Peso total:</th>
                                            <td class="" id="weight"></td>
                                        </tr>
                                        <tr>
                                            <th>Total de la orden de servicio:</th>
                                            <td class="" id="bill"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">Eventos:</h4>
                        </div>
                        <div class="box-body">
                            <div class=" col-md-12 table-responsive">
                                <table id="table-edit-formalized" class="table table-striped table-bordered table-hover table-condensed" consolidated="">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Actividad</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @include('adminlte::layouts.partials.scripts_auth')

</body>

<script src="{{ url ('/plugins/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/plugins/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script>
    let path = $('meta[name=url]')[0].content;
    let token = $('meta[name=csrf-token]')[0].content;
    function number_format(amount, decimals) {
        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
        decimals = decimals || 0; // por si la variable no fue fue pasada
        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0) 
            return parseFloat(0).toFixed(decimals);
        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);
        var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;
        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');
        return amount_parts.join(',');
    }
    let translateTable = {
        sProcessing: 'Procesando...',
        sLengthMenu: 'Mostrar _MENU_ registros',
        sZeroRecords: 'No se encontraron resultados',
        sEmptyTable: 'Ningún dato disponible en esta tabla',
        sInfo: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
        sInfoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
        sInfoFiltered: '(filtrado de un total de _MAX_ registros)',
        sInfoPostFix: '',
        sSearch: 'Buscar:',
        sUrl: '',
        sInfoThousands: ',',
        sLoadingRecords: 'Cargando...',
        oPaginate: {
            sFirst: 'Primero',
            sLast: 'Último',
            sNext: 'Siguiente',
            sPrevious: 'Anterior'
        },
        oAria: {
            sSortAscending: ': Activar para ordenar la columna de manera ascendente',
            sSortDescending: ': Activar para ordenar la columna de manera descendente'
        }
    };
    var eventsTable = $('table#table-edit-formalized').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        responsive: true,
        render: true,
        language: translateTable,
        ajax: {
            url: path + 'events',
            data: function (d) {
                d.consolidated_id = function () {
                    let num = $('table#table-edit-formalized').attr('consolidated');
                    if (num > 0) {
                        return num;
                    } else {
                        return null;
                    }
                }
            },
            complete: function () {
                let tr = $('table#table-edit-formalized tr');
                for (var i = 0; i <= tr.length; i++) {
                    let t = tr[i];
                    let td = $(t).children('td');
                    let text = $(td[2]).text();
                    $(td[2]).html(text);
                }
            }
        },
        order: [[2, 'DESC']],
        columns: [
        {data: 'fecha', name: 'created_at', orderable: false, searchable: false},
        {data: 'hora', name: 'created_at', orderable: false, searchable: false},
        {data: 'evento', name: 'event_id', orderable: false, searchable: false},
        ]
    });
    $('form').submit(function (e) {
        e.preventDefault();
        let consolidated = $('input[name="consolidated"]').val();
        if (! consolidated) {
            toastr.info('Debe agregar el número del consolidated.');
            return;
        }
        let url = path + 'consultar-consolidado';
        $.post(url, { consolidated: consolidated, _token: token }, function (response) {
            if (response.mgs) {
                toastr.info(response.mgs);
                return;
            }
            $('table#table-edit-formalized').attr('consolidated', response.id);
            let modal = $('div#modal-send-show');
            modal.find('.modal-title').html('<span class="fa fa-cube"></span> Consolidado n° ' + response.number);
            modal.find('td#number').text(response.number);
            modal.find('td#user').text(response.user.name + ' ' + response.user.last_name);
            modal.find('td#created_date').text(response.open);
            modal.find('td#closed_date').text(response.close);
            modal.find('td#state').html(response.event);
            modal.find('td#cant').text(response.trackings.length);
            modal.find('td#value').text(new Intl.NumberFormat("de-DE", {style: "currency", currency: "USD"}).format(response.sum_total));
            if (response.bill > 0) {
                modal.find('td#bill').text(number_format(response.bill, 2) + ' COP').addClass('success');
                modal.find('td#weight').text(number_format(response.weight, 2) + ' Lb').addClass('success');
            } else {
                modal.find('td#bill').removeClass('success').text(response.bill);
                modal.find('td#weight').removeClass('success').text(response.weight);
            }
            eventsTable.draw();
            modal.modal('toggle');
        });
    });
</script>
@endsection