<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <title>DASHBOARD</title>
</head>
<body class="bg-dark text-light">
    <header class = 'container'>
        <h1 class='ps-2 bg-warning text-dark'><?= esc($title)?></h1>

        <a class='btn text-decoration-none text-light' href='/new'>
            <button id='new' type='submit' class='btn btn-secondary'>
                Add new
            </button>
        </a>
        <a class='btn text-decoration-none text-light' href='/login'>
            <button id='login' type='submit' class='btn btn-secondary'>
                Test login
            </button>
        </a>
        <a class='btn text-decoration-none text-light' href='/users'>
            <button id='all' type='submit' class='btn btn-warning'>
                Show all accounts
            </button>
        </a>
        <a class='btn text-decoration-none text-light' href='/'>
            <button type='submit' class='btn btn-info'>
                New Search
            </button>
        </a>
        <hr>
    </header>
    <main class="container clearfix">