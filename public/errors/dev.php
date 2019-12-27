<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ошибка</title>
</head>
<body>
    <h1>Произошла ошибка</h1>
    <p>Код ошибки: <?= $errno ?></p>
    <p>Текст ошибки: <?= $errstr ?></p>
    <p>Файл ошибки: <?= $errfile ?></p>
    <p>Строка с ошибкой: <?= $errline ?></p>
</body>
</html>
