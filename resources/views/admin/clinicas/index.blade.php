@extends('layouts.app')

@section('title')
    Clínicas
@endsection

@section('css_before')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .contenedor{
            margin-top: 80px;
        }
     
        .card {
            overflow: hidden; /* Evita que el contenido se desborde */
        }

        .card-header {
            padding: 1rem; /* Asegúrate de que el padding no cause desbordamiento */
        }

        .card-body {
            padding: 1rem; /* Ajusta según sea necesario */
        }
    </style>
@endsection

@section('content')
    <div class="container contenedor">
        <div class="row mt-2 mb-3 me-2 ms-2">
            <div class="col-10">
                <h3 class="">Clínicas</h3>
            </div>
            <div class="col-2 text-end">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#createClinicaModal">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center row no-margin-row">
                <div class="col-10">
                    
                    <h5 class="ms-2 mt-2">{{ __('Listado de Clínicas') }}</h5>
                </div>
               <div class="col-2">
                Día de Pago: {{ $paymentDate->payment_date }} de cada mes

               </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="m-2">
                        <table id="clinicas-table" class="table table-striped table-bordered table-hover table-rounded">
                            <thead class="text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Titular</th>
                                    <th>Dominio</th>
                                    <th>Estado</th>
                                    <th>Estado pago</th>
                                    <th>Mes gratis</th>
                                    <th>Servicio</th>
                                    <th>Fecha Actualizado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- Aquí va el contenido dinámico de la tabla -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Modal crear clínica-->
        <div class="modal fade" id="createClinicaModal" tabindex="-1" aria-labelledby="createClinicaModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createClinicaModalLabel">Agregar Clínica</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="registerClinicaForm">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="titular" class="form-label">Titular</label>
                                        <input type="text" class="form-control" id="titular" name="titular" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="servicio" class="form-label">Servicio</label>
                                        <select class="form-select" id="servicio" name="servicio" required>
                                            <option value="1">Básico</option>
                                            <option value="2">Estándar</option>
                                            <option value="3">Premium</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mes_gratis" class="form-label">Mes gratis</label>
                                        <select class="form-select" id="mes_gratis" name="mes_gratis" required>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Estado</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                          
                          

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Agregar</button>

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal editar clínica-->
         <div class="modal fade" id="EditClinicaModal" tabindex="-1" aria-labelledby="editClinicaModalLabel"
         aria-hidden="true" data-bs-backdrop="static">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="editClinicaModalLabel">Editar Clínica</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form id="editClinicaForm">
                         @csrf

                         <input type="hidden" id="clinicaId" name="clinica_id">

                         <div class="row">
                             <div class="col-6">
                                 <div class="mb-3">
                                     <label for="nombre" class="form-label">Nombre</label>
                                     <input type="text" class="form-control" id="nombre" name="nombre" required>
                                 </div>
                                 <div class="mb-3">
                                     <label for="titular" class="form-label">Titular</label>
                                     <input type="text" class="form-control" id="titular" name="titular" required>
                                 </div>
                                 <div class="mb-3">
                                     <label for="direccion" class="form-label">Dirección</label>
                                     <input type="text" class="form-control" id="direccion" name="direccion" required>
                                 </div>
                                 <div class="mb-3">
                                     <label for="telefono" class="form-label">Teléfono</label>
                                     <input type="text" class="form-control" id="telefono" name="telefono" required>
                                 </div>
                                 <div class="mb-3">
                                     <label for="email" class="form-label">Email</label>
                                     <input type="email" class="form-control" id="email" name="email" required>
                                 </div>
                             </div>
                             <div class="col-6">
                                 <div class="mb-3">
                                     <label for="servicio" class="form-label">Servicio</label>
                                     <select class="form-select" id="servicio" name="servicio" required>
                                         <option value="1">Básico</option>
                                         <option value="2">Estándar</option>
                                         <option value="3">Premium</option>
                                     </select>
                                 </div>
                                 <div class="mb-3">
                                     <label for="mes_gratis" class="form-label">Mes gratis</label>
                                     <select class="form-select" id="mes_gratis" name="mes_gratis" required>
                                         <option value="1">Sí</option>
                                         <option value="0">No</option>
                                     </select>
                                 </div>
                                 <div class="mb-3">
                                     <label for="status" class="form-label">Estado</label>
                                     <select class="form-select" id="status" name="status" required>
                                         <option value="1">Activo</option>
                                         <option value="0">Inactivo</option>
                                     </select>
                                 </div>
                             </div>

                         </div>
                       
                       

                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Actualizar</button>

                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                         </div>
                     </form>
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
                    ¿Está seguro de que desea eliminar este registro?, 
                    recuerde que debe esperar 1 mes para poder eliminar el registro con todos sus datos.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

             <!-- Modal ver clínica-->
             <div class="modal fade" id="VerClinicaModal" tabindex="-1" aria-labelledby="verClinicaModalLabel"
             aria-hidden="true" data-bs-backdrop="static">
             <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="verClinicaModalLabel">Detalles Clínica</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
    
                             <div class="row">
                                 <div class="col-6">
                                     <div class="mb-3">
                                         <label for="nombre" class="form-label">Nombre</label>
                                         <input type="text" class="form-control" id="nombre" name="nombre" disabled>
                                     </div>
                                     <div class="mb-3">
                                         <label for="titular" class="form-label">Titular</label>
                                         <input type="text" class="form-control" id="titular" name="titular" disabled>
                                     </div>
                                     <div class="mb-3">
                                         <label for="direccion" class="form-label">Dirección</label>
                                         <textarea class="form-control" name="direccion" id="direccion" cols="30" rows="5" disabled></textarea>
                                     </div>
                                     <div class="mb-3">
                                         <label for="telefono" class="form-label">Teléfono</label>
                                         <input type="text" class="form-control" id="telefono" name="telefono" disabled>
                                     </div>
                                     <div class="mb-3">
                                         <label for="email" class="form-label">Email</label>
                                         <input type="email" class="form-control" id="email" name="email" disabled>
                                     </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="mb-3">
                                        <label for="domain" class="form-label">Dominio</label>
                                        <input type="text" class="form-control" id="domain" name="domain" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Servicio</label>
                                        <div><button id="servicio" style="pointer-events: none;"></button></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Mes gratis</label>
                                        <div><button id="mes_gratis"style="pointer-events: none;"></button></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Estado</label>
                                        <div><button id="status" style="pointer-events: none;"></button></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Estado Pago</label>
                                        <div><button id="estado_pago" style="pointer-events: none;"></button></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updated_at" class="form-label">Fecha Activo/Inactivo</label>
                                        <input type="text" class="form-control" id="updated_at" name="updated_at" disabled>
                                    </div>
                                </div>
                                
    
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
            $('#clinicas-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('clinicas.data') }}', 
                columns: [
                    {
                        data: null, 
                        name: 'id',
                        render: function (data, type, row, meta) {
                            // El índice secuencial se calcula usando la información de la paginación
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'titular',
                        name: 'titular'
                    },
                  
                  
                    {
                        data: 'domain',
                        name: 'domain'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            var buttonClass = data == 1 ? 'btn-success' : 'btn-secondary';
                            var buttonText = data == 1 ? 'Activo' : 'Inactivo';
                            var action = data == 1 ? 'desactivar' : 'activar';
                            return `<div class="d-flex justify-content-center">
                                <button class="btn ${buttonClass} btn-sm change-status" data-id="${row.id}" data-status="${data}">${buttonText}</button>
                            </div>`;
                        }
                    },
                    {
                        data: 'estado_pago',
                        name: 'estado_pago',
                        render: function(data, type, row) {
                            var buttonClass = data == 1 ? 'btn-primary' : 'btn-danger';
                            var buttonText = data == 1 ? 'Pagado' : 'Pendiente';
                            return `<div class="d-flex justify-content-center">
                                <button class="btn ${buttonClass} btn-sm change-status-pago" data-id="${row.id}" data-status="${data}">${buttonText}</button>
                            </div>`;
                        }
                    },

                    {
                        data: 'mes_gratis',
                        name: 'mes_gratis',
                        render: function(data, type, row) {
                            var buttonClass = data == 1 ? 'btn-success' : 'btn-secondary';
                            var buttonText = data == 1 ? 'Sí' : 'No';
                            return `<div class="d-flex justify-content-center">
                                <button class="btn ${buttonClass} btn-sm change-status-mes" data-id="${row.id}" data-status="${data}">${buttonText}</button>
                            </div>`;
                        }
                    },
                    {
                        data: 'servicio',
                        name: 'servicio',
                        render: function(data) {
                            if (data == 1) {
                                return '<span class="btn btn-info btn-sm">Básico</span>';
                            } else if (data == 2) {
                                return '<button class="btn btn-success btn-sm">Estandar</button>';
                            } else if (data == 3) {
                                return '<button class="btn btn-warning btn-sm">Premium</button>';
                            }
                            return '<span class="btn btn-secondary btn-sm">Sin definir</span>'; // Por si acaso el valor no es 1, 2 o 3
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function (data, type, row) {
                            var date = new Date(data); // Convertir el string a objeto Date
                            var day = ('0' + date.getDate()).slice(-2); // Obtener el día con dos dígitos
                            var month = ('0' + (date.getMonth() + 1)).slice(-2); // Obtener el mes con dos dígitos
                            var year = date.getFullYear(); // Obtener el año
                            // Retornar en formato dd/mm/yyyy
                            return day + '/' + month + '/' + year;
                        }
                    },

                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <div class="dropdown text-center">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="http://${row.domain}/login" target="__blanc" data-id="${row.id}"><i class="fa-solid fa-lock"></i> Acceder</a></li>
                                    <li><a class="dropdown-item verClinica" href="#" data-id="${row.id}" data-bs-toggle="modal"
                                        data-bs-target="#VerClinicaModal"><i class="fa-solid fa-eye"></i> Ver</a></li>
                                    <li><a class="dropdown-item editClinica" href="#" data-id="${row.id}" data-bs-toggle="modal"
                                        data-bs-target="#EditClinicaModal" ><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
                                    <li><a class="dropdown-item delete-btn" href="#" data-id="${row.id}"><i class="fa-solid fa-trash-can"></i> Eliminar</a></li>

                                </ul>
                            </div>`;
                        },
                        orderable: false,
                        searchable: false
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


            $('#registerClinicaForm').on('submit', function(e) {
                console.log("Formulario enviado");
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('clinica.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $('#createClinicaModal').modal('hide');
                        $('#registerClinicaForm')[0].reset(); // Limpiar el formulario
                        $('#clinicas-table').DataTable().ajax.reload();
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Clínica agregada exitosamente.',
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

             // Evento click en el botón de editar
            $('#clinicas-table').on('click', '.editClinica', function() {
                var clinicaId = $(this).data('id');

                // Realiza una solicitud AJAX para obtener los datos de la clínica
                $.ajax({
                    url: '/clinicas/' + clinicaId + '/edit',  // Cambia esto según tu ruta para obtener los datos
                    type: 'GET',
                    success: function(data) {
                        // Asigna los datos obtenidos a los campos del modal de edición
                        $('#EditClinicaModal #nombre').val(data.nombre);
                        $('#EditClinicaModal #titular').val(data.titular);
                        $('#EditClinicaModal #direccion').val(data.direccion);
                        $('#EditClinicaModal #telefono').val(data.telefono);
                        $('#EditClinicaModal #email').val(data.email);
                        $('#EditClinicaModal #servicio').val(data.servicio);
                        $('#EditClinicaModal #status').val(data.status);
                        $('#EditClinicaModal #mes_gratis').val(data.mes_gratis);
                        $('#EditClinicaModal #clinicaId').val(clinicaId);

                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo cargar la información de la clínica.', 'error');
                    }
                });
            });

            $('#editClinicaForm').on('submit', function(event) {
                event.preventDefault(); // Prevenir el envío normal del formulario

                // Obtener el ID de la clínica (esto debe venir de algún lugar, por ejemplo, una variable o un atributo data)
                let clinicaId = $('#clinicaId').val(); // Asegúrate de tener el ID correcto aquí

                // Obtener los datos del formulario
                let formData = $(this).serialize();

                // Hacer la solicitud AJAX al servidor
                $.ajax({
                    url: '/clinicas/' + clinicaId, // Concatenar el ID de la clínica en la URL
                    method: 'PUT', // O 'PATCH' si prefieres
                    data: formData,
                    success: function(response) {
                        if (response.message) {
                          
                            // Cerrar el modal
                            $('#EditClinicaModal').modal('hide');
                            $('#clinicas-table').DataTable().ajax.reload();
                            Swal.fire({
                                title: '¡Éxito!',
                                text: 'Clínica agregada exitosamente.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                          
                        }
                    },
                    error: function(xhr) {
                        console.error(error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error al agregar.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });                    }
                });
            });

            // Evento click en el botón de eliminar
            $('#clinicas-table').on('click', '.delete-btn', function() {
            
                var id = $(this).data('id');

                // Establecer el ID del registro a eliminar
                $('#confirm-delete').data('id', id);

                // Mostrar el modal de confirmación de eliminación
                $('#deleteModal').modal('show');
            
            });

            // Manejar la confirmación de eliminación
            $('#confirm-delete').on('click', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('clinicas.destroy', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        $('#clinicas-table').DataTable().ajax.reload();
                            Swal.fire({
                                title: '¡Éxito!',
                                text: 'Clínica eliminada exitosamente.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error al eliminar el registro.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });

            // Manejar el clic en el botón de cambio de estado
            $('#clinicas-table').on('click', '.change-status', function() {
                var id = $(this).data('id');
                var currentStatus = $(this).data('status');
                var newStatus = currentStatus == 1 ? 0 : 1;
                var newButtonClass = newStatus == 1 ? 'btn-success' : 'btn-danger';
                var newButtonText = newStatus == 1 ? 'Activo' : 'Inactivo';

                $.ajax({
                    url: '{{ route('clinicas.updateStatus', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        $('#clinicas-table').DataTable().ajax.reload();
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Estado actualizado exitosamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error al actualizar el estado.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });

            // Manejar el clic en el botón de cambio de estado de pago
            $('#clinicas-table').on('click', '.change-status-pago', function() {
                var id = $(this).data('id');
                var currentStatus = $(this).data('status'); // Asegúrate de usar 'data-status' aquí
                var newStatus = currentStatus == 1 ? 0 : 1; // Alternar entre 0 y 1
                var newButtonClass = newStatus == 1 ? 'btn-success' : 'btn-danger';
                var newButtonText = newStatus == 1 ? 'Pagado' : 'Pendiente';

                $.ajax({
                    url: '{{ route('clinicas.updateStatusPago', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        estado_pago: newStatus // Aquí debe ser 'estado_pago'
                    },
                    success: function(response) {
                        $('#clinicas-table').DataTable().ajax.reload();
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Estado actualizado exitosamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error al actualizar el estado.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });

            // Manejar el clic en el botón de cambio de estado de pago
            $('#clinicas-table').on('click', '.change-status-mes', function() {
                var id = $(this).data('id');
                var currentStatus = $(this).data('status'); // Asegúrate de usar 'data-status' aquí
                var newStatus = currentStatus == 1 ? 0 : 1; // Alternar entre 0 y 1
                var newButtonClass = newStatus == 1 ? 'btn-success' : 'btn-secondary';
                var newButtonText = newStatus == 1 ? 'Sí' : 'No';

                $.ajax({
                    url: '{{ route('clinicas.updateStatusMes', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        mes_gratis: newStatus // Aquí debe ser 'estado_pago'
                    },
                    success: function(response) {
                        $('#clinicas-table').DataTable().ajax.reload();
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Mes actualizado exitosamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error al actualizar el Mes.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });

              // Evento click en el botón de ver
              $('#clinicas-table').on('click', '.verClinica', function() {
                var clinicaId = $(this).data('id');

                // Realiza una solicitud AJAX para obtener los datos de la clínica
                $.ajax({
                    url: '/clinicas/' + clinicaId + '/ver',  // Cambia esto según tu ruta para obtener los datos
                    type: 'GET',
                    success: function(data) {
                        // Asigna los datos obtenidos a los campos del modal de edición
                        $('#VerClinicaModal #nombre').val(data.nombre);
                        $('#VerClinicaModal #titular').val(data.titular);
                        $('#VerClinicaModal #direccion').val(data.direccion);
                        $('#VerClinicaModal #telefono').val(data.telefono);
                        $('#VerClinicaModal #email').val(data.email);
                        $('#VerClinicaModal #domain').val(data.domain);
                          // Formatear la fecha antes de asignarla
                        var fechaOriginal = new Date(data.updated_at);
                        var dia = String(fechaOriginal.getDate()).padStart(2, '0');
                        var mes = String(fechaOriginal.getMonth() + 1).padStart(2, '0'); // Los meses empiezan desde 0
                        var anio = fechaOriginal.getFullYear();
                        var horas = String(fechaOriginal.getHours()).padStart(2, '0');
                        var minutos = String(fechaOriginal.getMinutes()).padStart(2, '0');
                        var segundos = String(fechaOriginal.getSeconds()).padStart(2, '0');

                        var fechaFormateada = `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
                        $('#VerClinicaModal #updated_at').val(fechaFormateada);
                          // Servicio
                        var servicioSpan = $('#VerClinicaModal #servicio');
                            servicioSpan.text(data.servicio);
                            servicioSpan.removeClass();  // Elimina clases anteriores
                            if (data.servicio === 3) {
                                servicioSpan.text('Premium');
                                servicioSpan.addClass('btn btn-warning btn-sm');  
                            } else if (data.servicio === 2) {
                                servicioSpan.text('Estandar');
                                servicioSpan.addClass('btn btn-success btn-sm');  
                            } else if (data.servicio === 1) {
                                servicioSpan.text('Básico');
                                servicioSpan.addClass('btn btn-info btn-sm');  
                            } 

                        // Estado
                        var statusSpan = $('#VerClinicaModal #status');
                            statusSpan.removeClass();  // Elimina clases anteriores
                            if (data.status === 1) {
                                statusSpan.text('Activo');
                                statusSpan.addClass('btn btn-success btn-sm');  
                            } else if (data.status === 0) {
                                statusSpan.text('Inactivo');
                                statusSpan.addClass('btn btn-secondary btn-sm');  
                            }

                        // mes gratis
                        var mes_gratisSpan = $('#VerClinicaModal #mes_gratis');
                            mes_gratisSpan.removeClass();  // Elimina clases anteriores
                            if (data.mes_gratis === 1) {
                                mes_gratisSpan.text('Sí');
                                mes_gratisSpan.addClass('btn btn-success btn-sm'); 
                            } else if (data.mes_gratis === 0) {
                                mes_gratisSpan.text('No');
                                mes_gratisSpan.addClass('btn btn-secondary btn-sm');  
                            }

                        // estado pago
                        var estado_pagoSpan = $('#VerClinicaModal #estado_pago');
                            estado_pagoSpan.removeClass();  // Elimina clases anteriores
                            if (data.estado_pago === 1) {
                                estado_pagoSpan.text('Pagado');
                                estado_pagoSpan.addClass('btn btn-primary btn-sm'); 
                            } else if (data.estado_pago === 0) {
                                estado_pagoSpan.text('Pendiente');
                                estado_pagoSpan.addClass('btn btn-danger btn-sm');  
                            }


                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo cargar la información de la clínica.', 'error');
                    }
                });
            });
        });
    </script>
@endsection
