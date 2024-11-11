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

        <h3 class="mb-5 mt-3">Gestión de Pacientes</h3>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header row mx-0" >
                    <div class="col-md-10">
                        <h5 class="mt-3">{{ __('Listado de Pacientes') }}</h5>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('tenant.paciente.create') }}" class="btn btn-primary mt-2">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body" >
                    <div class="">
                        <div class="m-2">

                            <table id="paciente-table" class="table  table-bordered table-hover table-rounded">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>RUT</th>
                                        <th>Nombre</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Fecha Ingreso</th>
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


    <!-- Modal historial medico-->
    <div class="modal fade" id="historialMedicoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="historialMedicoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="historialMedicoForm">
                    <div class="modal-header" >
                        <h5 class="modal-title" id="historialMedicoModalLabel">Historial Médico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" >
                        <!-- Campo oculto para el id del paciente -->
                        <input type="hidden" id="id_paciente" name="id_paciente" value="">
                        <div class="mb-3">
                            <label for="alergias" class="form-label">Alergias</label>
                            <input type="text" class="form-control" id="alergias" name="alergias" required>
                        </div>
                        <div class="mb-3">
                            <label for="antecedentes_medicos" class="form-label">Antecedentes médicos</label>
                            <input type="text" class="form-control" id="antecedentes_medicos" name="antecedentes_medicos"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="antecedentes_familiares" class="form-label">Antecedentes familiares</label>
                            <input type="text" class="form-control" id="antecedentes_familiares"
                                name="antecedentes_familiares" required>
                        </div>
                        <div class="mb-3">
                            <label for="medicamentos_actuales" class="form-label">Medicamentos actuales</label>
                            <input type="text" class="form-control" id="medicamentos_actuales"
                                name="medicamentos_actuales" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
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
            const detallesUrl = "{{ route('tenant.paciente.show', ':id') }}"; 
            const preconsultaUrl = "{{ route('tenant.preconsulta.create', ':id') }}"; 
            const editUrl = "{{ route('tenant.paciente.edit', ':id') }}"; 

            var table = $('#paciente-table').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('tenant.paciente.data') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'rut',
                        name: 'rut'
                    },
                    {
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'apellido_pat',
                        name: 'apellido_pat'
                    },
                    {
                        data: 'apellido_mat',
                        name: 'apellido_mat'
                    },
                    {
                        data: 'telefono',
                        name: 'telefono'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            // Verificar si hay datos en created_at
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
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {   
                            const detallesLink = detallesUrl.replace(':id', row.id); // Reemplaza el marcador de posición con el ID real
                            const preconsultaLink = preconsultaUrl.replace(':id', row.id);
                            const editLink = editUrl.replace(':id', row.id);

                            
                            return `
                        <div class="dropdown text-center">
                            <button class="btn btn-light border border-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Opciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="${detallesLink}" data-id="${row.id}" class="details-btn"><i class="fa-solid fa-eye"></i> Ver Detalles</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}" data-nombre="${row.nombre}" data-apellido="${row.apellido_pat}" class="print-btn" data-bs-toggle="modal" data-bs-target="#historialMedicoModal"><i class="fa-solid fa-file"></i> Historial Médico</a></li>
                                <li><a class="dropdown-item" href="#" data-id="${row.id}" class="reschedule-btn"><i class="fa-solid fa-calendar-alt"></i> Agregar Cita</a></li>
                                <li><a class="dropdown-item" href="${preconsultaLink}" data-id="${row.id}"><i class="fa-solid fa-stethoscope"></i> Agregar Pre-consulta</a></li>
                                <li><a class="dropdown-item" href="${editLink}" data-id="${row.id}"><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
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

            $('#historialMedicoModal').on('show.bs.modal', function(event) {
                // Obtener el botón que abrió el modal
                var button = $(event.relatedTarget); // Botón que activó el modal
                var idPaciente = button.data('id'); // ID del paciente
                // Obtener el nombre del paciente del atributo data-nombre
                var nombrePaciente = button.data('nombre');
                var apellidoPat = button.data('apellido');
                // Actualizar el campo oculto con el ID del paciente
                var modal = $(this);
                modal.find('.modal-title').text('Historial Médico de ' + nombrePaciente + ' ' +
                apellidoPat);
                modal.find('#id_paciente').val(idPaciente);

                // Realizar una solicitud AJAX para obtener el historial clínico
                $.ajax({
                    url: '/historial-clinico/' + idPaciente, // URL de la ruta que retorna los datos
                    method: 'GET',
                    success: function(data) {
                        if (data) {
                            // Si hay datos, llenamos los campos del formulario
                            modal.find('#alergias').val(data.alergias);
                            modal.find('#antecedentes_medicos').val(data.antecedentes_medicos);
                            modal.find('#antecedentes_familiares').val(data
                                .antecedentes_familiares);
                            modal.find('#medicamentos_actuales').val(data
                                .medicamentos_actuales);
                        } else {
                            // Si no hay datos, limpiar los campos
                            modal.find('#alergias').val('');
                            modal.find('#antecedentes_medicos').val('');
                            modal.find('#antecedentes_familiares').val('');
                            modal.find('#medicamentos_actuales').val('');
                        }
                    },
                    error: function() {
                        // Manejar el error en caso de que la solicitud falle
                        alert('Error al obtener los datos del historial clínico.');
                    }
                });
            });




            $('#historialMedicoForm').on('submit', function(event) {
                event.preventDefault(); // Evitar el envío normal del formulario

                // Obtener los datos del formulario
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('historial.medico.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Manejar la respuesta exitosa
                        // Muestra un mensaje de éxito
                        $('#historialMedicoModal').modal('hide'); // Cerrar el modal
                        $('#historialMedicoForm')[0].reset();
                        Swal.fire({
                            title: 'Éxito!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }); // Reiniciar el formulario
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

        

        });
    </script>
@endsection
