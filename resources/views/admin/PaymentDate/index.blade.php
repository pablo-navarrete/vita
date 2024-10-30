@extends('layouts.app')

@section('title')
    Fecha de Pagos
@endsection

@section('css_before')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

@endsection

@section('content')
<div class="container">
    <div class="row mt-2 mb-3 me-2 ms-2">
        <div class="col-10">
            <h3 class="">Fecha de Pagos</h3>
        </div>
        <div class="col-2 text-end">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPaymentDateModal">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-list"></i>
            <h5 class="ms-2 mt-2">{{ __('Listado de Fechas de pago') }}</h5>
        </div>

        <div class="card-body">
            <table id="paymentDate-table" class="table table-striped table-bordered table-hover table-rounded">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Día de pago de cada mes</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                   
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createPaymentDateModal" tabindex="-1" aria-labelledby="createPaymentDateModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPaymentDateModalLabel">Agregar Fecha de Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerpaymentDateForm">
                        @csrf
                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Día de Pago de cada mes</label>
                            <input type="number" class="form-control" id="payment_date" name="payment_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_after')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#paymentDate-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('paymentDate.data') }}', // Asegúrate de definir esta ruta en tus rutas
    columns: [
        { data: 'id', name: 'id' },
        { data: 'payment_date', name: 'payment_date' },
        {
            data: 'status',
            name: 'status',
            render: function (data) {
                return data == 0
                    ? '<button class="btn btn-secondary btn-sm">Inactivo</button>'
                    : '<button class="btn btn-success btn-sm">Activo</button>'; // Cambia el color o texto según sea necesario
            }
        },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});


        $('#registerpaymentDateForm').on('submit', function(e) {
            console.log("Formulario enviado");
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('paymentDate.store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#createPaymentDateModal').modal('hide');
                    $('#registerpaymentDateForm')[0].reset(); // Limpiar el formulario
                    // Recargar el DataTable
                    $('#paymentDate-table').DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Día agregado exitosamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                },
                error: function(error) {
                    console.error(error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un error al agregar.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });
    });
</script>
@endsection
