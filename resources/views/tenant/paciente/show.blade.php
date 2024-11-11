@extends('layouts.menuTenant')
@section('title')
    Detalle de paciente
@endsection

@section('css_before')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
    <div class="container">

        <div class="row ">
            <div class="col-8">
                <h3 class="mb-4 mt-3">Detalles del Paciente</h3>
            </div>
            <div class="col-4 text-end mt-4">
              <a href="{{ route('tenant.paciente.index') }}" class="miga">Listado de Pacientes</a> / <span style="color: rgb(21, 146, 242);">Detalle del Paciente</span>
             </div>
       </div>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header row mx-0" style="background-color: rgb(192, 233, 250);">
                    <div class="col-md-10">
                        <h5 class="mt-3"><strong>{{ $paciente->nombre}} {{ $paciente->apellido_pat}} {{ $paciente->apellido_mat}} </strong></h5>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route("tenant.paciente.edit", ["id" => $paciente->id]) }}" class="btn btn-primary mt-2">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <a href="{{ route("tenant.preconsulta.create", ["id" => $paciente->id]) }}" class="btn btn-primary mt-2">
                            <i class="fa-solid fa-stethoscope"></i>
                        </a>
                        <a href="#" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#historialMedicoModal">
                            <i class="fa-solid fa-file"></i>
                        </a>
                        <a href="{{ route('tenant.paciente.create') }}" class="btn btn-primary mt-2">
                            <i class="fa-solid fa-calendar-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body" style="background-color: #f2f7fd;">
                    <div class="">
                        <div class="m-2">
                            <ul>
                                <li><strong>RUT:</strong> {{ $paciente->rut}}</li>
                                <li><strong>Genero:</strong> {{ $paciente->genero}}</li>
                               
                                <li><strong>Telefono:</strong> {{ $paciente->telefono}}</li>
                                <li><strong>Correo electrónico:</strong> {{ $paciente->email}}</li>
                                <li><strong>Dirección:</strong> {{ $paciente->direccion}}</li>
                                <li><strong>País:</strong> {{ $paciente->pais->nombre}}</li>

                            </ul>
                            <hr>
                            <h5>Historial médico</h5>
                          
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
                        
                           
                          
                           
                            <hr>
                            <h5>Historial de Consultas</h5>
                            <ul>
                                <li><strong>Fecha:</strong> </li>
                                <li><strong>Asunto:</strong> </li>
                               <button class="btn btn-primary">Ver más</button>

                            </ul>
                           
                          
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>



  <!-- Modal historial medico-->
  <div class="modal fade" id="historialMedicoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="historialMedicoModalLabel" aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <form id="historialClinico" method="POST" action="{{ route('historial.medico.store') }}">
             @csrf
             <div class="modal-header">
                 <h5 class="modal-title" id="historialMedicoModalLabel">Historial Médico</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <!-- Campo oculto para el id del paciente -->
                 <input type="hidden" id="id_paciente" name="id_paciente" value="{{ $paciente->id}}">
                 
                 <!-- Mostrar los datos del historial en los campos si existen -->
                 <div class="mb-3">
                     <label for="alergias" class="form-label">Alergias</label>
                     <input type="text" class="form-control" id="alergias" name="alergias" required 
                            value="{{ $historialClinico->isEmpty() ? '' : $historialClinico->first()->alergias }}">
                 </div>
                 <div class="mb-3">
                     <label for="antecedentes_medicos" class="form-label">Antecedentes médicos</label>
                     <input type="text" class="form-control" id="antecedentes_medicos" name="antecedentes_medicos" 
                            value="{{ $historialClinico->isEmpty() ? '' : $historialClinico->first()->antecedentes_medicos }}" required>
                 </div>
                 <div class="mb-3">
                     <label for="antecedentes_familiares" class="form-label">Antecedentes familiares</label>
                     <input type="text" class="form-control" id="antecedentes_familiares" name="antecedentes_familiares" 
                            required value="{{ $historialClinico->isEmpty() ? '' : $historialClinico->first()->antecedentes_familiares }}">
                 </div>
                 <div class="mb-3">
                     <label for="medicamentos_actuales" class="form-label">Medicamentos actuales</label>
                     <input type="text" class="form-control" id="medicamentos_actuales" value="{{ $historialClinico->isEmpty() ? '' : $historialClinico->first()->medicamentos_actuales }}" 
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
  // Manejar el envío del formulario historial clinico
  $('#historialClinico').on('submit', function(e) {
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
