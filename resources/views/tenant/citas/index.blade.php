@extends('layouts.menuTenant')
@section('title', 'Listado de citas')

@section('css_before')
<style>




/* Estilo para los eventos */
.fc-event {
    background-color: #FF5733;  /* Color de fondo */
    color: white;  /* Color del texto */
    border-radius: 5px;  /* Bordes redondeados */
    padding: 5px;
    font-size: 14px;
}

/* Cambiar el color de los días actuales */
.fc-day.fc-day-today {
    background-color: #e0e0e0;
}



/* Cambiar color de fondo del encabezado del mes */
.fc-dayGridMonth-view .fc-col-header {
    background-color:  rgb(192, 233, 250); /* Cambiar a tu color deseado */
    color: white; /* Cambiar el color del texto */
}

/* Cambiar color de fondo del encabezado de los días */
.fc-dayGridDay-view .fc-col-header {
    background-color:  rgb(192, 233, 250); /* Cambiar a tu color deseado */
    color: white; /* Cambiar el color del texto */
}

/* Cambiar color de fondo del encabezado de la semana */
.fc-timeGridWeek-view .fc-col-header {
    background-color:  rgb(192, 233, 250); /* Cambiar a tu color deseado */
    color: white; /* Cambiar el color del texto */
}
/*color de encabezado titulo*/
.fc-toolbar-title {
    background-color: #2196F3; /* Cambia a tu color deseado */
    color: white; /* Cambia el color del texto si es necesario */
    padding: 5px; /* Ajusta el espaciado si lo necesitas */
    border-radius: 4px; /* Opcional: para darle bordes redondeados */
}





</style>

@endsection

@section('content')
    <div class="container mt-5">
        <h3>Calendario de Citas Médicas</h3>
        <div id='calendar' style="height: auto;"></div>
    </div>
    <br>
    <br>
    <br>

@endsection

@section('js_after')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/es.global.min.js"></script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
     var calendarEl = document.getElementById('calendar');
     var calendar = new FullCalendar.Calendar(calendarEl, {
         locale: 'es',  // Cambiar a español
         initialView: 'dayGridMonth',  // Vista inicial (Mes)
         headerToolbar: {
             left: 'prev,next today',  // Botones de navegación
             center: 'title',  // Título en el centro
             right: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay'  // Botones de vistas
         },
         events: [
             {
                 title: 'Cita Médica',
                 start: '2024-11-10T10:00:00',
                 end: '2024-11-10T11:00:00'
             }
         ]
     });
     calendar.render();
  });
    </script>
@endsection
