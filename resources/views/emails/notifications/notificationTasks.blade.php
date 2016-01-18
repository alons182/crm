<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recordatorio de tarea</title>
</head>
<body>
<p>Este es un recordario de la tarea <b>{{ $task->title }}</b> que tienes que realizar el <b>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $task->notification_date)->format('Y-m-d') }}</b> a las <b>{{ $task->notification_time }}</b></p>
<h2>Descripcion de la tarea:</h2>
<p>{{ $task->description }}</p>

</body>
</html>