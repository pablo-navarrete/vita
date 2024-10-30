@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('css_before')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    .contenedor{
            margin-top: 80px;
    }
    #servicioChart {
        max-width: 100%; /* El gráfico ocupará el 100% del ancho del contenedor */
        height: auto; /* La altura se ajustará automáticamente */
    }

    .chart-container {
        height: 350px; /* Altura del contenedor del gráfico */
        display: flex; /* Permite centrar el canvas dentro del contenedor */
        justify-content: center; /* Centrar horizontalmente */
        align-items: center; /* Centrar verticalmente */
    }
</style>
@endsection

@section('content')
<div class="container contenedor" >
    <div class="row mt-2 mb-3 me-2 ms-2">
        <div class="col-10">
            <h3>Dashboard</h3>
        </div>
        <div class="col-2 text-end">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 mt-2">
            <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header d-flex align-items-center">
                    <h5>{{ __('Total Clientes') }}</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                   {{ $clinicasTotal }}
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-2">
            <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header justify-content-end">
                    <h5>{{ __('Total Clientes Activos') }}</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                   {{ $clinicasStatusActive }}
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-2">
            <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header d-flex align-items-center">
                    <h5>{{ __('Total Clientes Inactivos') }}</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                   {{ $clinicasStatusInactive }}
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-2">
            <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header justify-content-end">
                    <h5>{{ __('Total Clientes Atrasados') }}</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                   {{ $clinicasAtrasados }}
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-2">
            <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header justify-content-end">
                    <h5>{{ __('Total Clientes Pagados') }}</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                   {{ $clinicasPagados }}
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-2">
            <div class="card"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header justify-content-end">
                    <h5>{{ __('Clientes Mes Gratis') }}</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                   {{ $clinicasMes }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mt-3">
            <div class="card h-100"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header d-flex align-items-center">
                    <h5>{{ __('Gráfico de Servicios Usados') }}</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container mb-3" style="width: 100%;">
                        <canvas id="servicioChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card h-100"> <!-- Usar h-100 para hacer que el card ocupe toda la altura disponible -->
                <div class="card-header justify-content-end">
                    <div class="row no-margin-row">
                        <div class="col-9">
                            <h5>{{ __('Gráfico de Clientes Creados Mensual') }}</h5>
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
                    <canvas id="clinicasChart" width="700px;"></canvas>
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
        
        //grafico circular servicios
        $.ajax({
            url: '/servicio-data', // Asegúrate de que esta ruta apunte a tu controlador
            type: 'GET',
            success: function(data) {
                const labels = data.map(item => item.servicio);
                const values = data.map(item => item.total);

                const ctx = document.getElementById('servicioChart').getContext('2d');
                const servicioChart = new Chart(ctx, {
                    type: 'pie', // Puedes usar 'pie', 'doughnut', etc.
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Servicios',
                            data: values,
                            backgroundColor: [
                                '#36A2EB', // Azul para 'Básico'
                                '#4CAF50', // Verde para 'Estándar'
                                '#FFCE56'  // Amarillo para 'Premium'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Permite que el gráfico se ajuste al tamaño del contenedor
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    generateLabels: function(chart) {
                                        const original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
                                        const labels = original.call(this, chart);
                                        const data = chart.data.datasets[0].data;

                                        // Agrega los valores a las etiquetas
                                        labels.forEach((label, index) => {
                                            label.text += ': ' + data[index];
                                        });

                                        return labels;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Distribución de Servicios'
                            }
                        }
                    }
                });
            },
            error: function() {
                console.error('No se pudo cargar los datos.');
            }
        });

        //grafico barra clinicas
        const ctx = document.getElementById('clinicasChart').getContext('2d');
        let clinicasChart;

        function loadChart(year) {
            $.ajax({
                url: '/clinicas-data', // Ruta a tu controlador para obtener datos
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

                    if (clinicasChart) {
                        clinicasChart.destroy(); // Destruir el gráfico anterior si existe
                    }

                    clinicasChart = new Chart(ctx, {
                        type: 'bar', // Tipo de gráfico
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Clientes Creados',
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
