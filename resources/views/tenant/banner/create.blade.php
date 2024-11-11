@extends('layouts.menuTenant')

@section('css_before')
<link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
    <div class="row">
        <div class="col-md-8">
            <h3 class="mb-4 mt-3">Crear Banner</h3>
        </div>
        <div class="col-4 text-end mt-4">
            <a href="{{ route('tenant.paciente.index') }}" class="miga">Listado de Banners</a> / <span style="color: rgb(21, 146, 242);">Crear Banner</span>

        </div>
    </div>
    
    
   
    <div class="col-md-12 mt-4">
        
        <div class="card">
            <div class="card-header">
                <h5 class="mt-3">{{ __('Crear nuevo Banner') }}</h5>
            </div>
            <form id="bannerForm" method="POST" action="{{ route('tenant.banner.store') }}" enctype="multipart/form-data">
                @csrf
            <div class="card-body ">
               
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Nombre del Banner</label>
                            <input type="text" class="form-control col-md-6" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" class="form-control col-md-6" id="description" name="description" required>
                        </div>
                     
                        <div class="mb-3">
                            <label for="name_button" class="form-label">Nombre del Botón</label>
                            <input type="text" class="form-control col-md-6" id="name_button" name="name_button" required>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" class="form-control col-md-6" id="url" name="url" required>

                            
                        </div>


                       
                       
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Subir Imagen/Portada</label>
                            <input type="file" id="fileInput" name="filepond" accept="image/*">
                        </div>
                       
                      <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-control col-md-6" id="status" name="status" required>
                                <option value="1">Activado</option>
                                <option value="0">Desactivado</option>
                            </select>

                            
                        </div>
                      
                    </div>
                    <hr class="my-3">
                    <div class=" text-end">
                        <button class="btn btn-primary"id="saveButton">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@section('js_after')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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
      $('#bannerForm').on('submit', function(event) {
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
                        text: 'Banner se ha guardado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                           
                            window.location.href = '/banner'; // Cambia la URL según sea necesario
                        }
                    });
                },
                error: function(response) {
                    // Manejo de errores
                    console.error('Error al guardar el banner:', response);
                }
            });

        });
         
});
    
   

    

 
</script>
@endsection
