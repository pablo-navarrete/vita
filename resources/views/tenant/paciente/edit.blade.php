@extends('layouts.menuTenant')
@section('title')
    Editar paciente
@endsection

@section('css_before')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>

        .miga{
            text-decoration: none; 
            color:gray;
        }

        .miga:hover{
            color: rgb(21, 146, 242);;
        }
       
    </style>
@endsection
@section('content')
    <div class="container ">
       <div class="row ">
            <div class="col-8">
                <h3 class="mb-4 mt-3">Editar Paciente</h3>
            </div>
            <div class="col-4 text-end mt-4">
              <a href="{{ route('tenant.paciente.index') }}" class="miga">Listado de Pacientes</a> / <span style="color: rgb(21, 146, 242);">Editar Paciente</span>
             </div>
       </div>
        
        
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header row mx-0" style="background-color: rgb(192, 233, 250);">
                    <div class="col-md-10">
                        <h5 class="mt-3">{{ __('Editar Paciente') }} <strong>{{ $paciente->nombre }} {{ $paciente->apellido_pat }} {{ $paciente->apellido_mat }} </strong></h5>
                    </div>
                   
                </div>

                <div class="card-body " style="background-color: #f2f7fd;">
                    <form id="editPacienteForm" method="POST" action="{{ route("tenant.paciente.update",["id" => $paciente->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body row">
    
    
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del Paciente</label>
                                    <input type="text" class="form-control col-md-6" id="nombre" name="nombre" value="{{ $paciente->nombre }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="apellido_pat" class="form-label">Apellido paterno</label>
                                    <input type="text" class="form-control col-md-6" id="apellido_pat" name="apellido_pat" value="{{ $paciente->apellido_pat }}"
                                        required>
                                </div>
    
                                <div class="mb-3">
                                    <label for="apellido_mat" class="form-label">Apellido materno</label>
                                    <input type="text" class="form-control col-md-6" id="apellido_mat" name="apellido_mat" required value="{{ $paciente->apellido_mat }}">
                                </div>
                                <div class="mb-3">
                                    <label for="rut" class="form-label">RUT</label>
                                    
                                    <input type="text" class="form-control col-md-6" id="rut" name="rut" required value="{{ $paciente->rut }}">

    
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control col-md-6" id="fecha_nacimiento" name="fecha_nacimiento" required value="{{ $paciente->fecha_nacimiento }}">

                                </div>
                              
                            </div>
                            <div class="col-md-6">
                                
                                <div class="mb-3">
                                    <label for="genero" class="form-label">Genero/Sexo</label>
                                    <select name="genero" id="genero" class="form-control">
                                        <option value="Masculino" @selected($paciente->genero == 'Masculino')>Masculino</option>
                                        <option value="Femenino" @selected($paciente->genero == 'Femenino')>Femenino</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Telefono</label>
                                    <input type="text" class="form-control col-md-6" id="telefono" name="telefono"
                                        required value="{{ $paciente->telefono }}">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="text" class="form-control col-md-6" id="email" name="email"
                                        required value="{{ $paciente->email }}">
                                </div>
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control col-md-6" id="direccion" name="direccion"
                                        required value="{{ $paciente->direccion }}">
                                </div>
                                <div class="mb-3">
                                    <label for="id_pais" class="form-label">País</label>
                                   <select name="id_pais" id="id_pais" class="form-control select2">
                                        @foreach ($paises as $pais)
                                            <option value="{{ $pais->id }}" {{ $pais->id == $paciente->id_pais ? 'selected' : '' }}>
                                                {{ $pais->nombre }}
                                            </option>
                                        @endforeach
                                   </select>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="text-end">
                                <button class="btn btn-primary"id="saveButton">Guardar</button>
                            </div>
    
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
 <br>
 <br>
 <br>
 <br>
   
@endsection
@section('js_after')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>

$(document).ready(function() {

    // Inicializar Select2
    $('#id_pais').select2({
        placeholder: '--selecciona una opción--',
        allowClear: true,
        width: '100%'
    });

     // Manejar el envío del formulario
     $('#editPacienteForm').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío por defecto del formulario
        $.ajax({
            url: $(this).attr('action'), // URL del formulario
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Mostrar SweetAlert según el resultado
                if (response.success) {
                    Swal.fire({
                        title: 'Éxito!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("tenant.paciente.show", ["id" => $paciente->id]) }}';
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr) {
                // Manejo de errores
                Swal.fire({
                    title: 'Error!',
                    text: 'Ocurrió un error en el servidor.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});

</script>
@endsection
