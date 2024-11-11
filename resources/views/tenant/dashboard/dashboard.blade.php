@extends('layouts.menuTenant')
@section('title')
    Panel de control
@endsection

@section('css_before')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>


</style>
@endsection
@section('content')

<div class="container" >
        <div class="row m-3">
            <div class="col-10">
                <h3>Panel de Control</h3>
            </div>
            <div class="col-2 text-end">
            </div>
        </div>
        <div class="row m-3" >
            <div class="col-md-2 mt-3">
                <div class="card" > 
                    <div class="card-header text-center">
                        <h5>{{ __('Total Pacientes') }}</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                      {{ $pacientesTotal }}
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-3">
                <div class="card " > 
                    <div class="card-header text-center">
                        <h5>{{ __('Pacientes hoy') }}</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                      {{ $pacientesHoy }}
                    </div>
                </div>
            </div>
           
            <div class="col-md-2 mt-3">
                <div class="card"> 
                    <div class="card-header text-center">
                        <h5>{{ __('Total Citas') }}</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                   {{ $citasTotal }}
                    </div>
                </div>
            </div>
           
            <div class="col-md-2 mt-3">
                <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                    <div class="card-header text-center">
                        <h5>{{ __('Citas hoy') }}</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                      
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-3">
                <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                    <div class="card-header text-center">
                        <h5>{{ __('Total Consultas') }}</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                      {{ $consultasTotal }}
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-3">
                <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                    <div class="card-header text-center">
                        <h5>{{ __('Consultas hoy') }}</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                      {{ $consultasHoy }}
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-3">
                <div class="card "> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                    <div class="card-header justify-content-end">
                        <h5>{{ __('Total Usuarios') }}</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        {{ $userTotal }}
                    </div>
                </div>
            </div>
           
        </div>
    <div class="row justify-content-center m-3">
        <div class="col-md-12 mt-5">
            <div class="card " style="height: 500px;"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header justify-content-end">
                    <div class="row no-margin-row">
                        <div class="col-9">
                            <h5>{{ __('Gráfico de Pacientes Creados Mensual') }}</h5>
                        </div>
                        <div class="col-3 row no-margin-row">
                            <select name="years" id="years" class="form-select">
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="pacientesChart" ></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 m-5">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        
     
        //grafico barra clinicas
        const ctx = document.getElementById('pacientesChart').getContext('2d');
        let pacientesChart;

        function loadChart(year) {
            $.ajax({
                url: '/pacientes-data', // Ruta a tu controlador para obtener datos
                type: 'GET',
                data: { year: year }, // Enviar el año seleccionado
                success: function(data) {
                    const labels = [
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ];
                    const values = new Array(12).fill(0); // Inicializa los valores en cero para cada mes

                    // Llena el array de valores con los datos obtenidos
                    data.forEach(item => {
                        values[item.month - 1] = item.count; // item.month debe ser el número del mes (1-12)
                    });

                    if (pacientesChart) {
                        pacientesChart.destroy(); // Destruir el gráfico anterior si existe
                    }

                    pacientesChart = new Chart(ctx, {
                        type: 'bar', // Tipo de gráfico
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Pacientes Creados',
                                data: values,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: 'Clientes Creados por Mes'
                                }
                            }
                        }
                    });
                },
                error: function() {
                    console.error('No se pudieron cargar los datos.');
                }
            });
        }

        // Cargar el gráfico inicial con el año seleccionado por defecto
        loadChart($('#years').val());

        // Cambiar el gráfico cuando se seleccione un nuevo año
        $('#years').change(function() {
            loadChart($(this).val());
        });
    });
</script>
@endsection