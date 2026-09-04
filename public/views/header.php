<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/calendar.css">
    <title><?= isset($title) ? h($title) : 'Mon calendrier'; ?></title>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary mb-3">
        <a href="/index.php" class="navbar-brand">Mon Calendrier</a>
    </nav>