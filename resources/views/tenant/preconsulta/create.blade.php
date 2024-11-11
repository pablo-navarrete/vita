@extends('layouts.menuTenant')
@section('title')
    Crear pre-consulta
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
                <h3 class="mb-4 mt-3">Crear Pre-consulta</h3>
            </div>
         
       </div>
        
        
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header row mx-0" >
                    <div class="col-md-10">
                        <h5 class="mt-3">{{ $paciente->nombre }} {{ $paciente->apellido_pat }} {{ $paciente->apellido_mat }} - {{ $paciente->rut }}</h5>
                    </div>
                   
                </div>

                <div class="card-body " >
                    <form id="preconsultaForm" method="POST" action="{{ route('tenant.preconsulta.store') }}">
                        @csrf
                        <div class="card-body row">
                            <input type="hidden" name="paciente_id" id="paciente_id" value="{{ $paciente->id }}">
                    
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cita_id" class="form-label">Cita médica</label>
                                    <select name="cita_id" id="cita_id" class="form-control">
                                      
                                            <option value="1">22/08/2024 17:00</option>
                                        
                                    </select>
                                    @error('cita_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                    
                                <div class="mb-3">
                                    <label for="motivo_consulta" class="form-label">Motivo de la consulta</label>
                                    <input type="text" class="form-control" id="motivo_consulta" name="motivo_consulta" required>
                                    @error('motivo_consulta')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                    
                                <div class="mb-3">
                                    <label for="sintomas" class="form-label">Síntomas</label>
                                    <input type="text" class="form-control" id="sintomas" name="sintomas" required>
                                    @error('sintomas')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                    
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" cols="30" rows="5" class="form-control"></textarea>
                                    @error('observaciones')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                    
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h4>Datos del paciente</h4>
                                    <ul>
                                        <li><strong>RUT:</strong> {{ $paciente->rut }}</li>
                                        <li><strong>Género:</strong> {{ $paciente->genero }}</li>
                                        <li><strong>Teléfono:</strong> {{ $paciente->telefono }}</li>
                                        <li><strong>Correo electrónico:</strong> {{ $paciente->email }}</li>
                                        <li><strong>Dirección:</strong> {{ $paciente->direccion }}</li>
                                        <li><strong>País:</strong> {{ $paciente->pais->nombre }}</li>
                                    </ul>
                                </div>
                    
                                <hr>
                    
                                <div class="mb-3">
                                    <h4>Historial médico</h4>
                                    @if($historialClinico->isEmpty())
                                        <p>No hay datos disponibles para mostrar.</p>
                                    @else
                                        @foreach($historialClinico as $historial)
                                            <ul>
                                                <li><strong>Alergias:</strong> {{ $historial->alergias }}</li>
                                                <li><strong>Antecedentes médicos:</strong> {{ $historial->antecedentes_medicos }}</li>
                                                <li><strong>Antecedentes familiares:</strong> {{ $historial->antecedentes_familiares }}</li>
                                                <li><strong>Medicamentos actuales:</strong> {{ $historial->medicamentos_actuales }}</li>
                                            </ul>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                    
                            <hr class="my-3">
                    
                            <div class="text-end">
                                <button class="btn btn-primary" id="saveButton">Guardar</button>
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
 $('#preconsultaForm').on('submit', function(e) {
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
                        // Redirigir a la página de índice
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
