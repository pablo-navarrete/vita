@extends('layouts.menuTenant')
@section('title')
    Listado de pacientes
@endsection

@section('css_before')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>



    </style>
@endsection
@section('content')
    <div class="container">

        <h3 class="mb-5 mt-3">Gestión de Citas Médicas</h3>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header row mx-0" >
                    <div class="col-md-10">
                        <h5 class="mt-3">{{ __('Listado de Citas Médicas') }}</h5>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('tenant.cita.index') }}" class="btn btn-primary mt-2">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body" >
                    <div class="">
                        <div class="m-2">

                            <table id="cita-table" class="table  table-bordered table-hover table-rounded">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha Cita</th>
                                        <th>RUT</th>
                                        <th>Nombre</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Médico</th>
                                        <th>Estado</th>
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
<br>
<br>
<br>


   

   
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
         

            var table = $('#cita-table').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('tenant.cita.data') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'fecha',
                        name: 'fecha',
                        render: function(data, type, row) {
                            // Verificar si hay datos en fecha
                            if (data) {
                                const date = new Date(data); // Crear un objeto de fecha
                                // Obtener componentes de la fecha
                                const day = String(date.getDate()).padStart(2, '0');
                                const month = String(date.getMonth() + 1).padStart(2,
                                    '0'); // Los meses comienzan en 0
                                const year = String(date.getFullYear()); // Obtener últimos 2 dígitos del año
                                const hours = String(date.getHours()).padStart(2, '0');
                                const minutes = String(date.getMinutes()).padStart(2, '0');
                                // Retornar la fecha formateada
                                return `${day}/${month}/${year} ${hours}:${minutes}`;
                            }
                            return ''; // Retornar cadena vacía si no hay datos
                        }
                    },
                    {
                        data: 'paciente.rut',
                        name: 'paciente.rut'
                    },
                    {
                        data: 'paciente.nombre',
                        name: 'paciente.nombre'
                    },
                    {
                        data: 'paciente.apellido_pat',
                        name: 'paciente.apellido_pat'
                    },
                    {
                        data: 'paciente.apellido_mat',
                        name: 'paciente.apellido_mat'
                    },
                    {
                        data: 'paciente.telefono',
                        name: 'paciente.telefono'
                    },
                    {
                        data: 'paciente.email',
                        name: 'paciente.email'
                    },
                    {
                        data: 'medico.nombre',
                        name: 'medico.nombre',
                        render: function(data, type, row) {
                            // Verificar si existen nombre y apellido en los datos
                            const nombre = row.medico?.nombre || ''; // Verificar si existe medico.nombre
                            const apellido = row.medico?.apellido_pat || ''; // Verificar si existe medico.apellido
                            // Concatenar nombre y apellido
                            return `${nombre} ${apellido}`.trim(); // .trim() para eliminar espacios en blanco extra
                        }
                    },
                    {
                        data: 'estado',
                        name: 'estado',
                        render: function(data, type, row) {
                            let estadoTexto = '';
                            let estadoClase = '';

                            switch (data) {
                                case 'pendiente':
                                    estadoTexto = 'Pendiente';
                                    estadoClase = 'btn-warning btn-sm'; // Color amarillo para pendiente
                                    break;
                                case 'Confirmada':
                                    estadoTexto = 'Confirmada';
                                    estadoClase = 'btn-success btn-sm'; // Color verde para confirmada
                                    break;
                                case 'Cancelada':
                                    estadoTexto = 'Cancelada';
                                    estadoClase = 'btn-danger btn-sm'; // Color rojo para cancelada
                                    break;
                                case 'Terminada':
                                    estadoTexto = 'Terminada';
                                    estadoClase = 'btn-primary btn-sm'; // Color azul para terminada
                                    break;
                                default:
                                    estadoTexto = 'Desconocido';
                                    estadoClase = 'btn-secondary btn-sm'; // Color gris para estados desconocidos
                            }

                            // Retorna el span con la clase de color y el texto
                            return `<span class="btn ${estadoClase}">${estadoTexto}</span>`;
                        }
                    },

                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {   
                           
                            
                            return `
                        <div class="dropdown text-center">
                            <button class="btn btn-light border border-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Opciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#" data-id="${row.id}" class="details-btn"><i class="fa-solid fa-eye"></i> Ver Detalles</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}"   class="print-btn" data-bs-toggle="modal" data-bs-target="#historialMedicoModal"><i class="fa-solid fa-file"></i> Historial Médico</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}" class="reschedule-btn"><i class="fa-solid fa-calendar-alt"></i> Agregar Cita</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}"><i class="fa-solid fa-stethoscope"></i> Agregar Pre-consulta</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}"><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}"><i class="fa-solid fa-trash-can"></i> Eliminar</a></li>
                            </ul>
                        </div>`;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
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
                        'form-select form-select-sm'
                    ); // Agrega clases Bootstrap al select del paginador

                }
            });

         
        

        });
    </script>
@endsection
