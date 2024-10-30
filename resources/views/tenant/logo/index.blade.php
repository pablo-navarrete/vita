@extends('layouts.menuTenant')
@section('css_before')
<link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="">
    <div class="row justify-content-center">
        <h4 class="mb-4">Logo </h4>
       

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                        {{ __('Logo en todo el sistema') }}
                    
                    
                </div>

                <div class="card-body row mx-0">
                 

                    
                    <div class="col-6 text-center">
                        @if($logo)
                        <img src="{{ asset($logo->image_url) }}" alt="Logo" style="width: 200px; height: 200px;">
                        @else
                        No hay logo
                        @endif
                    </div>
                    <div class="col-6 ">
                        <form id="logoForm" method="POST" enctype="multipart/form-data" action="{{ route('tenant.logo.store') }}">
                            @csrf <!-- Asegúrate de incluir el token CSRF -->
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Subir Logo (imagen de tipo PNG, JPEG, JPG, SVG)</label>
                                <input type="file" id="fileInput" name="filepond" accept="image/svg+xml, image/png, image/jpeg, image/jpg">
                            </div>
                    
                            <div class="mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select class="form-control col-md-6" id="status" name="status" required>
                                    <option value="1">Activado</option>
                                    <option value="0">Desactivado</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>

        
   
   


</div>
@endsection
@section('js_after')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
$(document).ready(function() {
          // Inicializa FilePond para imagen
     const filePondImage = FilePond.create(document.querySelector('input[name="filepond"]'), {
        server: {
            revert: null, // No manejar la eliminación en el servidor
        },
        maxFiles: 1, // Solo permite una imagen
        acceptedFileTypes: ['image/*'],
        labelIdle: 'Arrastra y suelta una imagen o haz clic para seleccionar',
        credits: false,
        onprocessfile: (error, file) => {
            if (error) {
                console.error('Error al procesar el archivo:', error);
            }
        }
    });

     // Enviar archivos cuando se presiona el botón Guardar
     $('#logoForm').on('submit', function(event) {
            event.preventDefault(); // Evitar el envío automático del formulario
            const formData = new FormData();

            // Agregar datos del formulario
            $(this).find('input , select').each(function() {
                if (this.name && this.value) {
                    formData.append(this.name, this.value);
                }
            });

            // Agregar archivos a FormData
            filePondImage.getFiles().forEach(fileItem => {
                formData.append('filepond', fileItem.file);
            });

            // Enviar datos con AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Mostrar el mensaje de éxito con SweetAlert
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Logo se ha guardado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirigir a la ruta 
                            window.location.href = '/logo'; // Cambia la URL según sea necesario
                        }
                    });
                },
                error: function(response) {
                    // Manejo de errores
                    console.error('Error al guardar el logo:', response);
                }
            });

        });

});
    

 
</script>
@endsection
