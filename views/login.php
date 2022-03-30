<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Test Login</title>
</head>
<body class="bg-dark text-light">
    <header>
        <h1 class='container ps-2 bg-warning text-dark'>TEST LOGIN DATA</h1>
    </header>

    <main class="container clearfix">
        <?php
            include("../utils/Profile.inc.php");
            $profile = new Profile;

            if (isset($_GET['login'])) { //check login
        ?>
                <p class='row bg-info text-dark'>
        <?php
                    $profile->login($_POST['mail'], $_POST['password']);
        ?>
                </p>
        <?php
            }

            $fields = array(['"mail"', 'Mailaddress:', '"email" required'],
                            ['"password"', 'Password:', '"password" required placeholder = "enter new password for reset"']);

            for ($i = 0; $i < sizeOf($fields); $i++) {
        ?>
                <form id='login-input' class='container' method='post' action='?login'>

                    <p class='row'>
                        <label for=<?php echo $fields[$i][0]?> class='col-sm'>
                            <?php echo $fields[$i][1]?>
                        </label>
                        <input
                            type= <?php echo $fields[$i][2]?>
                            id= <?php echo $fields[$i][0]?>
                            name= <?php echo $fields[$i][0]?>
                            class='col-sm'
                            />
                    </p>
        <?php
            }
        ?>
                    <button id='login' type='submit' class='btn btn-success'>
                        Try
                    </button>
                </form>

            <hr>
            <a class='text-decoration-none text-light' href='./index.php'>
                <button id='new' type='submit' class='btn btn-info'>
                    Back to Dashboard
                </button>
            </a>
    </main>
</body>
</html>