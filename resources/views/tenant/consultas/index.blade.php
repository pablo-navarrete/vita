@extends('layouts.menuTenant')
@section('css_before')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>


       
    </style>
@endsection
@section('content')
    <div class="container">
       
        <h3 class="mb-5 mt-3">Gestión de Pacientes</h3>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header row mx-0">
                    <div class="col-md-10">
                        <h5 class="mt-3">{{ __('Listado de Consultas') }}</h5>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('tenant.banner.create') }}" class="btn btn-primary mt-2" >
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="">
                        <div class="m-2">

                            <table id="consultas-table" class="table table-striped table-bordered table-hover table-rounded">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Paciente</th>
                                        <th>Rut</th>
                                        <th>Médico</th>
                                        <th>Motivo de Consulta</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de Consulta</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                      
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar este registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Eliminar</button>
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
   
    // Configurar el token CSRF globalmente para todas las solicitudes AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var table = $('#consultas-table').DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route('tenant.consultas.data') }}',
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { 
                data: null, 
                name: 'paciente', 
                render: function(data, type, row) {
                    return `${row.paciente.nombre} ${row.paciente.apellido_pat}`; // Nombre y apellido del paciente
                }
            },
            { data: 'paciente.rut', name: 'paciente.rut' },
            { 
                data: null, 
                name: 'medico', 
                render: function(data, type, row) {
                    return `${row.medico.nombre} ${row.medico.apellido_pat}`; // Nombre y apellido del médico
                }
            },
       
            { data: 'motivo_consulta', name: 'motivo_consulta' },
            { data: 'observaciones', name: 'observaciones' },
            { data: 'created_at', name: 'created_at' },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="dropdown text-center">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Opciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#" data-id="${row.id}" class="details-btn"><i class="fa-solid fa-eye"></i> Ver Detalles</a></li>
                                <li><a class="dropdown-item btn-primary edit-btn" href="#" data-id="${row.id}"><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
                                <li><a class="dropdown-item btn-danger delete-btn" href="#" data-id="${row.id}"><i class="fa-solid fa-trash-can"></i> Eliminar</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}" class="print-btn"><i class="fa-solid fa-print"></i> Imprimir</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}" class="reschedule-btn"><i class="fa-solid fa-calendar-alt"></i> Reprogramar</a></li>
                            </ul>
                        </div>`;
                }
            }
        ],
        language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "No hay datos disponibles en la tabla",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
           // Aplicar clases de Bootstrap a la paginación y al buscador
           initComplete: function() {
                    $('.dataTables_filter input').addClass(
                    'form-control form-control-sm'); // Agrega clases Bootstrap al input de búsqueda
                    $('.dataTables_length select').addClass(
                    'form-select form-select-sm'); // Agrega clases Bootstrap al select del paginador
                 
                }
    });


});

</script>
@endsection
