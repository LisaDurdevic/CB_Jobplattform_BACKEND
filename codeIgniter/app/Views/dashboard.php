<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <title>CB Jobplattform</title>
</head>
<body class="bg-dark text-light">
    <header>
        <h1 class='container ps-2 bg-warning text-dark'>CB Jobplattform DB DASHBOARD</h1>
    </header>

    <main class="container clearfix">
        <hr>
        <!--input form to add new accounts, pull all accounts and to test login-->
                
        <a class='btn text-decoration-none text-light' href='./new'>
            <button id='new' type='submit' class='btn btn-secondary'>
                Add new
            </button>
        </a>
        <a class='btn text-decoration-none text-light' href='./login'>
            <button id='login' type='submit' class='btn btn-secondary'>
                Test login
            </button>
        </a>
        <a class='btn text-decoration-none text-light' href='./users'>
            <button id='all' type='submit' class='btn btn-warning'>
                Show all accounts
            </button>
        </a>
        <form id='restart' class='btn'>
            <button type='submit' class='btn btn-info'>
                New Search
            </button>
        </form>
        <hr>

        <form id='userName-input' class='container' method='post' action="/user/search">
            <p class='row'>
                <label for='userName' class='col-sm fw-bold'>
                    Username:
                </label>
                <input
                    type='text'
                    id='userName'
                    name='userName'
                    class='col-sm'
                    value=''
                    required
                    autofocus/>
            </p>
            <button id='search' type='submit' class='btn btn-secondary'>
                Search
            </button>
        </form>
        <hr>
    </main>
</body>
</html>